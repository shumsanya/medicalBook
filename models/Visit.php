<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "visit".
 *
 * @property int $id
 * @property int $user_id
 * @property int $doctor_id
 * @property int $hospital_id
 * @property string|null $analyzes
 * @property string $conclusion
 * @property string|null $surveys
 * @property string $recomendations
 * @property string $date
 * @property string $symptoms
 * @property string|null $coments
 */
class Visit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'visit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'doctor_id', 'hospital_id', 'date', 'symptoms'], 'required'],
            [['user_id', 'doctor_id', 'hospital_id'], 'integer'],
            [['analyzes', 'conclusion', 'surveys', 'recommendations', 'symptoms', 'comments'], 'string'],
            [['date'], 'safe'],
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
            'doctor_id' => 'Doctor ID',
            'hospital_id' => 'Hospital ID',
            'analyzes' => 'Анализы',
            'conclusion' => 'Заключение',
            'surveys' => 'Обследование',
            'recommendations' => 'Рекомендации',
            'date' => 'Дата',
            'symptoms' => 'Симптомы',
            'comments' => 'Коментарии',
        ];
    }
}
