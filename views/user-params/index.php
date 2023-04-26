<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ваши измерения';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-params-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить измерение', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'date',
            'weight',
            'growth',
            'pressure_top',
            'pressure_bottom',
            'blood',
            'blood_sugar',
            'sugar_before',
            'sugar_after',
            'temperature',
            'pulse',
            ['class' => 'yii\grid\ActionColumn'],
        ],
       // 'tableOptions'=>['class'=>'mytableclass'], // стиль таблицы
    ]); ?>


</div>
