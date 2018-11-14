<?php
/**
 * @var $id integer
 * @var $encashments \app\models\Events[]
 */

$this->title = 'Инкассации устройства №'.$id;
$this->params['breadcrumbs'][] = ['label' => 'Устройства', 'url' => ['index', 'r' => 'owner']];
$this->params['breadcrumbs'][] = ['label' => 'Инкассации устройства №'.$id];
foreach($encashments as $encashment) { ?>
    <div style="display: flex;align-items: center;justify-content: space-between;">
        <div class="penis_time"><?= $encashment->time ?></div>
        <div class="penis"><?= $encashment->data ?></div>
    </div>
<?php } ?>