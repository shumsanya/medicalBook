<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use kartik\icons\Icon;
use kartik\icons\FontAwesomeAsset;

FontAwesomeAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\UserParams */
/* @var $form yii\widgets\ActiveForm */

$items = [
    ['label' => Icon::show('home') . 'Home', 'url' => ['/site/index']],
];
?>

<div class="user-params-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'date')->widget(DateTimePicker::classname(), [
        'options' => [
                'items' => $items,
            'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                'encodeLabels' => false,
                'language' => 'ru',
                'size' => 'lg',
            'placeholder' => 'Введите дату и время вашего измерения',
            //'value' => '02/01/2001 05:10',

        ],
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'dd-mm-yyyy hh:ii'
        ]
    ]); ?>

    <?= $form->field($model, 'temperature')->textInput() ?>

    <?= $form->field($model, 'weight')->textInput() ?>

    <?= $form->field($model, 'pressure_top')->textInput() ?>

    <?= $form->field($model, 'pressure_bottom')->textInput() ?>

    <?= $form->field($model, 'pulse')->textInput() ?>

    <?= $form->field($model, 'blood')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'blood_sugar')->textInput() ?>

    <?= $form->field($model, 'sugar_before')->textInput() ?>

    <?= $form->field($model, 'sugar_after')->textInput() ?>

    <?= $form->field($model, 'growth')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
