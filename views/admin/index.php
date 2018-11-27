<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;
$this->title = 'Устройства и лицензии';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1>Устройства и лицензии</h1>

<?=
     GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['attribute'=>'Номер устройства', 'value'=>'id'],
        ['attribute'=>'Лицензионный ключ', 'value'=> 'license'],
        ['attribute'=>'Online', 'value'=> function ($data) {
            if ($data['online'] > 10)
            {
                return "Оффлайн";
            } else {
                return "Онлайн";
            }
        }],

        ['class' => \yii\grid\ActionColumn::className(),
            'buttons'=>[
                'config'=>function ($url, $model) {
                    $customurl=Yii::$app->getUrlManager()->createUrl(['admin/delete_license','id'=>$model['id']]);
                    return \yii\helpers\Html::a( '<div class="d-flex"><span class="oi oi-delete"></span>', $customurl,
                        ['title' => "Удалить", 'data-pjax' => '0']);
                },
                'view'=>function ($url, $model) {
                    $customurl=Yii::$app->getUrlManager()->createUrl(['admin/select_user','id'=>$model['id']]);
                    return \yii\helpers\Html::a( '<span class="oi oi-people" style="margin-left:10px;"></span></div>', $customurl,
                        ['title' => "Подробности", 'data-pjax' => '0']);
                }
            ],
            'template'=>'{config} {view}',
        ]
    ],
         'summary'=>'',

]); ?>
