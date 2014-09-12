<?php

namespace backend\modules\pages\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\pages\models\Category;
use backend\modules\pages\models\SearchCategory;
use backend\modules\admin\components\Controller;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
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
                        'roles' => [ 'indexCategory' ]
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => [ 'viewCategory' ]
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => [ 'createCategory' ]
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => [ 'updateCategory' ]
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => [ 'deleteCategory' ]
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
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchCategory();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $viewArray = Category::getPageViewArray();
        $positionArray = Category::getCategoryPositionArray();
        $statusArray = Category::getCategoryStatusArray();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'viewArray' => $viewArray,
            'positionArray' => $positionArray,
            'statusArray' => $statusArray,
        ]);
    }

    /**
     * Displays a single Category model.
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
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Category();
        $categoryArray = Category::getCategoryArray();
        $viewArray = Category::getPageViewArray();
        $positionArray = Category::getCategoryPositionArray();
        $statusArray = Category::getCategoryStatusArray();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'categoryArray' => $categoryArray,
                'viewArray' => $viewArray,
                'positionArray' => $positionArray,
                'statusArray' => $statusArray,
            ]);
        }
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $categoryArray = Category::getCategoryArray();
        $viewArray = Category::getPageViewArray();
        $positionArray = Category::getCategoryPositionArray();
        $statusArray = Category::getCategoryStatusArray();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'categoryArray' => $categoryArray,
                'viewArray' => $viewArray,
                'positionArray' => $positionArray,
                'statusArray' => $statusArray,
            ]);
        }
    }

    /**
     * Deletes an existing Category model.
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
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
