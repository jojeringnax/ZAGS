<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Настройки устройства №' . $model->device_id;
$this->params['breadcrumbs'][] = ['label' => 'Устройства', 'url' => ['index', 'r' => 'owner']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1>Настройки устройства №<?=$model->device_id?></h1>

<?=
GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['attribute'=>'Цена игры', 'value'=>'wedding_price'],
        ['attribute'=>'Цена повторной печати', 'value'=>'reprint_price'],
        ['attribute'=>'Отключение аппарата', 'value'=>'disabled_string'],
        ['attribute'=>'Купюры', 'value'=>'bills'],
        ['attribute'=>'Мультитач', 'value'=>'multitouch_string'],
        ['attribute'=>'Начало тихого режима', 'value'=>'quiet_time_start'],
        ['attribute'=>'Конец тихого режима', 'value'=>'quiet_time_end'],
        ['attribute'=>'Описание', 'value'=>'description'],
        ['class' => \yii\grid\ActionColumn::className(),
            'buttons'=>[
                'view'=>function ($url, $model) {
                    $customurl=Yii::$app->getUrlManager()->createUrl(['owner/update','id'=>$model['device_id']]);
                    return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-pencil"></span>', $customurl,
                        ['title' => "Настройки", 'data-pjax' => '0']);
                }
            ],
            'template'=>'{view}',
        ]
    ],
    'summary'=>'',
]); ?>
