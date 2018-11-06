<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;


$this->title = 'Устройство №'.$deviceID;
$this->params['breadcrumbs'][] = ['label' => 'Устройства и лицензии', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1>Текущий владелец</h1>

<?=
GridView::widget([
    'dataProvider' => $dataProvider2,
    'columns' => [
        ['attribute'=>'Логин', 'value'=>'username'],
        ['class' => \yii\grid\ActionColumn::className(),
            'buttons'=>[
                'delete'=>function ($url, $model) use($deviceID) {
                    $customurl=Yii::$app->getUrlManager()->createUrl(['admin/delete_owner', 'deviceID' => $deviceID, 'userID' => $model['id']]);
                    return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-remove"></span>', $customurl,
                        ['title' => "Удалить", 'data-pjax' => '0']);
                }
            ],
            'template'=>'{delete}',
        ]
    ],
    'summary' => '',
]);
?>

<h1>Добавить владельца</h1>
<?=
GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['attribute'=>'Логин', 'value'=>'username'],
        ['class' => \yii\grid\ActionColumn::className(),
            'buttons' => [
                'add' => function ($url, $model) use ($deviceID) {
                    $customurl = Yii::$app->getUrlManager()->createUrl(['admin/assign_user', 'userID' => $model['id'], 'deviceID' => $deviceID]);
                    return \yii\helpers\Html::a('<span class="glyphicon glyphicon-ok"></span>', $customurl,
                        ['title' => "Назначить", 'data-pjax' => '0']);
                }
            ],
            'template' => '{add}',
        ]
    ],
    'summary' => '',
]);
?>
