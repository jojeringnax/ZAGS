<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;


$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1>Пользователи</h1>

<?php
echo "<p><a class=\"btn btn-lg btn-success\" href = \"index.php?r=admin/add_user\" > Добавить пользователя </a></p>";
?>

<?=

GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['attribute'=>'Логин', 'value'=>'username'],
        ['class' => \yii\grid\ActionColumn::className(),
            'buttons' => [
                'view' => function ($url, $model) {
                    $customurl = Yii::$app->getUrlManager()->createUrl(['admin/delete_user', 'id' => $model['id']]);
                    return \yii\helpers\Html::a('<span class="oi oi-delete"></span>', $customurl,
                        ['title' => "Удалить", 'data-pjax' => '0']);
                }
            ],
            'template' => '{view}',
        ]
    ],
    'summary' => '',
]);
?>
