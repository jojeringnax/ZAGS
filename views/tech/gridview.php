<?php
/**
 * @var $dataProvider \yii\data\ActiveDataProvider
 * @var $columns array
 */

use yii\grid\GridView;


<?php 
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'tableOptions' => [
        'class' => 'table table-striped table-bordered',
        'id' => 'games_table'
    ],
    'columns' => $columns,
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
]); ?>
