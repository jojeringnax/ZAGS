<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Запросы на активацию';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1>Запросы на активацию</h1>

<?=
GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['attribute'=>'Номер запроса', 'value'=>'id'],
        ['attribute'=>'Лицензионный ключ', 'value'=>'license'],

        ['class' => \yii\grid\ActionColumn::className(),
            'buttons'=>[
                'config'=>function ($url, $model) {
                    $customurl=Yii::$app->getUrlManager()->createUrl(['admin/delete_request','id'=>$model['id']]);
                    return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-remove"></span>', $customurl,
                        ['title' => "Удалить", 'data-pjax' => '0',
                            'data-confirm' => 'Вы уверены?',
                            'data-method' => 'post']);
                },
                'view'=>function ($url, $model) {
                    $customurl=Yii::$app->getUrlManager()->createUrl(['admin/activate_request','id'=>$model['id']]);
                    return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-ok"></span>', $customurl,
                        ['title' => "Активировать", 'data-pjax' => '0']);
                }
            ],
            'template'=>'{config}   {view}',
        ]
    ],
    'summary'=>'',

]); ?>
