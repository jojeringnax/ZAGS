<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/open-iconic/1.1.1/font/css/open-iconic-bootstrap.min.css" integrity="sha256-BJ/G+e+y7bQdrYkS2RBTyNfBHpA9IuGaPmf9htub5MQ=" crossorigin="anonymous" /> -->
<?php
/* @var $this yii\web\View */

/**
 * @var $data array = array(
[$id] => [
 *          ['license'] => *****
 *          ['online'] => *****
 *          ['description'] => ****
 *          ['fill_wedding'] => ****
 *          ['stacker'] => ****
 *      ]
 *      ...
 * )
 *
 * For $loop use foreach($data as $id => $value) {
$value['license']
 *      ...
 * }
 */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;


$this->title = 'Устройства';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs("
   $(document).ready(function() {
       $('.uptime').each(function(){
           //console.log($(this).attr('id'));
           let data = $(this).attr('data-'+$('.uptime-select').val());
           $(this).html(data);
       });
        $('.uptime-select').change(function(){
           let date = $(this).val();
            $('.uptime[data-id='+$(this).data('id')+']').each(function(){
               let data = $(this).attr('data-'+date);
               $(this).html(data);
           });
        });
        window.scrollTo(0,".(isset($_GET['scrollTop'])? $_GET['scrollTop']:0).");
    });");

$nameArray = [
    'validator' => 'Купюроприемник',
    'cashless' => 'POS-терминал',
    'printer' => 'Принтер',
    'camera' => 'Камера',
    'dispenser' => 'Диспенсер'
];
?>

<div class="row-devices">
    <div class="container">
        <div id="wrap_cards" class="row d-flex flex-wrap">
            <?php foreach($data as $id => $value) {?>
                <div class='card elem-card d-flex'>
                    <div class="bg-primary card-header d-flex justify-content-center flex-grow-1">
                        <div class="elem-td">
                            <span><?= $value['description'] ?></span>
                        </div>
                    </div>
                    <div class="content-cards d-flex">
                        <div class="elem-card-inf" style="width: 85%">
                            <div class="d-flex">
                                <div class="elem-th">
                                    <span>Выручка за текущий месяц</span>
                                </div>
                                <div class="elem-td">
                                    <span><?= $value['profit']?></span>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="elem-th">
                                    <span>Денег в кассете</span>
                                </div>
                                <div class="elem-td">
                                    <span><?= $value['stacker']?></span>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="elem-th">
                                    <span style="font-weight: bold">Статус аппарата</span>
                                </div>
                                <div id="state-on-off" class="elem-td">
                                    <span><?= $value['online']?></span>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="elem-th">
                                    <span>Период</span>
                                </div>
                                <div class="elem-td">
                                    <select data-id="<?= $id ?>" class="uptime-select" name="" id="">
                                        <option value="yesterday">Вчера</option>
                                        <option value="today">Сегодня</option>
                                        <option value="month">Месяц</option>
                                    </select>
                                </div>
                            </div>
                            <?php foreach (\app\models\Module::NAMES as $name) { ?>
                                <div class="d-flex">
                                    <div class="elem-th">
                                        <?= $nameArray[$name] ?>
                                    </div>
                                    <div class='elem-td'>
                                        <div class="state-td">
                                            <span><?= $value[$name.'_status'] ?></span>
                                        </div>
                                        <div id="<?= $name ?>" data-id="<?= $id ?>" data-month="<?= $value[$name.'_uptime_month'] ?>" data-today = "<?= $value[$name.'_uptime_today'] ?>" data-yesterday = "<?= $value[$name.'_uptime_yesterday'] ?>" class="uptime state-pr"></div>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="d-flex">
                                <div class="elem-th">
                                    <span>Количество расходников</span>
                                </div>
                                <div class="elem-td">
                                    <span><?= $value['printer_media_count'] ?></span>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="elem-th">
                                    <span>ID устройства</span>
                                </div>
                                <div class="elem-td">
                                    <span><?= $id ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="elem-card-inf buttons d-flex flex-column justify-content-around align-items-center" style="width:15%">
                            <?php
                            $url_statistics = Url::to(['owner/view', 'id' => $id]);
                            $url_cog = Url::to(['owner/update', 'id' => $id]);
                            $url_encashment = Url::to(['owner/encashment', 'id' => $id]);
                            ?>
                            <div class="btn-set btn-settings">
                                <a href="<?= $url_cog ?>"><span class="oi oi-cog"></span></a>
                            </div>
                            <div class="btn-set btn-statistics">
                                <a href="<?= $url_statistics ?>"> <span class="oi oi-document"></span></a>
                            </div>
                            <div class="btn-set btn-encashment">
                                <a href="<?= $url_encashment ?>"><span class="oi oi-briefcase"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
