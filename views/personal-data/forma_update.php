<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PersonalData */
/* @var $user app\models\User */
/* @var $form yii\widgets\ActiveForm */

$this->registerJsFile('@web/designCT/js/text_filling.js', $options = ['position' => yii\web\View::POS_END]);
?>

<div class="personal-data-form">
    <?php $form = ActiveForm::begin([
        'id' => 'personal_data_update',
        'action' => ['personal-data/update'],
        'options' => ['enctype' => 'multipart/form-data']
        //'fieldConfig' => ['template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}"]
    ]); ?>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">Profile</h5>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-4 pr-md-1">
                            <div class="form-group">
                                <?= $form->field($model, 'name')
                                    ->textInput(['maxlength' => true, 'value'=>$model->name, 'className'=>"form-control", 'oninput' => "js:n_filling(this.value)" ])
                                    ->label('Имя') ?>
                            </div>
                        </div>
                        <div class="col-md-5 px-md-1">
                            <div class="form-group">
                                <?= $form->field($model, 'surname')
                                    ->textInput(['maxlength' => true, 'className'=>"form-control", 'oninput' => "js:s_filling(this.value)" ])
                                    ->label('Фамилия') ?>
                            </div>
                        </div>
                        <div class="col-md-3 pl-md-1">
                            <div class="form-group">
                                <?= $form->field($user, 'username')
                                    ->textInput(['className'=>"form-control", 'disabled'=>""])
                                    ->label('Login') ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 pr-md-1">
                            <div class="form-group">
                                <?php echo $form->field($model, 'gender')
                                    ->radioList(['man' => 'мужской', 'woman' => 'женский'])
                                    ->label('Ваш пол'); ?>
                            </div>
                        </div>
                        <div class="col-md-3 pl-md-1">
                            <div class="form-group">
                                <?= $form->field($model, 'birthday')
                                    ->input('date')
                                    // ->widget(\yii\widgets\MaskedInput::class, ['mask' => '31-12-2999'])
                                    ->label('Дата рождения');?>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <?= $form->field($user, 'email')
                                    ->input('email')
                                    ->hint('измените email если необходимо')
                                    ->label('Ваш електронный адрес') ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?php $listOfDoctor = ['1' => 'Петров', '2' => 'Барса', '3' => 'Кирильчук']; ?>
                        <div class="col-md-5 pr-md-1">
                            <?= $form->field($model, 'doctor_id')
                                ->dropDownList($listOfDoctor,
                                    ['multiple' => false, 'prompt' => 'Выберите своего доктора', 'className'=>"form-control"])
                                ->label('Ваш лечащий врачь')?>
                        </div>
                    </div>

                    <div class="col-md-8 pl-md-1">
                        <div class="form-group">
                            <?php echo$form->field($model, 'target')
                                ->textarea(['rows' => 6, 'className'=>"form-text-area",
                                    'oninput' => "js:t_filling(this.value)" ])
                                ->label('Ваша цель, намерение');?>
                        </div>
                    </div>

                    <div class="card-footer">
                        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-fill btn-primary']) ?>
                        <?= Html::a('Заполнить свои измерения', ['user-params/create'], ['class' => 'btn btn-fill']) ?>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-user">
                <div class="card-body">
                    <p class="card-text"></p>
                    <div class="author">
                        <div class="block block-one"></div>
                        <div class="block block-two"></div>
                        <div class="block block-three"></div>
                        <div class="block block-four"></div>
                        <div id="avatar" >
                            <?php
                            if (!empty($model->avatar)){
                                echo Html::img( $model->avatar, ['alt' => 'ваше фото', 'className' => 'avatar']);
                            } else{
                                echo Html::img('@web/designCT/img/default-avatar.png', ['alt' => 'загрузите свое фото']);
                            }
                            ?>
                            <h4>
                                <?= $form->field($model, 'avatar')->fileInput(['onchange' => "js:save_avatar()", 'className' => 'input_avatar'])->label('ваше фото') ;?>
                                <?= $form->field($model, 'avatar')->hiddenInput(['id'=>"value_avatar"])->label(false) ;?>
                                <?= $form->field($model, 'id')->hiddenInput()->label(false) ;?>
                            </h4>
                        </div>
                        <h5 class="title"><?php echo $user->username;?></h5>
                        <p class="description" id="description-name-surname">
                            <span id="description-name"></span>&nbsp;&nbsp;<span id="description-surname"></span>
                        </p>
                    </div>

                    <div class="card-description" id="description-target">
                        <?php  echo(isset($model->target) ?  $model->target :  (' У меня 100% зрение. Я вижу все ясно и отчетливо. Я люблю свои глаза.'));?>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="button-container">
                        <button href="#" class="btn btn-icon btn-round btn-facebook">
                            <i class="fab fa-facebook"></i>
                        </button>
                        <button href="#" class="btn btn-icon btn-round btn-twitter">
                            <i class="fab fa-twitter"></i>
                        </button>
                        <button href="#" class="btn btn-icon btn-round btn-google">
                            <i class="fab fa-google-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    <!--  echo $form->field($model, 'uploadFile')->fileInput();  -->