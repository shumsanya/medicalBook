<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Visit */
/* @var $form yii\widgets\ActiveForm */
/* @var $doctor_list app\models\Visit */
/* @var $hospital_list app\models\Visit */
/* @var $doctor_model app\models\Doctor */
/* @var $hospital_model app\models\Visit */
/* @var $modal_message app\controllers\VisitController */

?>
<div class="container">
    <div class="card">
        <div class="visit-form">
            <?php $form = ActiveForm::begin(); ?>

        <div class="row">
           <div class="col-md-6">
              <?= $form->field($model, 'date')->input('date') ?>
           </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'doctor_id')->dropDownList($doctor_list,
                    ['multiple' => false, 'prompt' => 'Выберите доктора', 'className'=>"form-control"])
                    ->label('Врачь')?>
            </div>
            <div class="col-md-4 for-button-visit">
                <?= Html::button('Добавить врача', ['class' => 'btn btn-secondary btn-sm', 'data-bs-toggle' =>'modal', 'data-bs-target'=>'#newDoctor']) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'hospital_id')->dropDownList($hospital_list,
                    ['multiple' => false, 'prompt' => 'Выберите учереждение', 'className'=>"form-control"])
                    ->label('Медецинское учереждение')?>
            </div>
            <div class="col-md-4 for-button-visit">
                <?= Html::button('Добавить медицынское учереждение', ['class' => 'btn btn-secondary btn-sm', 'data-bs-toggle' =>'modal', 'data-bs-target'=>'#newHospital']) ?>
            </div>
        </div>

        <div class="row">
           <div class="col-md-6">
             <?= $form->field($model, 'symptoms')->textarea(['rows' => 1]) ?>
           </div>
        </div>
            
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'conclusion')->textarea(['rows' => 1, 'placeholder' => "Диагноз", 'className'=>"form-text-area"]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'analyzes')->textarea(['rows' => 1, 'placeholder' => "какие анализы нужно сделать"]) ?>
            </div>
            <div class="col-md-4 for-button-visit">
                <?= Html::button('Добавить фото результатов анализов', ['class' => 'btn btn-secondary btn-sm']) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'surveys')->textarea(['rows' => 1]) ?>

                <?= $form->field($model, 'recommendations')->textarea(['rows' => 1]) ?>

                <?= $form->field($model, 'comments')->textarea(['maxlength' => true, 'rows' => 1]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>
            <?php ActiveForm::end(); ?>
    </div>
</div>
</div>

<!-- Modal for doctor-->
<div class="modal fade" id="newDoctor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" style="transform: translate(0, 5%);">
        <div class="modal-content modal-form-card">
            <div class="modal-header">
                <h5 class="modal-title title-modal" id="exampleModalLabel">Новый врачь</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?php $form = ActiveForm::begin(); ?>
            <div class="modal-body ">

                <?= $form->field($doctor_model, 'name')->textInput(['maxlength' => true, 'className'=>"form-control",])->label('Имя Фамилия')  ?>

                <?= $form->field($doctor_model, 'specialty')->textInput(['maxlength' => true, 'className'=>"form-control",]) ?>

                <?= $form->field($doctor_model, 'email')->input('email', ['maxlength' => true, 'className'=>"form-control",]) ?>

                <?= $form->field($doctor_model, 'tel')->textInput(['maxlength' => true, 'className'=>"form-control",]) ?>

                <?= $form->field($doctor_model, 'comments')->textInput(['maxlength' => true, 'className'=>"form-control",]) ?>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<!-- Modal for hospital-->
<div class="modal fade" id="newHospital" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="transform: translate(0, 5%); s">
        <div class="modal-content modal-form-card">
            <div class="modal-header">
                <h5 class="modal-title title-modal" id="exampleModalLabel">Новый врачь</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?php $form = ActiveForm::begin(); ?>
            <div class="modal-body ">

                <?= $form->field($hospital_model, 'name')->textInput(['maxlength' => true, 'className'=>"form-control",]) ?>

                <?= $form->field($hospital_model, 'tel')->textInput(['maxlength' => true, 'className'=>"form-control",]) ?>

                <?= $form->field($hospital_model, 'comments')->textInput(['maxlength' => true, 'className'=>"form-control",]) ?>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<?php
    if ($modal_message): ?>
        <?php $this->registerJs('$("#myModal").modal("show"); setTimeout(function(){ $("#myModal").modal("hide") }, 2000); ');?>

        <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModal" aria-hidden="<?php echo $modal_message; ?>">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Внимание</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <strong>Новые данные внесены</strong>, продолжайте .
                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>

