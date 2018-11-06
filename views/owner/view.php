<?php

use yii\bootstrap\Collapse;
use yii\grid\GridView;

$this->title = 'Метрики устройства №'.$model->device_id;
$this->params['breadcrumbs'][] = ['label' => 'Устройства', 'url' => ['index', 'r' => 'owner']];
$this->params['breadcrumbs'][] = ['label' => 'Метрики устройства №'.$model->device_id, 'url' => ['owner/view', 'id' => $model->device_id]];
?>
<h1>Метрики устройства №<?=$model->device_id?></h1>

<?=
Collapse::widget([
    'items' => [
        [
            'label' => strftime('%B', mktime(0, 0, 0, date('m'))) .': '.$total_revenue1.' рублей, '.$total_games1.' игр, конверсия '.$total_conversion1,
            'content' => [GridView::widget([
                'dataProvider' => $dataProvider1,
                'columns' => [
                    ['attribute'=>'День', 'value'=>'date'],
					['attribute'=>'Оборот (всего)', 'value'=>'revenueTotal'],
                    ['attribute'=>'Оборот (нал.)', 'value'=>'revenueCash'],
					['attribute'=>'Оборот (б/нал.)', 'value'=>'revenueCashless'],
                    ['attribute'=>'Игр (свадьба)', 'value'=>'gamesWedding'],
                    ['attribute'=>'Конверсия (свадьба)', 'value'=>'conversionWedding'],
                    ['attribute'=>'Игр (талисман)', 'value'=>'gamesTalisman'],
                    ['attribute'=>'Конверсия (талисман)', 'value'=>'conversionTalisman'],
                ],
                'summary' => '',
            ])],
            'contentOptions' => [
                'class' => 'in'
            ]
        ],
        [
            'label' => strftime('%B', mktime(0, 0, 0, date('m')-1)) .': '.$total_revenue2.' рублей, '.$total_games2.' игр, конверсия '.$total_conversion2,
            'content' => GridView::widget([
                'dataProvider' => $dataProvider2,
                'columns' => [
                    ['attribute'=>'День', 'value'=>'date'],
					['attribute'=>'Оборот (всего)', 'value'=>'revenueTotal'],
                    ['attribute'=>'Оборот (нал.)', 'value'=>'revenueCash'],
					['attribute'=>'Оборот (б/нал.)', 'value'=>'revenueCashless'],
                    ['attribute'=>'Игр (свадьба)', 'value'=>'gamesWedding'],
                    ['attribute'=>'Конверсия (свадьба)', 'value'=>'conversionWedding'],
                    ['attribute'=>'Игр (талисман)', 'value'=>'gamesTalisman'],
                    ['attribute'=>'Конверсия (талисман)', 'value'=>'conversionTalisman'],
                ],
                'summary' => '',
            ]),
            'contentOptions' => []
        ]
    ]
]);
?>