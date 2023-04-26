<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "doctor".
 *
 * @property int $id
 * @property string $name
 * @property string $specialty
 * @property string|null $email
 * @property string $tel
 * @property string|null $comments
 * @property int $user_id
 */
class Doctor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'doctor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'specialty', 'user_id'], 'required'],
            [['name', 'specialty', 'email', 'tel', 'comments'], 'string'],
            [['user_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя Фамилия',
            'specialty' => 'Специальность',
            'email' => 'Єлектронная почта',
            'tel' => 'телефон',
            'user_id' => 'User ID',
            'comments' => 'Коментарий',
        ];
    }
}
