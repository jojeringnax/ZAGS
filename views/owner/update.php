<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Изменение настроек устройства № ' . $model->device_id;
$this->params['breadcrumbs'][] = ['label' => 'Устройства', 'url' => ['index', 'r' => 'owner']];
$this->params['breadcrumbs'][] = ['label' => 'Настройки устройства №'.$model->device_id, 'url' => ['config', 'id' => $model->device_id]];
$this->params['breadcrumbs'][] = ['label' => 'Редактирование'];
?>
<div class="container">
    <div class="row d-flex justify-content-center">
        <div id="change-form-device" class="card col-8" style="padding: 0">
            <div class="bg-primary card-header d-flex justify-content-center" style="font-weight: bold">
                <div class="elem-th">
                    <span>Номер устройства № </span>
                </div>
                <div class="elem-td">
                    <span> <?= $model->device_id ?></span>
                </div>
            </div>
            <div class="d-flex">
                <div class="elem-card-inf th th-card-inf">
                    <div class="elem-th">
                        <span>Цена Талисмана</span>
                    </div>
                    <div class="elem-th">
                        <span>Цена Свадьбы</span>
                    </div>
                    <div class="elem-th">
                        <span>Цена Селфи</span>
                    </div>
                    <div class="elem-th">
                        <span>Цена Instagram</span>
                    </div>
                    <div class="elem-th">
                        <span>Состояние аппарата</span>
                    </div>
                    <div class="elem-th">
                        <span>Тихий режим</span>
                    </div>
                    <div class="elem-th">
                        <span>Купюры</span>
                    </div>
                </div>
                <?php $form = ActiveForm::begin([
                    'options' => [
                        'class' => 'change-form'
                    ]
                ]); ?>
                <div class="elem-card-inf td-card-inf" style="width: 100%">
                    <div id="talisman-change" class="elem-td">
                        <?= $form->field($model, 'talisman_price')->textInput()->label(false) ?>
                    </div>
                    <div class="elem-td d-flex justify-content-between">
                        <div class="state-td" style="width: 48%">
                            <?= $form->field($model, 'wedding_price')->textInput()->label(false) ?>
                        </div>
                        <div class="state-td" style="width: 48%">
                            <?= $form->field($model, 'reprint_price')->textInput()->label(false) ?>
                        </div>
                    </div>
                    <div class="elem-td d-flex justify-content-between">
                        <div class="state-td" style="width: 48%">
                            <?= $form->field($model, 'kinoselfie_price')->textInput()->label(false) ?>
                        </div>
                        <div class="state-td" style="width: 48%">
                            <?= $form->field($model, 'wedding_price')->textInput()->label(false) ?>
                        </div>
                    </div>
                    <div class="elem-td">
                        <div class="state-td d-flex align-items-center justify-content-center" style="width: 33%">
                            0
                        </div>
                        <div class="state-td d-flex align-items-center justify-content-center" style="width: 33%">
                            0
                        </div>
                        <div class="state-td d-flex align-items-center justify-content-center" style="width: 33%">
                            0
                        </div>
                    </div>
                    <div id="state-device"  class="elem-td" style="width: 100%">
                        <?= $form->field($model, 'disabled', [
                            'labelOptions' => [ 'class' => '']
                        ])->DropDownList(['1' => 'Выключен', '0' => 'Включен'])->label(false) ?>
                    </div>
                    <div class="elem-td d-flex justify-content-between">
                        <div class="state-td" style="width: 48%">
                            <?= $form->field($model, 'quiet_time_start', [
                                'labelOptions' => [ 'class' => 'bmd-label-static']
                            ])->textInput()->label(false) ?>
                        </div>
                        <div class="state-td" style="width: 48%">
                            <?= $form->field($model, 'quiet_time_end', [
                                'labelOptions' => [ 'class' => 'bmd-label-static']
                            ])->textInput()->label(false) ?>
                        </div>

                    </div>
                    <div class="elem-td d-flex justify-content-between">
                        <span>100, 200, 500</span>
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
