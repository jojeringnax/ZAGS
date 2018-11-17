<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Изменение настроек устройства № ' . $model->device_id;
$this->params['breadcrumbs'][] = ['label' => 'Устройства', 'url' => ['index', 'r' => 'owner']];
$this->params['breadcrumbs'][] = ['label' => 'Настройки устройства №'.$model->device_id, 'url' => ['config', 'id' => $model->device_id]];
$this->params['breadcrumbs'][] = ['label' => 'Редактирование'];
?>
<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'wedding_price')->textInput() ?>
<?= $form->field($model, 'reprint_price')->textInput() ?>
<!--<?php //$form->field($model, 'bills')->textInput() ?>-->
<?= $form->field($model, 'disabled')->DropDownList(['1' => 'Выключен', '0' => 'Включен']) ?>
<?= $form->field($model, 'multitouch_enabled')->DropDownList(['0' => 'Выключен', '1' => 'Включен']) ?>
<?= $form->field($model, 'description')->textInput() ?>
<?= $form->field($model, 'quiet_time_start')->textInput() ?>
<?= $form->field($model, 'quiet_time_end')->textInput() ?>

<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
