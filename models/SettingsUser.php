<?php

namespace app\models;

use Yii;

class SettingsUser extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{settings_user}}';
    }

    public static function setSettings($property_name, $property_value)
    {

        if (SettingsUser::find()->where(['user_id' => Yii::$app->user->getId()])->exists() == 1)
        {
            $model = SettingsUser::findOne(['user_id' => Yii::$app->user->getId()]);
            $model->$property_name = $property_value;
            $model->save(false);
        }
        else
        {
            $model = new SettingsUser();
            $model->user_id = Yii::$app->user->getId();
            $model->$property_name = $property_value;
            $model->save(false);
        }

    }

    public static function getSidebarColor($user_id)
    {
        $result = SettingsUser::findOne(['user_id' => $user_id]);
        return $result->sidebar_color;
    }

    public static function getBackgroundColor($user_id)
    {
        $result = SettingsUser::findOne(['user_id' => $user_id]);
        return $result->background_color;
    }

    public static function noSettings($user_id)
    {
        if (!SettingsUser::findOne(['user_id' => $user_id])){
            return true;
        }

        return false;
    }

}