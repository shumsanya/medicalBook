<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserParams */
/* @var $masLabels app\models\UserParams */
/* @var $masData2 app\models\UserParams */
/* @var $param app\models\UserParams */
/* @var $caption app\models\UserParams */
/* @var $subCaption app\models\UserParams */
/* @var $x app\models\UserParams */
/* @var $y app\models\UserParams */
/* @var $masData app\models\UserParams */
/* @var $unit app\models\UserParams */
/* @var $unit2 app\models\UserParams */
/* @var $result app\models\UserParams */
/* @var $startPeriod app\models\UserParams */
/* @var $endPeriod app\models\UserParams */

$this->title = $this->params['param'];
$this->params['breadcrumbs'][] = ['label' => 'Ваши параметры в таблице', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row" id="cheng_chart">
    <div class="col-lg-2 text-center">
        <div class="btn-group-vertical" role="group" aria-label="Basic example" style="margin-bottom: 30px">
            <?= Html::a(Yii::t('app','Вес'), ['/user-params/view', 'param' => 'weight'], ['class'=>'btn btn-outline-primary']) ?>
            <?= Html::a(Yii::t('app','Температура'), ['/user-params/view', 'param' => 'temperature'], ['class'=>'btn btn-outline-primary']) ?>
            <?= Html::a(Yii::t('app','Пульс'), ['/user-params/view', 'param' => 'pulse'], ['class'=>'btn btn-outline-primary']) ?>
            <?= Html::a(Yii::t('app','Давление'), ['/user-params/view', 'param' => 'pressure'], ['class'=>'btn btn-outline-primary']) ?>
            <?= Html::a(Yii::t('app','Сахар'), ['/user-params/view', 'param' => 'blood_sugar'], ['class'=>'btn btn-outline-primary']) ?>
        </div>
        <?php
        $form = ActiveForm::begin([
            'options'=> [],
            'action' => Url::to(['/user-params/create']),
        ]); ?>
        <div >
            <?php
                if ($this->params['param'] == 'pressure') { ?>
                    <input type="number" step="0.1" min="1" max="300" class="form-control" name="number_top" placeholder="верхний показатель" required style="margin-bottom: 3px;">
                    <input type="number" step="0.1" min="1" max="300" class="form-control" name="number_bottom" placeholder="нижний показатель" required>
                <?php }else{ ?>
                    <input type="number" step="0.1" min="1" max="300" class="form-control"  name="number" required>
                <?php   }
            ?>
            <input type="text" name="param" value="<?php echo $this->params['param']; ?>" hidden>
            <button class="btn btn-info pulsse" >добавить измерение <?php echo $this->params['for_button']; ?></button>
        </div>
        <?php
        ActiveForm::end();
        ?>
    </div>

    <?= $this->render('chart', []);?>
    <?/*= $this->render('chart', [
        'masLabels' => $masLabels,
        'masData' => $masData,
        'masData2' => $masData2,
        'param' => $param,
        'caption' => $caption,
        'subCaption' => $subCaption,
        'x' => $x,
        'y' => $y,
        'unit' => $unit,
        'unit2' => $unit2,
        'result' => $result,
        'startPeriod' => $startPeriod,
        'endPeriod' => $endPeriod
    ]) */?>

</div>
