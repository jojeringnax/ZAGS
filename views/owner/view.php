<?php
/**
 * @var $id integer
 * @var $events array
 * @var $totales array
 */
$bin = false;
$sum_game = 0;
$mounthName = array(
    1 => 'Январь',
    2 => 'Февраль',
    3 => 'Март',
    4 => 'Апрель',
    5 => 'Май',
    6 => 'Июнь',
    7 => 'Июль',
    8 => 'Август',
    9 => 'Сентябрь',
    10 => 'Октябрь',
    11 => 'Ноябрь',
    12 => 'Декабрь',
);
$dateTime = DateTime::createFromFormat('Y-m-d', array_keys($events)[0]);
$this->title = 'Метрики устройства №'.$id;
$this->params['breadcrumbs'][] = ['label' => 'Устройства', 'url' => ['index', 'r' => 'owner']];
$this->params['breadcrumbs'][] = ['label' => 'Метрики устройства №'.$id];

?>

<h1>Метрики устройства №<?= $id ?></h1>
<form class="filter-statistics bmd-form-group d-flex flex-wrap" action="" method="">
    <!-- <div class="filter-checlbox d-flex flex-wrap"> -->
        <div class="checkbox">
            <label class="item-statistics-filter" for="data">
                <input id="data" checked class="checkbox-inp-stat" value="data" type="checkbox" aria-label="Checkbox for following text input">
                <span class="checkbox-decorator">
                    <span class="check"></span>
                </span>
                <span style="margin-top: -3px; display: block">Дата</span>
            </label>
        </div>
        <div class="checkbox">
            <label class="item-statistics-filter" for="sum_total">
                <input id="sum_total" checked class="checkbox-inp-stat" value="sum_total" type="checkbox" aria-label="Checkbox for following text input">
                <span class="checkbox-decorator">
                    <span class="check"></span>
                </span>
                <span style="margin-top: -3px; display: block">Оборот (всего)</span>
            </label>
        </div>
        <div class="checkbox">
            <label class="item-statistics-filter" for="sum_cash">
                <input id="sum_cash" checked class="checkbox-inp-stat" value="sum_cash" type="checkbox" aria-label="Checkbox for following text input">
                <span class="checkbox-decorator">
                    <span class="check"></span>
                </span>
                <span style="margin-top: -3px; display: block">Оборот (нал)</span>
            </label>
        </div>
        <div class="checkbox">
            <label class="item-statistics-filter" for="sum_cashless">
                <input id="sum_cashless" checked class="checkbox-inp-stat" value="sum_cashless" type="checkbox" aria-label="Checkbox for following text input">
                <span class="checkbox-decorator">
                    <span class="check"></span>
                </span>
                <span style="margin-top: -3px; display: block">Оборот (без/нал)</span>
            </label>
        </div>
        <div class="checkbox">
            <label class="item-statistics-filter" for="amount_of_wed">
                <input id="amount_of_wed" checked class="checkbox-inp-stat" value="amount_of_wed" type="checkbox" aria-label="Checkbox for following text input">
                <span class="checkbox-decorator">
                    <span class="check"></span>
                </span>
                <span style="margin-top: -3px; display: block">Игр "Свадьба"</span>
            </label>
        </div>
        <div class="checkbox">
            <label class="item-statistics-filter" for="conversion_of_wedding">
                <input id="conversion_of_wedding" checked class="checkbox-inp-stat" value="conversion_of_wedding" type="checkbox" aria-label="Checkbox for following text input">
                <span class="checkbox-decorator">
                    <span class="check"></span>
                </span>
                <span style="margin-top: -3px; display: block">Конверсия "Свадьбы"</span>
            </label>
        </div>
        <div class="checkbox">
            <label class="item-statistics-filter" for="amount_of_talisman">
                <input id="amount_of_talisman" checked class="checkbox-inp-stat" value="amount_of_talisman" type="checkbox" aria-label="Checkbox for following text input">
                <span class="checkbox-decorator">
                    <span class="check"></span>
                </span>
                <span style="margin-top: -3px; display: block">Игр "Талисман"</span>
            </label>
        </div>
        <div class="checkbox">
            <label class="item-statistics-filter" for="conversion_of_talisman">
                <input id="conversion_of_talisman" checked class="checkbox-inp-stat" value="conversion_of_talisman" type="checkbox" aria-label="Checkbox for following text input">
                <span class="checkbox-decorator">
                    <span class="check"></span>
                </span>
                <span style="margin-top: -3px; display: block">Конверсия "Талисманов"</span>
            </label>
        </div>
        <!-- <label class="item-statistics-filter d-flex align-items-center" for="sum_total"><input id="sum_total" checked class="checkbox-inp-stat" value="sum_total" type="checkbox" aria-label="Checkbox for following text input">Оборот (всего)</label>
        <label class="item-statistics-filter d-flex align-items-center" for="sum_cash"><input id="sum_cash" checked class="checkbox-inp-stat" value="sum_cash" type="checkbox" aria-label="Checkbox for following text input">Оборот (нал)</label>
        <label class="item-statistics-filter d-flex align-items-center" for="sum_cashless"><input id="sum_cashless" checked class="checkbox-inp-stat" value="sum_cashless" type="checkbox" aria-label="Checkbox for following text input">Оборот (без/нал)</label>
        <label class="item-statistics-filter d-flex align-items-center" for="amount_of_wed"><input id="amount_of_wed" checked class="checkbox-inp-stat" value="amount_of_wed" type="checkbox" aria-label="Checkbox for following text input">Игр "Свадьба"</label>
        <label class="item-statistics-filter d-flex align-items-center" for="conversion_of_wedding"><input id="conversion_of_wedding" checked class="checkbox-inp-stat" value="conversion_of_wedding" type="checkbox" aria-label="Checkbox for following text input">Конверсия "Свадьбы"</label>
        <label class="item-statistics-filter d-flex align-items-center" for="amount_of_talisman"><input id="amount_of_talisman" checked class="checkbox-inp-stat" value="amount_of_talisman" type="checkbox" aria-label="Checkbox for following text input">Игр "Талисман"</label>
        <label class="item-statistics-filter d-flex align-items-center" for="conversion_of_talisman"><input id="conversion_of_talisman" checked class="checkbox-inp-stat" value="conversion_of_talisman" type="checkbox" aria-label="Checkbox for following text input">Конверсия "Талисманов"</label>
        <label class="item-statistics-filter d-flex align-items-center" for=""><input id="" checked class="checkbox-inp-stat" value="#3" type="checkbox" aria-label="Checkbox for following text input">Игра№3</label>
        <label class="item-statistics-filter d-flex align-items-center" for=""><input id="" checked class="checkbox-inp-stat" value="#4" type="checkbox" aria-label="Checkbox for following text input">Игра№4</label>
        <label class="item-statistics-filter d-flex align-items-center" for=""><input id="" checked class="checkbox-inp-stat" value="#5" type="checkbox" aria-label="Checkbox for following text input">Игра№5</label>
        <label class="item-statistics-filter d-flex align-items-center" for=""><input id="" checked class="checkbox-inp-stat" value="$6" type="checkbox" aria-label="Checkbox for following text input">Игра№6</label> -->
        <!-- <input id="stat-filter" class="btn btn-success" type="submit" name="" value="GO!!" style="margin-left: 30px; height: 40px; border-bottom: 0.5rem"> -->
    <!-- </div> -->
