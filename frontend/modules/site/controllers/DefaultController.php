<?php

namespace frontend\modules\site\controllers;

use Yii;
use frontend\modules\site\components\Controller;
use frontend\modules\site\models\ContactForm;


/**
 * Основной контроллер frontend модуля [[site]]
 */
class DefaultController extends Controller
{
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
     * Главная страница сайта
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Страница обратной связи
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Страница "О нас"
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
