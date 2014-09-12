<?php

namespace backend\modules\admin\controllers;

use Yii;
use yii\filters\AccessControl;
use backend\modules\admin\components\Controller;
/*
 * Основной контроллер модуля [[admin]]
 * */
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
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index','error'],
                        'roles' => [ 'indexAdmin' ]
                    ],
                    [
                        'allow' => false
                    ]
                ]
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
        ];
    }

    /*
     * Выводим главную страницу панели управления
     * */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
