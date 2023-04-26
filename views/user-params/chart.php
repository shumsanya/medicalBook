<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use dosamigos\chartjs\ChartJs;

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

$this->registerJsFile('@web/js/ajaxChengPeriod.js', $options = ['position' => yii\web\View::POS_END]);

?>
<div class="col-lg-10" >
    <div class="card card-chart" id="boxPjax">

        <div class="card-header">
            <h5 class="card-title"><?php echo $this->params['caption'].' '; ?><?php echo $this->params['subCaption']; ?></h5>
            <h5 class="card-category">
                <i class="tim-icons icon-bell-55 text-primary"></i>
                (что бы вы хотели здесь видеть ? может ваш средний показатель за период)
            </h5>
        </div>

        <div class="card-body" id="card-body" >
        <?php
            if ($this->params['masData2'])
            {
                echo ChartJs::widget([
                    'type' => 'line',
                    //'responsive' => true,
                    'options' => [
                        'height' => 50,
                        'width' => 150,
                         'scales' => ['x' => $this->params['x'], 'y' => $this->params['y']],
                         'spanGaps' => true, // enable for all datasets
                    ],
                    'data' => [
                        'labels' => $this->params['masLabels'],
                        'datasets' => [
                            [
                                'label' => $this->params['unit'],
                                'backgroundColor' => "rgba(179,185,198,0.2)",
                                'borderColor' => "rgba(100,181,198,1)",
                                'pointBackgroundColor' => "rgba(179,181,198,1)",
                                'pointBorderColor' => "#fff",
                                'pointHoverBackgroundColor' => "#fff",
                                'pointHoverBorderColor' => "rgba(179,181,198,1)",
                                'data' => $this->params['masData']
                            ],
                            [
                                'label' => $this->params['unit2'],
                                'backgroundColor' => "rgba(255,99,132,0.2)",
                                'borderColor' => "rgba(255,99,132,1)",
                                'pointBackgroundColor' => "rgba(255,99,132,1)",
                                'pointBorderColor' => "#fff",
                                'pointHoverBackgroundColor' => "#fff",
                                'pointHoverBorderColor' => "rgba(255,99,132,1)",
                                'data' => $this->params['masData2']
                            ]
                        ]
                    ]
                ]);
            }
            else
            {
                echo ChartJs::widget([
                    'type' => 'line',
                    //'responsive' => true,
                    'options' => [
                        'height' => 50,
                        'width' => 150,
                        'scales' => ['x' => $this->params['x'], 'y' => $this->params['y']],
                        'spanGaps' => true, // enable for all datasets
                    ],
                    'data' => [
                        'labels' => $this->params['masLabels'],
                        'datasets' => [
                            [
                                'label' => $this->params['unit'],
                                'backgroundColor' => "rgba(179,185,198,0.2)",
                                'borderColor' => "rgba(100,181,198,1)",
                                'pointBackgroundColor' => "rgba(179,181,198,1)",
                                'pointBorderColor' => "#fff",
                                'pointHoverBackgroundColor' => "#fff",
                                'pointHoverBorderColor' => "rgba(179,181,198,1)",
                                'data' => $this->params['masData']
                            ],
                        ],
                    ]
                ]);
            }
            ?>
        </div>

            <?php
            $form = ActiveForm::begin([
                'id' => 'cheng_period',
                'options' => ['class' => 'form-horizontal'],
            ]);
            ?>
        <div class="row gap-3 alert" style="margin: 15px; border: #545b62 solid 1px">
            <input type="date" class="form-control col-lg-3" style="width: 250px;" name="startPeriod" value="<?php echo $this->params['startPeriod']; ?>" >
            <input type="date" class="form-control col-lg-3" style="width: 250px;" name="endPeriod" value="<?php echo $this->params['endPeriod']; ?>" >
            <input type="text" name="param" value="<?php echo $this->params['param']; ?>" hidden>
            <?= Html::submitButton('изменить временной промежуток', ['class' => 'btn btn-info col-lg-5']) ?>
        </div>
            <?php
            ActiveForm::end();
            ?>

    </div>
</div>
