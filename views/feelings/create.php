<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;


/* @var $array_organ_select app\models\Feelings */
/* @var $this yii\web\View */
/* @var $model app\models\Feelings */

$this->registerCssFile('@web/js/v2.3.2/jquery.rateyo.css');
$this->registerJsFile('@web/js/v2.3.2/jquery.rateyo.js', ['depends' => [\yii\web\JqueryAsset::class]]);

$this->title = 'Create Feelings';
$this->params['breadcrumbs'][] = ['label' => 'Feelings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="feelings-create">
    <div class="row">
        <h1>Ваше самочувствие</h1>
        <h4>Записывать свое самочувствие можно по любому поводу, и столько раз в день сколько вам это необходимо. Очень важно отмечать любые проявления ухудшения здоровья. Эта информация поможет врачу поставить более правильный диагноз, и вам будет легче понять что происходит.</h4>
    </div>

    <?php $form = ActiveForm::begin();?>
    <div class="card-body">
        <div class="row">
            <div class="col-md-11">
                <label class="form-group" for="evaluation">Как вы оцениваете свое состояние (уровень боли, беспокойства), чем ниже оценка тем хуже самочувствие</label>
                <div id="rateYo" data-bs-toggle="tooltip" title="Укажите свое состояние"></div>
                <span id="value_rating"></span>
            </div>
        </div>
    </div>
    <div class="card-body" style="margin-top: -30px">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <?= $form->field($model, 'evaluation')->hiddenInput(['id'=>"value_evaluation"])->label(false)  ?>
                </div>
            </div>
        </div>

      <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <?//Передаем список виджету AutoComplete?>
                    <?= $form->field($model, 'organ')->widget(
                        AutoComplete::className(), [
                        'clientOptions' => [
                            'source' => $array_organ_select,
                        ],
                        'options'=>[
                            'class'=>'form-control',
                            'htmlOptions' => [
                                'maxlength' => 50,
                                'class' => 'form-control top-search-field',
                                'style' => 'background-color: black',
                                'placeholder' => 'Напишите или выберите часть тела (орган) которая беспокоит',
                                'name' => 'organ',
                            ],
                        ]
                    ]);
                    ?>

                </div>
            </div>
        </div>
       <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <?= $form->field($model, 'description')
                        ->textInput(['maxlength' => true])
                        ->input('text', ['placeholder' => "Опишите что ощущаете. Боль, зуд, судорга, тревога, ... "])
                    ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <?= $form->field($model, 'my_actions')
                        ->textInput(['maxlength' => true])
                        ->input('text', ['placeholder' => "Опишите что вы сделали чтобы устранить симптом (таблетка, сон, ...) "])
                    ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <?= $form->field($model, 'date')->input('date') ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>

    </div>

</div>
<?php


//** библиотека звездный рейтинг rateYo  */**
$script_rateYo = <<< JS

  $("#rateYo").rateYo({
    starWidth: "40px",
    spacing   : "5px",
    halfStar: true,
    multiColor: {
      "startColor": "#FF0000", //RED
      "endColor"  : "#f1c40f"  //GOLD
    },
    onSet: function (rating, rateYoInstance) {
      $('#value_evaluation').val(rating);
      },
     
});

 $("#rateYo").rateYo()
              .on("rateyo.change", function (e, data) {
 
                var rating = data.rating;
                $("#value_rating").text(rating);
              });
JS;

// значение $position может быть View::POS_READY (значение по умолчанию),
$position = $this::POS_READY;

$this->registerJs($script_rateYo, $position);

?>
