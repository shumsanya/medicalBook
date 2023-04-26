<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Doctor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="doctor-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'className'=>"form-control",]) ?>

    <?= $form->field($model, 'specialty')->textInput(['maxlength' => true, 'className'=>"form-control",]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'className'=>"form-control",]) ?>

    <?= $form->field($model, 'tel')->textInput(['maxlength' => true, 'className'=>"form-control",]) ?>

    <?= $form->field($model, 'comments')->textInput(['maxlength' => true, 'className'=>"form-control",]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
