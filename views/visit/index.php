<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Visits';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="visit-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Новый визик к врачу', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'], // Столбец нумерации. Отображает порядковый номер строки

            //'id',
            //'user_id',
            //'doctor_id',
            //'hospital_id',
            'date',
            'symptoms:ntext',
            'conclusion:ntext',
            'surveys:ntext',
            'recommendations:ntext',
            'analyzes:ntext',
            'comments:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
