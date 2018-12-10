<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Метрики устройства №'.$id;
$this->params['breadcrumbs'][] = ['label' => 'Устройства', 'url' => ['index', 'r' => 'owner']];
$this->params['breadcrumbs'][] = ['label' => 'Метрики устройства №'.$id, 'url' => ['view', 'r' => 'owner', 'id' => $id]];
$this->params['breadcrumbs'][] = ['label' => 'Метрики Instagram устройства №'.$id];
$this->registerJs("
   $('.breadcrumb-item a').click(function(e){
    e.preventDefault();
    let num =".(isset($_GET['scrollTop'])? $_GET['scrollTop']:0).", num_inst =".(isset($_GET['scrollTopInst'])? $_GET['scrollTopInst']:0).";
        if ($(this).text() == 'Метрики устройства №".$id."'){
            document.location.href = $(this).attr('href')+ '&scrollTop=' +num + '&scrollTopInst='+num_inst  ;
        } else if ($(this).text() == 'Устройства'){
            document.location.href = $(this).attr('href')+ '&scrollTop=' +num;
        } else {
            document.location.href = $(this).attr('href');
        }
    })
");

?>
<div class="container">
    <div class="row">
        <table class="table table-striped">
            <thead>
            <tr>
                <th  class="text-center" scope="col">Дата</th>
                <th  class="text-center" scope="col">Итого</th>
                <th  class="text-center" scope="col">Instagram</th>
                <th  class="text-center" scope="col">VK</th>
                <th  class="text-center" colspan="2" scope="col">Блютуз</th>
                <th  class="text-center" colspan="2" scope="col">Wi-fi</th>
                <th  class="text-center" scope="col">Почта</th>
            </tr>
            </thead>
            <tbody>
            <?php for($i=0; $i <=3; $i++) {?>
                <tr>
                    <td class="text-center" >0</td>
                    <td class="text-center" >0</td>
                    <td class="text-center" >0</td>
                    <td class="text-center" >0</td>
                    <td class="text-center" >0</td>
                    <td class="text-center" >0</td>
                    <td class="text-center" >0</td>
                    <td class="text-center" >0</td>
                    <td class="text-center" >0</td>
                </tr>
            <?php }?>
            </tbody>
        </table>
    </div>
</div>