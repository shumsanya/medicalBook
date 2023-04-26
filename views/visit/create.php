<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Visit */
/* @var $doctor_list app\models\Visit */
/* @var $hospital_list app\models\Visit */
/* @var $doctor_model app\models\Doctor */
/* @var $hospital_model app\models\Visit */
/* @var $modal_message app\controllers\VisitController */

$this->title = 'Визит к врачу';
$this->params['breadcrumbs'][] = ['label' => 'Все визиты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="visit-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'doctor_list' => $doctor_list,
        'hospital_list' => $hospital_list,
        'doctor_model' => $doctor_model,
        'hospital_model' => $hospital_model,
        'modal_message' => $modal_message
    ]) ?>

</div>
