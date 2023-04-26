<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "feelings".
 *
 * @property int $id
 * @property int $user_id
 * @property string $organ
 * @property string $description
 * @property string|null $my_actions
 * @property float|null $evaluation
 * @property string $date
 */
class Feelings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'feelings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $message = 'Чясть тела не может быть короче 3 и длинне 30 символов';
        $message1 = 'Это поле не может быть короче 4-ох и длинне 100 символов';

        return [
            [['user_id', 'organ', 'description', 'evaluation', 'date'], 'required', 'message'=>'Поле "{attribute}" должно быть заполнено.'],
            [['user_id'], 'integer'],
            [['evaluation'], 'number'],
            [['date'], 'safe'],
            [['organ'], 'string', 'min' => 3, 'max' => 30,'message'=>$message, 'tooLong'=>$message, 'tooShort'=>$message],
            [['description', 'my_actions'], 'string', 'min' => 4, 'max' => 100,'message'=>$message1, 'tooLong'=>$message1, 'tooShort'=>$message1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'organ' => 'Чясть тела',
            'description' => 'Описание',
            'my_actions' => 'Мои действия',
            'evaluation' => 'Оценка состояния',
            'date' => 'Дата',
        ];
    }
}
