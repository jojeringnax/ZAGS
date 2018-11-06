<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Устройства';
$this->params['breadcrumbs'][] = $this->title;

?>
<h1>Устройства</h1>

<?=
     GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['attribute'=>'Номер устройства', 'value'=> 'device_id'],
        ['attribute'=>'Лицензионный ключ', 'value'=> 'license'],
        ['attribute'=>'Денег в кассете', 'value'=>'stacker'],
        ['attribute'=>'Дальномер 1', 'value'=>'fill_wedding'],
        ['attribute'=>'Online', 'value'=> function ($data) {
            if ($data['online'] > 180)
            {
                return "Оффлайн";
            } else {
                return "Онлайн";
            }
        }],
        ['attribute'=>'Описание', 'value'=>'description'],
        ['class' => \yii\grid\ActionColumn::className(),
            'buttons'=>[
                'config'=>function ($url, $model) {
                    $customurl=Yii::$app->getUrlManager()->createUrl(['owner/config','id'=>$model['device_id']]);
                    return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-cog"></span>', $customurl,
                        ['title' => "Настройки", 'data-pjax' => '0']);
                },
                'view'=>function ($url, $model) {
                    $customurl=Yii::$app->getUrlManager()->createUrl(['owner/view','id'=>$model['device_id']]);
                    return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-duplicate"></span>', $customurl,
                        ['title' => "Статистика", 'data-pjax' => '0']);
                },
                /*'log'=>function ($url, $model) {
                    $customurl=Yii::$app->getUrlManager()->createUrl(['owner/log','id'=>$model['device_id']]);
                    return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-th-list"></span>', $customurl,
                        ['title' => "Лог", 'data-pjax' => '0']);
                }*/
            ],
            /*'template'=>'{config}   {view}   {log}',*/
			'template'=>'{config}   {view}',
        ]
    ],
         'summary'=>'',

]); ?>
