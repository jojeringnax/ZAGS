<?php
/**
 * @var $dataProvider \yii\data\ActiveDataProvider
 */

use yii\grid\GridView;

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'tableOptions' => [
        'class' => 'table table-striped table-bordered',
        'id' => 'games_table'
    ],
    'pager' => [
        'options' => [
            'class' => 'pagination'
        ],
        'linkOptions' => [
            'class' => 'page-link'
        ],
        'linkContainerOptions' => [
            'class' => 'page-item'
        ],
        'prevPageCssClass' => [
            'class' => 'prev'
        ],
        'prevPageLabel' => '<-',
        'nextPageLabel' => '->'
    ]
]);