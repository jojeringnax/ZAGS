<?php
/**
 * @var $id integer
 * @var $events array
 * @var $totales array
 */
$bin = false;
$sum_game = 0;
use yii\helpers\Url;


$dateTime = DateTime::createFromFormat('Y-m-d', array_keys($events)[0]);
$this->title = 'Метрики устройства №'.$id;
$this->params['breadcrumbs'][] = ['label' => 'Устройства', 'url' => ['index', 'r' => 'owner&','scrollTop' => (isset($_GET['scrollTop'])? $_GET['scrollTop']:0)]];
$this->params['breadcrumbs'][] = ['label' => 'Метрики устройства №'.$id];

$this->registerJs("
    $('.amount_of_instargam a').click(function(e){
        e.preventDefault();
        if($(this).text() == 'Instagram') {
            document.location.href = $(this).attr('href') + '&scrollTop='+ ".(isset($_GET['scrollTop'])? $_GET['scrollTop']:0)."+ '&scrollTopInst=' + $(window).scrollTop();
        } else{
            document.location.href = $(this).attr('href');
        }
    });
");

$this->registerJs("
   $(document).ready(function() {
        window.scrollTo(0,".(isset($_GET['scrollTopInst'])? $_GET['scrollTopInst']:0).");
    });");
?>

<h1>Метрики устройства №<?= $id ?></h1>
<form class="filter-statistics bmd-form-group d-flex flex-wrap" action="" method="">
    <div class="filter-checlbox d-flex flex-wrap">
        <!--        <div class="checkbox">
                    <label class="item-statistics-filter" for="data">
                        <input id="conversion" class="checkbox-inp-stat" value="data" type="checkbox" aria-label="Checkbox for following text input">
                        <span class="checkbox-decorator">
                            <span class="check"></span>
                        </span>
                        <span style="margin-top: -3px; display: block">Показать конверсию</span>
                    </label>
                </div>
                <div class="checkbox">
                    <label class="item-statistics-filter" for="sum_total">
                        <input id="cash" class="checkbox-inp-stat" value="sum_total" type="checkbox" aria-label="Checkbox for following text input">
                        <span class="checkbox-decorator">
                            <span class="check"></span>
                        </span>
                        <span style="margin-top: -3px; display: block">Показать только наличные</span>
                    </label>
                </div>-->
        <div class="checkbox">
            <label class="item-statistics-filter" for="conversion">
                <input id="conversion" class="checkbox-inp-stat" value="conversion" type="checkbox" aria-label="Checkbox for following text input">
                <span class="checkbox-decorator">
                    <span class="check"></span>
                </span>
                <span style="margin-top: -3px; display: block">Показать конверсию</span>
            </label>
        </div>
        <div class="checkbox">
            <label class="item-statistics-filter" for="cash">
                <input id="cash" class="checkbox-inp-stat" value="cash" type="checkbox" aria-label="Checkbox for following text input">
                <span class="checkbox-decorator">
                    <span class="check"></span>
                </span>
                <span style="margin-top: -3px; display: block">Показать только наличные</span>
            </label>
        </div>
    </div>
    <!--        <div class="checkbox">
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
            </div>-->
</form>
<?php
$flag = true;
foreach ($events as $data => $eventArray) {
$sumCash = 0;
$sumCashless = 0;
$sumWeddings1 = 0;
$sumWeddings2 = 0;
$sumWeddings = 0;
$sumTalisman = 0;
$sumWeddingsReprint = 0;
$sumKinoselfieReprint = 0;
$sumWeddingsReprint1 = 0;
$sumWeddingsReprint2 = 0;
$sumKinoselfie = 0;
$wedPayView = 0;
$talPayView = 0;
if(date('m', strtotime($data)) !== $dateTime->format('m')) {
    if ($totales[date('m_Y', strtotime($data))]['Games'] === 0 && ($totales[date('m_Y', strtotime($data))]['Cashless'] + $totales[date('m_Y', strtotime($data))]['Money']) === 0) {
        continue;
    }
    $flag = true;
    ?>
    </tbody></table></div></div>

<?php }
if ($flag) { ?>
<div class="month_before card">
    <a class="collapse-link" data-toggle="collapse" href="#month_<?= date('Y_m', strtotime($data)) ?>" role="button" aria-expanded=" <?= date('m_Y') === date('m_Y', strtotime($data))?>" aria-controls="collapseExample">
        <?= $monthName[(integer)date('m', strtotime($data))] ?>
        - Оборот всего: <?= $totales[date('m_Y', strtotime($data))]['Cashless'] + $totales[date('m_Y', strtotime($data))]['Money'] ?>
        - Оборот нал: <?= $totales[date('m_Y', strtotime($data))]['Money'] ?>
        - Оборот б/нал: <?= $totales[date('m_Y', strtotime($data))]['Cashless'] ?>
        - Игр: <?= $totales[date('m_Y', strtotime($data))]['Games'] ?>
        - Свадеб: <?= $totales[date('m_Y', strtotime($data))]['Weddings'] ?>
        - Киноселфи: <?= $totales[date('m_Y', strtotime($data))]['Kinoselfies'] ?>
        - Талисманов: <?= $totales[date('m_Y', strtotime($data))]['Talismans'] ?>
    </a>
    <div class="collapse <?= date('m_Y') === date('m_Y', strtotime($data)) ? 'show' : ''?>" id="month_<?= date('Y_m', strtotime($data)) ?>">
        <table class="table table-striped" style="margin-top:10px;">
            <thead class="thead-light">
            <tr style="font-size: 13px;" class="text-center">
                <th class="text-center data" width="120" scope="col" style="vertical-align:middle;">Дата</th>
                <th class="text-center conv_cash cash sum_total" scope="col">Выручка</th>
                <th class="text-center conv_cash sum_cash" scope="col">Оборот (нал)</th>
                <th class="text-center conv_cash cash sum_cashless" scope="col">Оборот (без/нал)</th>
                <th class="text-center amount_of_wed" colspan="2" scope="col">Игр "Свадьба"</th>
                <th class="text-center conversion hide conversion_of_wedding" scope="col">Конверсия "Свадьбы"</th>
                <th class="text-center amount_of_selfie" colspan="2" scope="col">Селфи</th>
                <th class="text-center conversion hide amount_of_selfie" scope="col">Конверсия Киноселфи</th>
                <th class="text-center amount_of_talisman" scope="col">Игр "Талисман"</th>
                <th class="text-center conversion hide conversion_of_talisman" scope="col">Конверсия "Талисманов"</th>
                <th class="text-center amount_of_instargam" scope="col"><a href="<?= Url::to(['owner/instagram', 'id' => $id]) ?>">Instagram</a></th>
                <th class="text-center conversion hide amount_of_instargam" scope="col">Конверсия Instagram</th>
            </tr>
            </thead>
            <tbody>
            <?php  } ?>
            <tr class="data-metrics">
                <td id="text-center data" class="data">
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

                    if ($eventName === app\models\events\Wedding::CONDITION['name'][1]) {
                        $sumWeddings2 = count($eventss);
                    }

                    if ($eventName === app\models\events\Talisman::CONDITION['name']) {
                        $sumTalisman = count($eventss);
                        echo '<script>console.log("Date: '.$data.' Talisman: '.count($eventss).'")</script>';
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

                    if ($eventName === app\models\events\WeddingReprint::CONDITION['name'][0]) {
                        $sumWeddingsReprint1 = count($eventss);
                    }

                    if ($eventName === app\models\events\WeddingReprint::CONDITION['name'][1]) {
                        $sumWeddingsReprint2 = count($eventss);
                    }

                    if ($eventName === app\models\events\KinoselfieReprint::CONDITION['name']) {
                        $sumKinoselfieReprint = count($eventss);
                    }

                    if ($eventName === app\models\events\Kinoselfie::CONDITION['name']) {
                        $sumKinoselfie = count($eventss);
                    }

                    $wedPayView = (isset($wedPayView1) ? $wedPayView1 : 0)  +  (isset($wedPayView2) ? $wedPayView2 : 0);
                    $sumWeddings = (isset($sumWeddings1) ? $sumWeddings1 : 0)  + (isset($sumWeddings2) ? $sumWeddings2 : 0);
                    $sumWeddingsReprint = (isset($sumWeddingsReprint1) ? $sumWeddingsReprint2 : 0)  + (isset($sumWeddingsReprint2) ? $sumWeddingsReprint2 : 0);
                } ?>
                <?php if(!empty($events)) { ?>
                <td class="text-center conv_cash cash sum_total">
                    <?= $sumCash + $sumCashless ?>
                </td>
                <td class="text-center conv_cash sum_cash">
                    <?= isset($sumCash) ? $sumCash : 0 ?>
                </td>
                <td class="text-center conv_cash cash sum_cashless">
                    <?= isset($sumCashless) ? $sumCashless : 0 ?>
                </td>
                <td class="text-center amount_of_wed"><?= $sumWeddings ?></td>
                <td class="text-center amount_of_wed"><?= isset($sumWeddingsReprint) ? $sumWeddingsReprint : 0 ?></td>
                <td class="text-center conversion hide conversion_of_wedding">
                    <?= $wedPayView !== 0 ? number_format($sumWeddings / $wedPayView * 100, 2, '.', ' ') . '%' : '0.00%' ?>
                </td>
                <td class="text-center amount_of_kinoselfie"><?= $sumKinoselfie ?></td>
                <td class="text-center amount_of_kinoselfie"><?= $sumKinoselfieReprint ?></td>
                <td class="text-center conversion hide conversion_of_talisman">
                    <?= $talPayView !== 0 ? number_format($sumTalisman / $talPayView * 100, 2, '.', ' ') . '%' : 0 ?>
                </td>
                <td class="text-center amount_of_talisman">
                    <?= isset($sumTalisman) ? $sumTalisman : 0 ?>
                </td>
                <td class="text-center conversion hide conversion_of_talisman">
                    <?= $talPayView !== 0 ? number_format($sumTalisman / $talPayView * 100, 2, '.', ' ') . '%' : 0 ?>
                </td>
                <td class="text-center amount_of_instagram">
                    <?= isset($sumTalisman) ? $sumTalisman : 0 ?>
                </td>
                <td class="text-center conversion hide conversion_of_instagram">
                    <?= $talPayView !== 0 ? number_format($sumTalisman / $talPayView * 100, 2, '.', ' ') . '%' : 0 ?>
                </td>
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
