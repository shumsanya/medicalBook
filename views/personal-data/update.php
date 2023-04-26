<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PersonalData */
/* @var $user app\models\PersonalData */

$this->title = 'Update Personal Data: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Personal Datas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="personal-data-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('forma_update', [
        'model' => $model,
        'user' => $user,
    ]) ?>

</div>
