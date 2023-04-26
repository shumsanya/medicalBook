<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserParams */

$this->title = 'Обновите ваш показатель если нужно';
$this->params['breadcrumbs'][] = ['label' => 'Ваши параметры', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновление';
?>
<div class="user-params-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
