<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Метрики устройства №'.$id;
$this->params['breadcrumbs'][] = ['label' => 'Устройства', 'url' => ['index', 'r' => 'owner']];
$this->params['breadcrumbs'][] = ['label' => 'Метрики устройства №'.$id, 'url' => ['index', 'r' => 'owner/view', 'id' => $id]];
$this->params['breadcrumbs'][] = ['label' => 'Метрики Instagram устройства №'.$id];
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