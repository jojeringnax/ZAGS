<?php
/**
 * @var $id integer
 * @var $events array
 */
$sum_game = 0;
$this->title = 'Метрики устройства №'.$id;
$this->params['breadcrumbs'][] = ['label' => 'Устройства', 'url' => ['index', 'r' => 'owner']];
$this->params['breadcrumbs'][] = ['label' => 'Метрики устройства №'.$id, 'url' => ['owner/view', 'id' => $id]];

?>
<h1>Метрики устройства №<?= $id ?></h1>
<div class="month_before">
    <div class="head-metrics d-flex row">
        <div class="item-head-metrics date-head">
            <span style="">Дата</span>
        </div>
        <div class="item-head-metrics turnover">
            <span>Оборот (всего)</span>
        </div>
        <div class="item-head-metrics">
            <span>Оборот (нал)</span>
        </div>
        <div class="item-head-metrics">
            <span>Оборот (без/нал)</span>
        </div>
        <div class="item-head-metrics">
            <span>Игр "Свадьба"</span>
        </div>
        <div class="item-head-metrics">
            <span>Конверсия "Свадьбы"</span>
        </div>
        <div class="item-head-metrics">
            <span>Игр "Талисман"</span>
        </div>
        <div class="item-head-metrics">
            <span>Конверсия "Талисманов"</span>
        </div>
    </div>
<?php foreach ($events as $data => $eventArray) {
    if(date('m') === preg_split('/-/', $data)[1]) {
        echo '</div><div class="current_month">';
    }
    ?>

    <div class="data-metrics d-flex row ">
        <div class="date item-metrics">
            <?= $data ?>
        </div>
        <?php foreach($eventArray as $eventName => $eventss) {

            if(in_array($eventName, app\models\events\Payment::CONDITION['name'])) {
                $sum_cash = 0;
                $sum_cashless = 0;
                if ($eventName === 'Money') {
                    foreach ($eventss as $value) {
                        $sum_cash += $value->data;
                    }
                } else {
                    foreach ($eventss as $value) {
                        $sum_cashless += $value->data;
                    }
                }

                $sum_total = $sum_cashless + $sum_cash;
                ?>
                <div class="item-metrics sum_total">
                    <?= $sum_total ?>
                </div>
                <div class="item-metrics sum_cash">
                    <?= $sum_cash ?>
                </div>
                <div class="item-metrics sum_cashless">
                    <?= $sum_cashless ?>
                </div>
            <?php } // if(in_array($eventName, app\models\events\Payment::CONDITION['name']))?>

            <?php
                if($eventName === app\models\events\Wedding::CONDITION['name'][0]) {
                    $sumWeddings1 = count($eventss);
                }

                if($eventName === app\models\events\Wedding::CONDITION['name'][0]) {
                    $sumWeddings2 = count($eventss);
                }

                if($eventName === app\models\events\Talisman::CONDITION['name']) {
                    $sumTalisman = count($eventss);
                }


                if($eventName === app\models\events\TalismanPaymentView::CONDITION['name']) {
                    $talPayView = count($eventss);
                }

                if($eventName === app\models\events\WeddingPaymentView::CONDITION['name'][0]) {
                    $wedPayView1 = count($eventss);
                }

                if($eventName === app\models\events\WeddingPaymentView::CONDITION['name'][1]) {
                    $wedPayView2 = count($eventss);
                }

                $wedPayView = isset($wedPayView1) ? $wedPayView1 : 0  + isset($wedPayView2) ? $wedPayView2 : 0;
                $sumWeddings = isset($sumWeddings1) ? $sumWeddings1 : 0  + isset($sumWeddings2) ? $sumWeddings2 : 0;
            } // foreach($eventArray as $eventName => $eventss) {
            ?>

            <div class="game item-metrics">
                <div id="amount_of_wed" class="weddings">
                    <?= $sumWeddings ?>
                </div>
            </div>

            <div id="" class="conversion item-metrics">
                <div id="conversion_of_wedding" class="wed">
                    <?= $wedPayView !== 0 ? number_format($sumWeddings / $wedPayView * 100, 2, '.', ' ') . '%' : 0 ?>
                </div>
            </div>

            <div class="game item-metrics">
                <div id="amount_of_talisman" class="talisman">
                    <?= isset($sumTalisman) ? $sumTalisman : 0 ?>
                </div>
            </div>

            <div id="" class="conversion item-metrics">
                <div id="conversion_of_talisman" class=" talisman">
                    <?= isset($talPayView) && isset($sumTalisman) ? number_format($sumTalisman / $talPayView * 100, 2, '.', ' ') . '%' : 0 ?>
                </div>
            </div>
    </div>
<?php } ?>
</div>
