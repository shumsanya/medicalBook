<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserParams */

$this->title = 'Добавить новое измерение';
$this->params['breadcrumbs'][] = ['label' => 'Ваши измерения', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-params-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
