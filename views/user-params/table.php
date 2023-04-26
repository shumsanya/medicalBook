<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\UserParams */
/* @var $dataUser app\models\UserParams */


$this->params['breadcrumbs'][] = ['label' => 'User Params', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-params-view">

    <h1>Таблица с данными</h1>

    <?= \yii\grid\GridView::widget([
        'dataProvider' => $dataUser, // входящие данные
        //'filterModel' => $searchModel, // фильтрация и поиск
        'emptyCell'=>' ', // если ячейка пустая, отобразится прочерк
        'summary'=>'', // скрыть
        'showFooter'=>true, // показать
        'showHeader' => true, // показать
        'layout'=>"{sorter}\n{pager}\n{summary}\n{items}",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            // Атрибуты таблицы
            'weight',
            'growth',
            'pressure_top',
            'pressure_bottom',
            'pulse',
            'blood',
            'blood_sugar',
            'temperature',
            'date',
            ['class' => 'yii\grid\ActionColumn'],
        ],
        //'options'=>['class'=>'mynewclass'], // новый класс
    ]); ?>

</div>
