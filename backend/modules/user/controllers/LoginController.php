<?php

namespace backend\modules\user\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use common\modules\user\models\LoginForm;

/**
 * Контроллер Авторизации Bakcend приложенния
 */
class LoginController extends Controller
{

    public $layout = '//login';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?']
                    ]
                ]
            ]
        ];
    }

    /**
     * Login user.
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->login()) {
                    return $this->goHome();
                }
            } elseif (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        }

        return $this->render(
            'index',
            [
                'model' => $model
            ]
        );
    }
}