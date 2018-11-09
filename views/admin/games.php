<?php
/**
 * @var $games \app\models\Events[]
 */
use yii\grid\GridView;

 echo GridView::widget([
    'dataProvider' => $games,
    'tableOptions' => [
        'class' => 'table table-striped table-bordered',
        'id' => 'games_table'
    ]
]);

 ?>
