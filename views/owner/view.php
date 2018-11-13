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
<?php foreach ($events as $data => $eventArray) {
    if(date('m') === preg_split('/-/', $data)[1]) {
        echo '</div><div class="current_month container">';
    }
    ?>
    <div class="data d-flex row">
        <div class="date col-4">
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
                <div class="item-metrics sum_total col-2">
                    <?= $sum_total ?>
                </div>
                <div class="item-metrics sum_cash col-1">
                    <?= $sum_cash ?>
                </div>
                <div class="item-metrics sum_cashless col-1">
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

            <div class="game">
                <div id="amount_of_wed" class="item-metrics wedings col-1">
                    <?= $sumWeddings ?>
                </div>
            </div>

            <div id="" class="conversion">
                <div id="conversion_of_wedding" class="item-metrics wed col-1">
                    <?= $wedPayView !== 0 ? number_format($sumWeddings / $wedPayView * 100, 2, '.', ' ') . '%' : 0 ?>
                </div>
            </div>

            <div class="game">
                <div id="amount_of_talisman" class="item-metrics talisman  col-1">
                    <?= isset($sumTalisman) ? $sumTalisman : 0 ?>
                </div>
            </div>

            <div id="" class="conversion">
                <div id="conversion_of_talisman" class="item-metrics talisman col-1">
                    <?= isset($talPayView) && isset($sumTalisman) ? number_format($sumTalisman / $talPayView * 100, 2, '.', ' ') . '%' : 0 ?>
                </div>
            </div>
    </div>
<?php } ?>
</div>
