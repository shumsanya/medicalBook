<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "personal_data".
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $surname
 * @property string $gender
 * @property string $birthday
 * @property string|null $email
 * @property int|null $doctor_id
 * @property string|null $avatar
 * @property string $target
 * @property string $date
 *
 * @property User $user
 */
class PersonalData extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'personal_data';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'name', 'surname', 'gender', 'birthday', 'target', 'date'], 'required'],
            [['id', 'user_id', 'doctor_id'], 'integer'],
            [['birthday', 'date'], 'safe'],
            [['target'], 'string'],
            [['name', 'surname'], 'string', 'max' => 30],
           /* [['gender'], 'string', 'max' => 7],*/
            [['email'], 'string', 'max' => 255],
            [['avatar'], 'string', 'max' => 80],
            [['id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'name' => 'Name',
            'surname' => 'Surname',
            'gender' => 'Gender',
            'birthday' => 'Birthday',
            'email' => 'Email',
            'doctor_id' => 'Doctor ID',
            'avatar' => 'Avatar',
            'target' => 'Target',
            'date' => 'Date',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function getAvatar()
    {
        return self::findOne( [ 'user_id' => Yii::$app->user->getId() ] );
    }

}