</form>
        <?php
        $flag = true;
        foreach ($events as $data => $eventArray) {
            if ($eventArray === []) {
                $sumCash = 0;
                $sumCashless = 0;
                $sumWeddings1 = 0;
                $sumWeddings2 = 0;
                $sumWeddings = 0;
                $sumTalisman = 0;
                $wedPayView = 1;
                $talPayView = 1;
            }
            if(preg_split('/-/', $data)[1] !== $dateTime->format('m')) {
                $flag = true;
                ?>
            </tbody></table></div></div>

            <?php }
            if ($flag) { ?>
                <div class="month_before card">
                    <a class="collapse-link" data-toggle="collapse" href="#month_<?= date('Y_m', strtotime($data)) ?>" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <?= $mounthName[preg_split('/-/', $data)[1]] ?> - Оборот наличными: <?= $totales[preg_split('/-/', $data)[1]]['Money'] ?> - Оборот б/нал: <?= $totales[preg_split('/-/', $data)[1]]['Cashless'] ?> - Оборот всего: <?= $totales[preg_split('/-/', $data)[1]]['Cashless'] + $totales[preg_split('/-/', $data)[1]]['Money'] ?>
                    </a>
                <div class="collapse" id="month_<?= date('Y_m', strtotime($data)) ?>">
                    <table class="table table-striped" style="margin-top:10px;">
                        <thead class="thead-light">
                        <tr style="font-size: 13px;">
                            <th class="data" scope="col">Дата</th>
                            <th class="sum_total" scope="col">Оборот (всего)</th>
                            <th class="sum_cash" scope="col">Оборот (нал)</th>
                            <th class="sum_cashless" scope="col">Оборот (без/нал)</th>
                            <th class="amount_of_wed" scope="col">Игр "Свадьба"</th>
                            <th class="conversion_of_wedding" scope="col">Конверсия "Свадьбы"</th>
                            <th class="amount_of_talisman" scope="col">Игр "Талисман"</th>
                            <th class="conversion_of_talisman" scope="col">Конверсия "Талисманов"</th>
                        </tr>
                        </thead>
                        <tbody>
                <?php  } ?>
                    <tr class="data-metrics">
                        <td id="data" class="data">
                            <?= $data ?>
                        </td>
                        <?php
                        $sumCash = 0;
                        $sumCashless = 0;
                        foreach($eventArray as $eventName => $eventss) {
                            if ($eventName == 'Money') {
                                foreach ($eventss as $value) {
                                    $sumCash += $value->data;
                                }
                            }

                            if ($eventName == 'Cashless') {
                                foreach ($eventss as $value) {
                                    $sumCashless += $value->data;
                                }
                            }
                            if ($eventName === app\models\events\Wedding::CONDITION['name'][0]) {
                                $sumWeddings1 = count($eventss);
                            }

                            if ($eventName === app\models\events\Wedding::CONDITION['name'][0]) {
                                $sumWeddings2 = count($eventss);
                            }

                            if ($eventName === app\models\events\Talisman::CONDITION['name']) {
                                $sumTalisman = count($eventss);
                            }


                            if ($eventName === app\models\events\TalismanPaymentView::CONDITION['name']) {
                                $talPayView = count($eventss);
                            }

                            if ($eventName === app\models\events\WeddingPaymentView::CONDITION['name'][0]) {
                                $wedPayView1 = count($eventss);
                            }

                            if ($eventName === app\models\events\WeddingPaymentView::CONDITION['name'][1]) {
                                $wedPayView2 = count($eventss);
                            }

                            $wedPayView = isset($wedPayView1) ? $wedPayView1 : 0  + isset($wedPayView2) ? $wedPayView2 : 0;
                            $sumWeddings = isset($sumWeddings1) ? $sumWeddings1 : 0  + isset($sumWeddings2) ? $sumWeddings2 : 0;
                        } ?>
                        <?php if(!empty($events)) { ?>
                            <td class="sum_total">
                                <?= $sumCash + $sumCashless ?>
                            </td>
                            <td class="sum_cash">
                                <?= isset($sumCash) ? $sumCash : 0 ?>
                            </td>
                            <td class="sum_cashless">
                                <?= isset($sumCashless) ? $sumCashless : 0 ?>
                            </td>
                            <!-- <div class="game item-metrics"> -->
                                <td class="amount_of_wed">
                                    <?= $sumWeddings ?>
                                </td>
                            <!-- </div> -->

                            <!-- <div id="" class="conversion item-metrics"> -->
                                <td class="conversion_of_wedding">
                                    <?= $wedPayView !== 0 ? number_format($sumWeddings / $wedPayView * 100, 2, '.', ' ') . '%' : '0.00%' ?>
                                </td>
                            <!-- </div> -->

                            <!-- <div class="game item-metrics"> -->
                                <td class="amount_of_talisman">
                                    <?= isset($sumTalisman) ? $sumTalisman : 0 ?>
                                </td>
                            <!-- </div> -->

                            <!-- <div id="" class="conversion item-metrics"> -->
                                <td class=" conversion_of_talisman">
                                    <?= isset($talPayView) && isset($sumTalisman) ? number_format($sumTalisman / $talPayView * 100, 2, '.', ' ') . '%' : 0 ?>
                                </td>
                            <!-- </div> -->
                        </tr>

                    </div>
                    <?php
                    }
                    $dateTime->modify($data);
                    $flag = false;
                } ?>
            </tbody>
        </table>
    </div>
</div>
