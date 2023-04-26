<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Visit */

$this->title = 'визит к врачу';
$this->params['breadcrumbs'][] = ['label' => 'Посещения к врачу', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="visit-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить запись', ['update', 'id' => $model['id']], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить запись', ['delete', 'id' => $model['id']], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            //'user_id',
            //'doctor_id',
            //'hospital_id',
            'date',
            'symptoms:ntext',
            'doctor:ntext',
            'hospital:ntext',
            'conclusion:ntext',
            'surveys:ntext',
            'recommendations:ntext',
            'analyzes:ntext',
            'comments:ntext',

        ],
        'options' => ['class' => 'table table-bordered']
    ]) ?>

</div>
