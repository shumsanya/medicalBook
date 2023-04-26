<?php

namespace app\controllers;

use app\models\UserParams;
use dosamigos\chartjs\ChartJs;
use dosamigos\chartjs\ChartJsAsset;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\JsExpression;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserParamsController implements the CRUD actions for UserParams model.
 */
class UserParamsController extends Controller
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

    // получить часовой пояс текущего пользователя
    public function actions()
    {
        return [
            'timezone' => [
                'class' => 'yii2mod\timezone\TimezoneAction',
            ],
        ];
    }

    /**
     * Lists all UserParams models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => UserParams::find()->orderBy(['date' => SORT_DESC]),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single UserParams model.
     * @param int $parameter
     * @return mixed
     */
    public function actionViews()
    {
        if (Yii::$app->user->isGuest)
        {
            return Yii::$app->response->redirect(['site/login']);
        }

        // переменные
        $userId = Yii::$app->user->identity->getId();
        $masLabels = array();
        $masData = array();
        $masData2 = array();
        $today = date('Y-m-d');
        $unit2 = '';

        if (Yii::$app->request->post()){
            $startPeriod = Yii::$app->request->post("startPeriod");
            $endPeriod = Yii::$app->request->post("endPeriod");
            $param = Yii::$app->request->post("param");
        }else{
            $startPeriod = date("Y-m-d", strtotime("-1 year"));;
            $endPeriod = date("Y-m-d");
        }

        // добавляем и отнимаем один день для адекватной выборки
        $newDateStartPeriod = date('Y-m-d', strtotime($startPeriod."-1 day" ));
        $newDateEndPeriod = date('Y-m-d', strtotime($endPeriod."+1 day" ));

        // выбрать все параметры в указаных промежутках времени
        //  $result = User::userParamsDate($newDateEndPeriod, $newDateStartPeriod, $userId);
        $result = UserParams::find()
            // ->select([$param, 'date'])
            ->where (['user_id' => $userId])
            // ->andWhere( ['not in', 'weight', [null]])
            // ->andWhere($param.' IS NOT NULL')
            ->andwhere (['between', 'date', $newDateStartPeriod, $newDateEndPeriod]) // выбрать между
            // ->orderBy(['id' => SORT_DESC]) // сортировка с конца
            ->asArray()
            ->all();

        // если масив result пуст (в заданом промежутке времени нету данных)
        if (empty($result)){
            $masLabels = "Данных по этому параметру нет, наверное вы не вносили это измерение";
        }

        // если параметр состоит из двух значений, добавляем переменные
        if ($param === 'pressure' || $param === 'sugar')
        {
            if ($param === 'pressure')
            {
                $value1 = 'pressure_top';
                $value2 = 'pressure_bottom';
            }
            if ( $param === 'sugar')
            {
                $value1 = 'sugar_before';
                $value2 = 'sugar_after';
            }

            // заполняем переменные для графика
            foreach ($result as $key => $value) {
                if (isset($value[$value1]) || isset($value[$value2]))
                {
                    if ( date('Y-m-d', strtotime($value['date'])) === $today ){
                        $masLabels[] = 'сегодня в '. date('G:i', strtotime($value['date']));
                    }else{
                        $masLabels[] = date('d-m-Y', strtotime($value['date']));
                    }
                    $masData[] = $value[$value1];
                    $masData2[] = $value[$value2];
                }
            }
        }
        else
        {
            foreach ($result as $key=>$value){
                if ( isset($value[$param]) )
                {
                    if ( date('Y-m-d', strtotime($value['date'])) === $today ){
                        $masLabels[] = 'сегодня в '. date('G:i', strtotime($value['date']));
                    }else{
                        $masLabels[] = date('d-m-Y', strtotime($value['date']));
                    }
                    $masData[] = $value[$param];
                }
            }
        }

        switch ($param){
            case 'weight':
                $caption = 'График вашего веса';
                $subCaption = 'отображение данных с '.$startPeriod.' по '.$endPeriod;
                $x = 'дата';
                $y = 'килограмы';
                $unit = 'кг';
                break;
            case 'pulse':
                $caption = 'График вашего пульса';
                $subCaption = 'отображение данных с '.$startPeriod.' по '.$endPeriod;
                $x = 'дата';
                $y = 'количество ударов в минуту';
                $unit = 'ударов';
                break;
            case 'growth':
                $caption = 'График вашего роста';
                $subCaption = 'отображение данных с '.$startPeriod.' по '.$endPeriod;
                $x = 'дата';
                $y = 'сантиметры';
                $unit = 'см';
                break;
            case 'blood_sugar':
                $caption = 'График количество сахара в крови';
                $subCaption = 'отображение данных с '.$startPeriod.' по '.$endPeriod;
                $x = 'дата';
                $y = 'количество сахара в крови';
                $unit = 'ммоль/л';
                break;
            case 'temperature':
                $caption = 'График температуры тела';
                $subCaption = 'отображение данных с '.$startPeriod.' по '.$endPeriod;
                $x = 'дата';
                $y = 'температура по С';
                $unit = 'С';
                break;
            case 'pressure':
                $caption = 'График вашего давления';
                $subCaption = 'отображение данных с '.$startPeriod.' по '.$endPeriod;
                $x = 'дата';
                $y = 'мл. ртутного столбца';
                $unit = 'верхнее';
                $unit2 = 'нижнее';
                break;
        }

       /* $data_array = array();
        $data_array['masLabels'] = $masLabels;
        $data_array['masData'] = $masData;
        $data_array['masData2'] = $masData2;
        $data_array['param'] = $param;
        $data_array['caption'] = $caption;
        $data_array['subCaption'] = $subCaption;
        $data_array['x'] = $x;
        $data_array['y'] = $y;
        $data_array['unit'] = $unit;
        $data_array['unit2'] = $unit2;
        $data_array['result'] = $result;
        $data_array['startPeriod'] = $startPeriod;
        $data_array['endPeriod'] = $endPeriod;

        return json_encode($data_array);*/

        \Yii::$app->getView()->params['masLabels'] = $masLabels;
        \Yii::$app->getView()->params['masData'] = $masData;
        \Yii::$app->getView()->params['masData2'] = $masData2;
        \Yii::$app->getView()->params['param'] = $param;
        \Yii::$app->getView()->params['caption'] = $caption;
        \Yii::$app->getView()->params['subCaption'] = $subCaption;
        \Yii::$app->getView()->params['unit'] = $unit;
        \Yii::$app->getView()->params['$unit2'] = $unit2;
        \Yii::$app->getView()->params['startPeriod'] = $startPeriod;
        \Yii::$app->getView()->params['endPeriod'] = $endPeriod;
        \Yii::$app->getView()->params['x'] = $x;
        \Yii::$app->getView()->params['y'] = $y;

        /*   $html = $this->renderPartial('view', [
           * 'masLabels' => $masLabels,
              'masData' => $masData,
              'masData2' => $masData2,
              'param' => $param,
              'caption' => $caption,
              'subCaption' => $subCaption,
              'x' => $x,
              'y' => $y,
              'unit' => $unit,
              'unit2' => $unit2,
              'result' => $result,
              'startPeriod' => $startPeriod,
              'endPeriod' => $endPeriod
        ],true);
        return $html;*/

        return $this->renderAjax('chart', []);

    }


    public function actionView($param = 'weight')
    {
        if (Yii::$app->user->isGuest)
        {
            return Yii::$app->response->redirect(['site/login']);
        }

        // переменные
        $userId = Yii::$app->user->identity->getId();
        $masLabels = array();
        $masData = array();
        $masData2 = array();
        $today = date('Y-m-d');
        $unit2 = '';

        if (Yii::$app->request->post()){
            $startPeriod = Yii::$app->request->post("startPeriod");
            $endPeriod = Yii::$app->request->post("endPeriod");
        }else{
            $startPeriod = date("Y-m-d", strtotime("-1 year"));;
            $endPeriod = date("Y-m-d");
        }

        // добавляем и отнимаем один день для адекватной выборки
        $newDateStartPeriod = date('Y-m-d', strtotime($startPeriod."-1 day" ));
        $newDateEndPeriod = date('Y-m-d', strtotime($endPeriod."+1 day" ));

        // выбрать все параметры в указаных промежутках времени
        //  $result = User::userParamsDate($newDateEndPeriod, $newDateStartPeriod, $userId);
        $result = UserParams::find()
           // ->select([$param, 'date'])
            ->where (['user_id' => $userId])
            // ->andWhere( ['not in', 'weight', [null]])
           // ->andWhere($param.' IS NOT NULL')
            ->andwhere (['between', 'date', $newDateStartPeriod, $newDateEndPeriod]) // выбрать между
            // ->orderBy(['id' => SORT_DESC]) // сортировка с конца
            ->asArray()
            ->all();

    // если масив result пуст (в заданом промежутке времени нету данных)
    if (empty($result)){
        $masLabels = "Данных по этому параметру нет, наверное вы не вносили это измерение";
    }

            // если параметр состоит из двух значений, добавляем переменные
            if ($param === 'pressure' || $param === 'sugar')
            {
                if ($param === 'pressure')
                {
                    $value1 = 'pressure_top';
                    $value2 = 'pressure_bottom';
                }
                if ( $param === 'sugar')
                {
                    $value1 = 'sugar_before';
                    $value2 = 'sugar_after';
                }

                // заполняем переменные для графика
                foreach ($result as $key => $value) {
                    if (isset($value[$value1]) || isset($value[$value2]))
                    {
                        if ( date('Y-m-d', strtotime($value['date'])) === $today ){
                            $masLabels[] = 'сегодня в '. date('G:i', strtotime($value['date']));
                        }else{
                            $masLabels[] = date('d-m-Y G:i', strtotime($value['date']));
                        }
                        $masData[] = $value[$value1];
                        $masData2[] = $value[$value2];
                    }
                }
            }
            else
            {
                foreach ($result as $key=>$value){
                    if ( isset($value[$param]) )
                    {
                        if ( date('Y-m-d', strtotime($value['date'])) === $today ){
                            $masLabels[] = 'сегодня в '. date('G:i', strtotime($value['date']));
                        }else{
                            $masLabels[] = date('d-m-Y G:i', strtotime($value['date']));
                        }
                        $masData[] = $value[$param];
                    }
                }
            }

            switch ($param){
                case 'weight':
                    $caption = 'График вашего ВЕСА';
                    $subCaption = 'отображение данных с '.$startPeriod.' по '.$endPeriod;
                    $x = 'дата';
                    $y = 'килограмы';
                    $unit = 'кг';
                    $for_button = 'веса';
                    break;
                case 'pulse':
                    $caption = 'График вашего ПУЛЬСА';
                    $subCaption = 'отображение данных с '.$startPeriod.' по '.$endPeriod;
                    $x = 'дата';
                    $y = 'количество ударов в минуту';
                    $unit = 'ударов';
                    $for_button = 'пульса';
                    break;
                case 'growth':
                    $caption = 'График вашего РОСТА';
                    $subCaption = 'отображение данных с '.$startPeriod.' по '.$endPeriod;
                    $x = 'дата';
                    $y = 'сантиметры';
                    $unit = 'см';
                    $for_button = 'роста';
                    break;
                case 'blood_sugar':
                    $caption = 'График количество САХАРА В КРОВИ';
                    $subCaption = 'отображение данных с '.$startPeriod.' по '.$endPeriod;
                    $x = 'дата';
                    $y = 'количество сахара в крови';
                    $unit = 'ммоль/л';
                    $for_button = 'сахара в крови';
                    break;
                case 'temperature':
                    $caption = 'График ТЕМПЕРАТУРЫ тела';
                    $subCaption = 'отображение данных с '.$startPeriod.' по '.$endPeriod;
                    $x = 'дата';
                    $y = 'температура по С';
                    $unit = 'С';
                    $for_button = 'температуры тела';
                    break;
                case 'pressure':
                    $caption = 'График вашего ДАВЛЕНИЯ';
                    $subCaption = 'отображение данных с '.$startPeriod.' по '.$endPeriod;
                    $x = 'дата';
                    $y = 'мл. ртутного столбца';
                    $unit = 'верхнее';
                    $unit2 = 'нижнее';
                    $for_button = 'давления';
                    break;
            }
        \Yii::$app->getView()->params['masLabels'] = $masLabels;
        \Yii::$app->getView()->params['masData'] = $masData;
        \Yii::$app->getView()->params['masData2'] = $masData2;
        \Yii::$app->getView()->params['param'] = $param;
        \Yii::$app->getView()->params['caption'] = $caption;
        \Yii::$app->getView()->params['subCaption'] = $subCaption;
        \Yii::$app->getView()->params['unit'] = $unit;
        \Yii::$app->getView()->params['unit2'] = $unit2;
        \Yii::$app->getView()->params['startPeriod'] = $startPeriod;
        \Yii::$app->getView()->params['endPeriod'] = $endPeriod;
        \Yii::$app->getView()->params['x'] = $x;
        \Yii::$app->getView()->params['y'] = $y;
        \Yii::$app->getView()->params['for_button'] = $for_button;

            return $this->render('view', [
                'masLabels' => $masLabels,
                'masData' => $masData,
                'masData2' => $masData2,
                'param' => $param,
                'caption' => $caption,
                'subCaption' => $subCaption,
                'x' => $x,
                'y' => $y,
                'unit' => $unit,
                'unit2' => $unit2,
                'result' => $result,
                'startPeriod' => $startPeriod,
                'endPeriod' => $endPeriod,
                'for_button' => $for_button
            ]);
    }


    /**
     * Creates a new UserParams model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->isGuest){
            return Yii::$app->response->redirect(['site/login']);
        }

        $timezone = Yii::$app->timezone->name;
        date_default_timezone_set($timezone);

        $model = new UserParams();

        if ($this->request->isPost)
        {
            $model->user_id = Yii::$app->user->getId();
            $model->date = date('Y-m-d G:i');    // текущяя дата по умолчанию;

            if ($_POST['param'] == 'pressure'){
                $model->pressure_top = $_POST['number_top'];
                $model->pressure_bottom = $_POST['number_bottom'];
            } else {
                $modelItem = $_POST['param'];
                $param = $_POST['number'];
                $model->$modelItem = $param;  // текущий параметр измерения;
            }

            if ($model->save())
            {
                return $this->redirect(['view', 'param' => $_POST['param']]);
            }else{
                print_r($model->getErrors()); die();
            }
        }
        else
        {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing UserParams model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing UserParams model.
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
     * Finds the UserParams model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return UserParams the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserParams::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
