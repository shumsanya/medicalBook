<?php

namespace app\controllers;

use app\models\FeelingsSearch;
use app\models\Feelings;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FeelingsController implements the CRUD actions for Feelings model.
 */
class FeelingsController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Feelings models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest)
        {
            return Yii::$app->response->redirect(['site/login']);
        }

        $searchModel = new FeelingsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

//        $dataProvider = new ActiveDataProvider([
//            'query' => Feelings::find(),
//            /*
//            'pagination' => [
//                'pageSize' => 50
//            ],
//            'sort' => [
//                'defaultOrder' => [
//                    'id' => SORT_DESC,
//                ]
//            ],
//            */
//        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Feelings model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (Yii::$app->user->isGuest)
        {
            return Yii::$app->response->redirect(['site/login']);
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Feelings model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->isGuest)
        {
            return Yii::$app->response->redirect(['site/login']);
        }

        $model = new Feelings();
        $model->date = date('Y-m-d');    // текущяя дата по умолчанию;
        $model->user_id = Yii::$app->user->identity->getId();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        $array_organ_select = array();
        $for_select = Feelings::find()
            ->select('organ')
            ->where(['user_id' => $model->user_id])
            ->distinct()
            ->all();

        if($for_select){
            foreach ($for_select as $organ){
                $array_organ_select[] = $organ->organ;
            }
        };

        return $this->render('create', [
            'model' => $model,
            'array_organ_select' => $array_organ_select,
        //    'dataList' => $dataList
        ]);
    }

    /**
     * Updates an existing Feelings model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->isGuest)
        {
            return Yii::$app->response->redirect(['site/login']);
        }

        $model = $this->findModel($id);
        $model->user_id = Yii::$app->user->identity->getId();

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Feelings model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->isGuest)
        {
            return Yii::$app->response->redirect(['site/login']);
        }

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Feelings model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Feelings the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Feelings::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
