<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/open-iconic/1.1.1/font/css/open-iconic-bootstrap.min.css" integrity="sha256-BJ/G+e+y7bQdrYkS2RBTyNfBHpA9IuGaPmf9htub5MQ=" crossorigin="anonymous" /> -->
<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Устройства';
$this->params['breadcrumbs'][] = $this->title;

?>
<h1>Устройства</h1>
<div class="row-devices">
    <div class="container">
        <div class="row d-flex justify-content-between">
            <div class="card elem-card" style="padding: 0">
                <div class="d-flex">
                    <div class="elem-card-inf th th-card-inf">
                        <div class="elem-th">
                            <span>Номер устройства</span>
                        </div>
                        <div class="elem-th">
                            <span>Выручка за текущий месяц</span>
                        </div>
                        <div class="elem-th">
                            <span>Денег в кассете</span>
                        </div>
                        <div class="elem-th">
                            <span>Статус аппарата</span>
                        </div>
                        <div class="elem-th">
                            <span>Купюроприемник</span>
                        </div>
                        <div class="elem-th">
                            <span>Принтер</span>
                        </div>
                        <div class="elem-th">
                            <span>Диспенсер</span>
                        </div>
                        <div class="elem-th">
                            <span>Камера</span>
                        </div>
                        <div class="elem-th">
                            <span>POS-терминал</span>
                        </div>
                        <div class="elem-th">
                            <span>Количество расходников</span>
                        </div>
                        <div class="elem-th">
                            <span>Описание устройства</span>
                        </div>
                    </div>

                    <div class="elem-card-inf td-card-inf">
                        <div class="elem-td">
                            <span>108</span>
                        </div>
                        <div class="elem-td">
                            <span>20 000</span>
                        </div>
                        <div class="elem-td">
                            <span>10500</span>
                        </div>
                        <div class="elem-td">
                            <div class="state-td">
                                <span>online</span>
                            </div>
                            <div class="state-td">
                                <span>uptime</span>
                            </div>
                        </div>
                        <div class="elem-td">
                            <div class="state-td">
                                <span>ok</span>
                            </div>
                            <div class="state-pr">
                                <span>100%</span>
                            </div>
                        </div>
                        <div class="elem-td">
                            <div class="state-td">
                                <span>ok</span>
                            </div>
                            <div class="state-pr">
                                <span>95%</span>
                            </div>
                        </div>
                        <div class="elem-td">
                            <div class="state-td">
                                <span>ok</span>
                            </div>
                            <div class="state-pr">
                                <span>80%</span>
                            </div>
                        </div>
                        <div class="elem-td">
                            <div class="state-td">
                                <span>ok</span>
                            </div>
                            <div class="state-pr">
                                <span>80%</span>
                            </div>
                        </div>
                        <div class="elem-td">
                            <div class="state-td">
                                <span>ok</span>
                            </div>
                            <div class="state-pr">
                                <span>70%</span>
                            </div>
                        </div>
                        <div class="elem-td">
                            <div class="state-td">
                                <span>ok</span>
                            </div>
                            <div class="state-pr">
                                <span>60%</span>
                            </div>
                        </div>
                        <div class="elem-td">
                            <span>Авиапарк</span>
                        </div>
                    </div>
                    <div class="elem-card-inf buttons d-flex flex-column justify-content-around align-items-center">
                        <div class="btn-set btn-settings">
                            <a href=""><img class="img-icon" src="img/icons/svg/cog.svg" alt=""></a>
                        </div>
                        <div class="btn-set btn-statistics">
                            <a href=""><img class="img-icon" src="img/icons/svg/document.svg" alt=""></a>
                        </div>
                        <div class="btn-set btn-encashment">
                            <a href=""><img class="img-icon" src="img/icons/svg/briefcase.svg" alt=""></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>