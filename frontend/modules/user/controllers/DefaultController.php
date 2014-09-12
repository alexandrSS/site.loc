<?php

namespace frontend\modules\user\controllers;


use Yii;
use frontend\modules\site\components\Controller;
use common\modules\user\models\User;
use common\modules\user\models\LoginForm;
use frontend\modules\user\models\PasswordResetRequestForm;
use frontend\modules\user\models\ResetPasswordForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;


/**
 * Основной контроллер frontend модуля [[User]]
 * @package frontend\modules\user\controllers
 */
class DefaultController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }


    /**
     * Авторизация пользователя
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Деавторизация пользователя
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Редактируем пользователя
     */
    public function actionEdit()
    {
        // Выбераем текущего пользователя
        if($model = User::findOne(Yii::$app->user->id)){
            $model->setScenario('edit');

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                // В случае успешного обновления данных, оповещаем пользователя об этом, и перенаправляем его на страницу профиля.
                Yii::$app->session->setFlash('success', Yii::t('user', 'Данные профиля были успешно обновлены!'));
                return $this->redirect(['view', 'username' => $model->username]);
            }
            // Рендерим представление.
            return $this->render('edit', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Регистрация пользователя
     * @return string|\yii\web\Response
     */
    public function actionSignup()
    {
        $model = new User(['scenario' => 'signup']);
        // Обработчи отправляющий сообщение с ключем активации на e-mail
        if($this->module->activeAfterRegistration === false){
            $model->on(User::EVENT_AFTER_INSERT, [$this->module, 'onSignup']);
        }

        if($model->load(Yii::$app->request->post()) && $model->save()){
            //
            if($this->module->activeAfterRegistration === false){
                Yii::$app->session->setFlash('success', Yii::t('user', 'Учётная запись была успешно создана. Через несколько секунд вам на почту будет отправлен код для активации аккаунта. В случае если письмо не пришло в течении 15 минут, вы можете заново запросить отправку ключа по данной <a href="{url}">ссылке</a>. Спасибо!', ['url' => Url::toRoute('resend')]));
            }else{
                // Авторизируем пользователя
                Yii::$app->getUser()->login($model);
                // Сообщаем, что регистрация прошла успешно
                Yii::$app->session->setFlash('success', Yii::t('users', 'Учётная запись была успешно создана!'));
            }
            // Возвращаем пользователя на главную
            return $this->goHome();
        }
        // Рендерим представление
        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Повторно отправляем ключ активации по запросу.
     */
    public function actionResend()
    {
        $model = new User(['scenario' => 'resend']);
        // Добавляем обработчик события который отправляет сообщение с клюом активации на e-mail адрес что был указан при запросе его повторной отправке.
        $model->on(User::EVENT_AFTER_VALIDATE_SUCCESS, [$this->module, 'onResend']);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // Сообщаем пользователю что ключ активации был повторно отправлен на его электронный адрес.
            Yii::$app->session->setFlash('success', Yii::t('users', 'На указанный почтовый адрес был отправлен новый код для активации учётной записи. Спасибо!'));
            // Перенаправляем пользователя на главную страницу сайта.
            return $this->goHome();
        }
        // Рендерим представление.
        return $this->render('resend', [
            'model' => $model
        ]);
    }


    /**
     * @param $email
     * @param $key
     * @return \yii\web\Response
     */
    public function actionActivation($email, $key)
    {
        if ($model = User::find()->where(['and', 'email = :email', 'auth_key = :auth_key'], [':email' => $email, ':auth_key' => $key])->inactive()->one()) {
            $model->setScenario('activation');
            // В случае если запись с введеным e-mail-ом и ключом была найдена, обновляем её и оповещаем пользователя об успешной активации.
            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', Yii::t('user', 'Ваша учётная запись была успешно активирована. Теперь вы можете авторизоватся, и полноценно использовать услуги сайта. Спасибо!'));
            }
        } else {
            // В случае если запись с введеным e-mail-ом и ключом не был найден, оповещаем пользователя об неудачной активации.
            Yii::$app->session->setFlash('danger', Yii::t('user', 'Неверный код активации или возмоможно аккаунт был уже ранее активирован. Проверьте пожалуйста правильность ссылки, или напишите администратору.'));
        }
        // Перенаправляем пользователя на главную страницу сайта.
        return $this->goHome();
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
