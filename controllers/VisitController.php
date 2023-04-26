<?php

namespace app\controllers;

use app\models\Doctor;
use app\models\Hospital;
use app\models\Visit;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * VisitController implements the CRUD actions for Visit model.
 */
class VisitController extends Controller
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
     * Lists all Visit models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest)
        {
            return Yii::$app->response->redirect(['site/login']);
        }

        $user_id = Yii::$app->user->identity->getId();

        $dataProvider = new ActiveDataProvider([
            'query' => Visit::find()->where(['user_id' => $user_id]),

            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],

        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Visit model.
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

        $model = Visit::find()->where(['id' => $id])->asArray()->all();
        $doctor = Doctor::find()->where(['id' => $model[0]['doctor_id']])->asArray()->all();
        $hospital = Hospital::find()->where(['id' => $model[0]['hospital_id']])->asArray()->all();
        $model[0]['doctor'] = $doctor[0]['name'].' - '.$doctor[0]['specialty'];
        $model[0]['hospital'] = $hospital[0]['name'];
        $model = $model[0];

        return $this->render('view', [
            'model' => $model,
            'doctor' => $doctor,
            'hospital' => $hospital,
        ]);
    }

    /**
     * Creates a new Visit model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->isGuest)
        {
            return Yii::$app->response->redirect(['site/login']);
        }
        

        $user_id = Yii::$app->user->identity->getId();
        $model = new Visit();
        $doctor_model = new Doctor();
        $hospital_model = new Hospital();
        $modal_message = false;

        if ($this->request->isPost)
        {
            $model->user_id = $user_id;
            $doctor_model->user_id = $user_id;
            $hospital_model->user_id = $user_id;

            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['index']);
            }
            if ($doctor_model->load($this->request->post()) && $doctor_model->save()) {
                $modal_message = true;
            }
            if ($hospital_model->load($this->request->post()) && $hospital_model->save()) {
                $modal_message = true;
            }
        }
        else
        {
            $model->loadDefaultValues();
        }

        $doctor_list = $this->findDoctor($user_id);
        $hospital_list = $this->findHospital($user_id);

        $model->date = date('Y-m-d');    // текущяя дата по умолчанию;

        return $this->render('create', [
            'model' => $model,
            'doctor_list' => $doctor_list,
            'hospital_list' => $hospital_list,
            'doctor_model' => $doctor_model,
            'hospital_model' => $hospital_model,
            'modal_message' => $modal_message
        ]);
    }

    /**
     * Updates an existing Visit model.
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

        $user_id = Yii::$app->user->identity->getId();
        $doctor_model = new Doctor();
        $hospital_model = new Hospital();
        $modal_message = false;
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            $model->user_id = $user_id;
            $doctor_model->user_id = $user_id;
            $hospital_model->user_id = $user_id;

            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
            if ($doctor_model->load($this->request->post()) && $doctor_model->save()) {
                $modal_message = true;
            }
            if ($hospital_model->load($this->request->post()) && $hospital_model->save()) {
                $modal_message = true;
            }

        }

        $doctor_list = $this->findDoctor($user_id);
        $hospital_list = $this->findHospital($user_id);

        $model->date = date('Y-m-d');    // текущяя дата по умолчанию;

        return $this->render('create', [
            'model' => $model,
            'doctor_list' => $doctor_list,
            'hospital_list' => $hospital_list,
            'doctor_model' => $doctor_model,
            'hospital_model' => $hospital_model,
            'modal_message' => $modal_message
        ]);
    }

    /**
     * Deletes an existing Visit model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Visit model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Visit the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Visit::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findDoctor($user_id)
    {
        $array_doctor = Doctor::find()
            ->where(['user_id' => $user_id])
            ->asArray()
            ->all();

        $doctor_list = [];
        foreach ($array_doctor as $value){
            $doctor_list[$value['id']] = $value['name'].' - '.$value['specialty'].'  '.$value['comments'];
        }

        return $doctor_list;
    }

    protected function findHospital($user_id)
    {
        $array_hospital = Hospital::find()
            ->where(['user_id' => $user_id])
            ->asArray()
            ->all();

        $hospital_list = [];
        foreach ($array_hospital as $value){
            $hospital_list[$value['id']] = $value['name'].'  '.$value['comments'];
        }

        return $hospital_list;
    }

}
