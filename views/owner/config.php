<?php
/**
 * @var $dataProvider \yii\data\ActiveDataProvider
 * @var $this yii\web\View
 **/

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Настройки устройства №' . $id;
$this->params['breadcrumbs'][] = ['label' => 'Устройства', 'url' => ['index', 'r' => 'owner']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1>Настройки устройства №<?=$id?></h1>
<?=
GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'wedding_price',
        'reprint_price',
        'device_id',
        ['label' => 'Состояние аппарата', 'value' => function($model) {
            return $model->disabled ? "Включен" : "Выключен";
        }],
        ['label' => 'Мультитач', 'value' => function($model) {
            return $model->multitouch_enabled ? "Включен" : "Выключен";
        }],
        'kinoselfie_price',
        'talisman_price',
        'quiet_time_start',
        'quiet_time_end',
        ['label' => 'Количество тонера', 'value' => 'toner'],
        ['class' => \yii\grid\ActionColumn::className(),
            'buttons'=>[
                'view'=>function ($url, $model) {
                    $customurl=Yii::$app->getUrlManager()->createUrl(['owner/update','id'=>$model['device_id']]);
                    return \yii\helpers\Html::a( '<span class="oi oi-pencil"></span>', $customurl,
                        ['title' => "Настройки", 'data-pjax' => '0']);
                }
            ],
            'template'=>'{view}',
        ]
    ],
    'summary'=>'',
]); ?>
