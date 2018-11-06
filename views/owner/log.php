<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

$this->title = 'Лог устройства №'.$model->device_id;
$this->params['breadcrumbs'][] = ['label' => 'Устройства', 'url' => ['index', 'r' => 'owner']];
$this->params['breadcrumbs'][] = $this->title;

$items = [
    'Trace' => 'Trace',
    'Debug' => 'Debug',
    'Info' => 'Info',
    'Warning' => 'Warning',
    'Error' => 'Error',
    'Fatal' => 'Fatal',
];
$form = ActiveForm::begin();
?>
<h1>Лог устройства №<?=$model->device_id?></h1>

<?= $form->field($model, 'log_level')->DropDownList($items) ?>

<div class="form-group">
    <?= Html::submitButton('Ок', ['class' => 'btn btn-success']) ?>
</div>

<?=
GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['attribute'=>'Время', 'value'=>'time'],
        ['attribute'=>'Уровень', 'value'=>'level'],
        ['attribute'=>'Источник', 'value'=>'sender'],
        ['attribute'=>'Сообщение', 'value'=>'message']
    ],
    'summary'=>'',
]);
?>

<?php ActiveForm::end(); ?>
