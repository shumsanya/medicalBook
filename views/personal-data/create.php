<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $user app\models\PersonalData */


$this->title = 'Create Personal Data';
$this->params['breadcrumbs'][] = ['label' => 'Personal Datas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="personal-data-create">
<?php echo ('<h2>Заполните свои персональные данные</h2>')?>

    <?= $this->render('forma', [
        'user' => $user,
        'model' => $model,
    ]) ?>

</div>
