<?php

namespace backend\modules\pages\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use backend\modules\pages\models\Pages;
use backend\modules\pages\models\Category;
use backend\modules\pages\models\SearchPages;
use backend\modules\admin\components\Controller;

/**
 * PagesController implements the CRUD actions for Pages model.
 */
class PagesController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index','error'],
                        'roles' => [ 'indexPage' ]
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => [ 'viewPage' ]
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => [ 'createPage' ]
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => [ 'updatePage' ]
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => [ 'deletePage' ]
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
     * Lists all Pages models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchPages();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $statusArray = Pages::getPagesStatusArray();
        $categoryArray = Category::getCategoryArray();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'statusArray' => $statusArray,
            'categoryArray' => $categoryArray
        ]);
    }

    /**
     * Displays a single Pages model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $statusArray = Pages::getPagesStatusArray();
        $categoryArray = Category::getCategoryArray();
        
        return $this->render('view', [
            'model' => $this->findModel($id),
            'statusArray' => $statusArray,
            'categoryArray' => $categoryArray,
        ]);
    }

    /**
     * Creates a new Pages model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Pages();
        $statusArray = Pages::getPagesStatusArray();
        $categoryArray = Category::getCategoryArray();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'statusArray' => $statusArray,
                'categoryArray' => $categoryArray,
            ]);
        }
    }

    /**
     * Updates an existing Pages model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $statusArray = Pages::getPagesStatusArray();
        $categoryArray = Category::getCategoryArray();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'statusArray' => $statusArray,
                'categoryArray' => $categoryArray,
            ]);
        }
    }

    /**
     * Deletes an existing Pages model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Pages model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pages the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pages::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
