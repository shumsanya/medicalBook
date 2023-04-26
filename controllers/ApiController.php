<?php

namespace app\controllers;

use app\models\SettingsUser;
use Yii;
use yii\console\Response;
use yii\web\Controller;


class ApiController extends Controller
{

    // определение пользовательских настроек из таблицы settings_user
    public function actionSetsettingsuser()
    {
        $property_name = '';
        $property_value = '';

        if (isset($_POST['sidebar_color'])){
            $property_name = 'sidebar_color';
            $property_value = $_POST['sidebar_color'];
        }

        if (isset( $_POST['background_color'])){
            $property_name = 'background_color';
            $property_value = $_POST['background_color'];
        }


        if (Yii::$app->user->isGuest)
        {
            $_SESSION[$property_name] = $property_value;
        }
        else
        {
            SettingsUser::setSettings($property_name, $property_value);
        }

    }

    /*public function actionIndex()
    {
        $result = SettingsUser::find()->where(['user_id' => 2])->exists();
        return $this->render('index', [
            'result' => $result,
        ]);
    }*/

    // настройки внешнего вида по умолчанию для незарегистрированых пользователей
    public function actionSetusersession()
    {
        if (!isset($_SESSION['user']))
        {
            $_SESSION['user'] = $_COOKIE['PHPSESSID'];
            $_SESSION['sidebar_color'] = 'blue';
            $_SESSION['background_color'] = 'black';
        }
    }

}