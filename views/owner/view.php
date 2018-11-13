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
            <?php } ?>

            <?php
                if(in_array($eventName, app\models\events\Wedding::CONDITION['name'])) {
                    $sum_weddings = count($eventss);
                }

                if($eventName === app\models\events\Talisman::CONDITION['name']) {
                    $sum_talismans = count($eventss);
                }


                if($eventName === app\models\events\TalismanPaymentView::CONDITION['name']) {
                    $talPayView = count($eventss);
                }

                if($eventName === app\models\events\WeddingPaymentView::CONDITION['name']) {
                    $wedPayView = count($eventss);
                }
            }
            ?>

            <div class="game">
                <div id="amount_of_wed" class="item-metrics wedings col-1">
                    <?= isset($sum_weddings) ? $sum_weddings : 0 ?>
                </div>
            </div>

            <div id="" class="conversion">
                <div id="wed_of_talisman" class="item-metrics wed col-1">
                    <?= isset($wedPayView ) ? $wedPayView  : 0 ?>
                </div>
            </div>

            <div class="game">
                <div id="amount_of_talisman" class="item-metrics talisman  col-1">
                    <?= isset($sum_talismans) ? $sum_talismans : 0 ?>
                </div>
            </div>

            <div id="" class="conversion">
                <div id="conversion_of_talisman" class="item-metrics talisman col-1">
                    <?= isset($talPayView) && isset($sum_talismans) ? $talPayView/$sum_talismans*100 : 0 ?>
                </div>
            </div>
    </div>
<?php } ?>
</div>
