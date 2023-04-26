<?php

namespace app\controllers;

use app\models\PersonalData;
use app\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * PersonalDataController implements the CRUD actions for PersonalData model.
 */
class PersonalDataController extends Controller
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
     * Lists all PersonalData models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => PersonalData::find(),
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
     * Displays a single PersonalData model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PersonalData model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->isGuest)
        {
            return Yii::$app->response->redirect(['site/login']);
        }

        $model = new PersonalData();
        $user = User::findOne(['id' => Yii::$app->user->getId()]);
        
        if (!$user) {
            throw new NotFoundHttpException("The user was not found.");
        }

        if ($this->request->isPost) {

            $model->date = date('Y-m-d');
            $model->user_id = $user['id'];

            /*$user->load(Yii::$app->request->post()) загрузить модель пользователя  */

            // получяем данные формы
            $model->load($this->request->post());

            // если поле email не заполнено берем из таблици user
            if (empty($model->email)){
                $model->email = $user['email'];
            };

                // сохранить данные в таблицу
               if ($model->save() ) {
                   return $this->redirect(['view', 'id' => $model->id]);
               }

           } else {
            $model->loadDefaultValues();
           }

           return $this->render('create', [
               'user' => $user,
               'model' => $model,

           ]);
       }

       public function actionAvatar()
       {
           $model = new PersonalData();
           $user = User::findOne(['id' => Yii::$app->user->getId()]);

          /* echo '<pre>';
           print_r($_FILES);
           print_r($_POST);
           echo '</pre>';
           die;*/

        if ( $model->load($this->request->post()) ){

            //* add avatar

            $imageName = 'avatar_user_id_'.Yii::$app->user->getId();

            //* передача файла в $model->avatar
            $model->avatar = UploadedFile::getInstance($model, 'avatar');

            $filePath = 'designCT/img/'.$imageName.'.'.$model->avatar->extension;

            if(!empty($model->avatar))
            {
                //* сохранение файла на сервер
                $model->avatar->saveAs($filePath);
                $model->avatar = $filePath;

                return '@web/'.$filePath;
            }
        }
        // and add avatar

        return 'not load';
    }

    /**
     * Updates an existing PersonalData model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate()
    {
        if ($this->request->isPost)
        {
            $model = $this->findModel($_POST['PersonalData']['id']);

            $model->date = date('Y-m-d');

            $model->load($this->request->post());

            $model->save();
        }

        return $this->redirect(['profile', 'id' => Yii::$app->user->identity->getId()]);
    }

    /**
     * Deletes an existing PersonalData model.
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
     * Finds the PersonalData model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return PersonalData the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PersonalData::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Displays a single PersonalData model.
     * @param int $id user_id
     * @return mixed
     */
    public function actionProfile()
    {
        if (Yii::$app->user->isGuest)
        {
            return Yii::$app->response->redirect(['site/login']);
        }

        $user_id = Yii::$app->user->identity->getId();

        if (($model = PersonalData::findOne(['user_id' => $user_id])) !== null) {
            $user = User::findOne(['id' => $user_id]);

            return $this->render('update', [
                'model' => $model,
                'user' => $user,
            ]);
        }
        else
        {
            $this->redirect('create');
        }
    }

    public function actionSaveavatar()
    {

        $this->actionIndex();
    }

    // - Удалить тестовий контроллер
    public function actionTest()
    {
       // $test = PersonalData::find()->select('avatar')->where([ 'user_id' => Yii::$app->user->getId() ]);
        $test = PersonalData::findOne( ['user_id' => 2 ]);
        //$test = ['PersonalData::find()->select'];
        return $this->render('test', [
            'test' => $test
        ]);
    }
}
