<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/open-iconic/1.1.1/font/css/open-iconic-bootstrap.min.css" integrity="sha256-BJ/G+e+y7bQdrYkS2RBTyNfBHpA9IuGaPmf9htub5MQ=" crossorigin="anonymous" /> -->
<?php
/* @var $this yii\web\View */

/**
 * @var $data array = array(
        [$id] => [
 *          ['license'] => *****
 *          ['online'] => *****
 *          ['description'] => ****
 *          ['fill_wedding'] => ****
 *          ['stacker'] => ****
 *      ]
 * )
 *
 * For $loop use foreach($data as $id => $value) {
        $value['license']
 *      ...
 * }
 */

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
                    return \yii\helpers\Html::a( '<span class="oi oi-cog"></span>', $customurl,
                        ['title' => "Настройки", 'data-pjax' => '0']);
                },
                'view'=>function ($url, $model) {
                    $customurl=Yii::$app->getUrlManager()->createUrl(['owner/view','id'=>$model['device_id']]);
                    return \yii\helpers\Html::a( '<span class="oi oi-document"></span>', $customurl,
                        ['title' => "Статистика", 'data-pjax' => '0']);
                },
                'encashment'=>function ($url, $model) {
                    $customurl=Yii::$app->getUrlManager()->createUrl(['owner/encashment','id'=>$model['device_id']]);
                    return \yii\helpers\Html::a( '<span class="oi oi-briefcase"></span>', $customurl,
                        ['title' => "Статистика", 'data-pjax' => '0']);
                },
                /*'log'=>function ($url, $model) {
                    $customurl=Yii::$app->getUrlManager()->createUrl(['owner/log','id'=>$model['device_id']]);
                    return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-th-list"></span>', $customurl,
                        ['title' => "Лог", 'data-pjax' => '0']);
                }*/
            ],
            /*'template'=>'{config}   {view}   {log}',*/
			'template'=>'<div class="flex">{config} {view} {encashment}</div>',
        ]
    ],
     'summary'=>'',

]); ?>
