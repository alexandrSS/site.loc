<?php

namespace backend\modules\user\controllers;

use Yii;
use common\modules\user\models\User;
use backend\modules\user\models\UserSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\modules\admin\components\Controller;
use common\modules\user\models\LoginForm;

/**
 * Основной контроллер backend модуля [[User]]
 */
class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index','error'],
                        'roles' => [ 'indexUser' ]
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => [ 'viewUser' ]
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create','error'],
                        'roles' => [ 'createUser' ]
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update','error'],
                        'roles' => [ 'updateUser' ]
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete','error'],
                        'roles' => [ 'deleteUser' ]
                    ],
                    [
                        'allow' => false
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Выводиим все записи.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->get());
        $roleArray = User::getRoleArray();
        $statusArray = User::getStatusArray();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'roleArray' => $roleArray,
            'statusArray' => $statusArray,
        ]);
    }

    /**
     * Выводим одну запись.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Создаем новую запись.
     * В случае успеха, пользователь будет перенаправлен на "view" метод.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User(['scenario' => 'admin-create']);
        $roleArray = User::getRoleArray();
        $statusArray = User::getStatusArray();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'roleArray' => $roleArray,
                'statusArray' => $statusArray,
            ]);
        }
    }

    /**
     * Обновляем запись.
     * В случае успеха, пользователь будет перенаправлен на "view" метод.
     * @param integer $id Идентификатор модели
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->setScenario('admin-update');
        $roleArray = User::getRoleArray();
        $statusArray = User::getStatusArray();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'roleArray' => $roleArray,
                'statusArray' => $statusArray,
            ]);
        }
    }

    /**
     * Удаляем запись.
     * В случае успеха, пользователь будет перенаправлен на "index" метод.
     * @param integer $id Идентификатор модели.
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    /**
     * Авторизируем пользователя
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = '@backend/modules/user/views/layouts/main';
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
     * Деавторизируем пользователя
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**Поиск модели по первичному ключу.
     * Если модель не найдена, будет вызвана 404 ошибка.
     * @param integer $id Идентификатор модели.
     * @return User Найденая модель.
     * @throws NotFoundHttpException Если модель не найдена.
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
