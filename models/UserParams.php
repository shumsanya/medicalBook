<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_params".
 *
 * @property int $id
 * @property int $user_id
 * @property float|null $weight
 * @property float|null $growth
 * @property int|null $pressure_top
 * @property int|null $pressure_bottom
 * @property string|null $blood
 * @property float|null $blood_sugar
 * @property float|null $sugar_before
 * @property float|null $sugar_after
 * @property float|null $temperature
 * @property int|null $pulse
 * @property string $date
 */
class UserParams extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_params';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'date'], 'required'],
            [['user_id', 'pressure_top', 'pressure_bottom', 'pulse'], 'integer'],
            [['weight', 'growth', 'blood_sugar', 'sugar_before', 'sugar_after', 'temperature'], 'number'],
            [['date'], 'safe'],
            [['blood'], 'string', 'max' => 13],
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
            'weight' => 'Вес', //'Weight',
            'growth' => 'Рост', //'Growth',
            'pressure_top' => 'Двление артериальное верхнее', //'Pressure Top',
            'pressure_bottom' => 'Двление артериальное нижнее', //'Pressure Bottom',
            'blood' => 'Група крови', //'Blood',
            'blood_sugar' => 'Сахар в крови', //'Blood Sugar',
            'sugar_before' => 'Сахар в крови до еды', //'Sugar Before',
            'sugar_after' => 'Сахар в крови после еды', //'Sugar After',
            'temperature' => 'Температура', //'Temperature',
            'pulse' => 'Пульс', //'Pulse',
            'date' => 'Date',
        ];
    }
}
