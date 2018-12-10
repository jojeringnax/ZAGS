<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Изменение настроек устройства № ' . $model->device_id;
$this->params['breadcrumbs'][] = ['label' => 'Устройства', 'url' => ['index', 'r' => 'owner']];
$this->params['breadcrumbs'][] = ['label' => 'Редактирование устройства №'.$model->device_id];
$this->registerJs("
   $('.breadcrumb-item a').click(function(e){
    e.preventDefault();
    let num =".$_GET['scrollTop'].";
    console.log(num)
        if($(this).text() == 'Устройства') {
            document.location.href = $(this).attr('href') + '&scrollTop='+num;
        }else {
            document.location.href = $(this).attr('href');
        }
    })
");
?>
<div class="container">
    <div class="row d-flex justify-content-center">
        <div id="change-form-device" class="card col-lg-8 col-xl-8 col-md-12" style="padding: 0">
            <?php $form = ActiveForm::begin([
                'options' => [
                    'class' => 'change-form'
                ]
            ]); ?>
            <div class="bg-primary card-header d-flex justify-content-center" style="font-weight: bold">
                <div class="elem-td text-center">
                    <span> <?= $model->description ?></span>
                </div>
            </div>
            <div class="content-update">
                <div class="d-flex">
                    <div class="elem-th">
                        <span>Цена Талисмана</span>
                    </div>
                    <div id="talisman-change" class="elem-td">
                        <?= $form->field($model, 'talisman_price')->textInput(['class'=>'input-update'])->label(false) ?>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="elem-th">
                        <span>Цена Свадьбы</span>
                    </div>
                    <div id="talisman-change" class="elem-td d-flex">
                        <?= $form->field($model, 'wedding_price')->textInput(['class'=>'input-update'])->label(false) ?>
                        <?= $form->field($model, 'reprint_price')->textInput(['class'=>'input-update'])->label(false) ?>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="elem-th">
                        <span>Цена Селфи</span>
                    </div>
                    <div id="kinoselfie-change" class="elem-td">
                        <?= $form->field($model, 'kinoselfie_price')->textInput(['class'=>'input-update'])->label(false) ?>

                    </div>
                </div>
                <div class="d-flex">
                    <div class="elem-th">
                        <span>Цена Instagram</span>
                    </div>
                    <div id="instagram-change" class="elem-td">
                        <input type="text" class="input-update" value="0">
                    </div>
                </div>
                <div class="d-flex">
                    <div class="elem-th">
                        <span>Состояние аппарата</span>
                    </div>
                    <div id="state-device" class="elem-td">
<!--                       <?/*= $form->field($model, 'disabled', [
                            'labelOptions' => [ 'class' => '']
                        ])->DropDownList(['1' => 'Выключен', '0' => 'Включен'],['class' => 'select-update'])->label(false) */?>-->
                    </div>
                </div>
                <div class="d-flex">
                    <div class="elem-th">
                        <span>Тихий режим</span>
                    </div>
                    <div id="state-device" class="elem-td d-flex">
                        <div class="state-td" style="width: 50%">
                            <?= $form->field($model, 'quiet_time_start')->dropDownList([
                                '0' => '00:00',
                                '1' => '01:00',
                                '2'=>'02:00',
                                '3'=>'03:00',
                                '4'=>'04:00',
                                '5'=>'05:00',
                                '6'=>'06:00',
                                '7'=>'07:00',
                                '8'=>'08:00',
                                '9'=>'09:00',
                                '10'=>'10:00',
                                '11'=>'11:00',
                                '12'=>'12:00',
                                '13'=>'13:00',
                                '14'=>'14:00',
                                '15'=>'15:00',
                                '16'=>'16:00',
                                '17'=>'17:00',
                                '18'=>'18:00',
                                '19'=>'19:00',
                                '20'=>'20:00',
                                '21'=>'21:00',
                                '22'=>'22:00',
                                '23'=>'23:00',
                                '24'=>'24:00'
                            ],['class' => 'select-update'])->label(false) ?>
                        </div>
                        <div class="state-td" style="width: 50%">
                            <?= $form->field($model, 'quiet_time_end')->dropDownList([
                                '0' => '00:00',
                                '1' => '01:00',
                                '2'=>'02:00',
                                '3'=>'03:00',
                                '4'=>'04:00',
                                '5'=>'05:00',
                                '6'=>'06:00',
                                '7'=>'07:00',
                                '8'=>'08:00',
                                '9'=>'09:00',
                                '10'=>'10:00',
                                '11'=>'11:00',
                                '12'=>'12:00',
                                '13'=>'13:00',
                                '14'=>'14:00',
                                '15'=>'15:00',
                                '16'=>'16:00',
                                '17'=>'17:00',
                                '18'=>'18:00',
                                '19'=>'19:00',
                                '20'=>'20:00',
                                '21'=>'21:00',
                                '22'=>'22:00',
                                '23'=>'23:00',
                                '24'=>'24:00'
                            ],['class' => 'select-update'])->label(false) ?>
                        </div>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="elem-th">
                        <span>Купюры</span>
                    </div>
                    <div id="bills" class="elem-td">
                        <?= $form->field($model, 'bills')->textInput([
                            'class' => 'bills-change-page input-update'
                        ])->label(false) ?>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="elem-th">
                        <span>ID устройства</span>
                    </div>
                    <div id="bills" class="elem-td" style="text-align: center; font-size: 16px;">
                        <?= $model->device_id ?>
                        <!--                        /*= $form->field($model, 'description')->textInput([
                                                    'class' => 'bills-change-page input-update'
                                                ])->label(false) -->
                    </div>
                </div>
            </div>
            <div id="btn-change-form-device" class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-raised btn-success ' : 'btn btn-raised btn-primary']) ?>
            </div>
        </div>
    </div>
</div>


<?php ActiveForm::end(); ?>
