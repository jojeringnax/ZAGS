<?php
/**
 * @var $id integer
 * @var $events array
 */

$this->title = 'Метрики устройства №'.$id;
$this->params['breadcrumbs'][] = ['label' => 'Устройства', 'url' => ['index', 'r' => 'owner']];
$this->params['breadcrumbs'][] = ['label' => 'Метрики устройства №'.$id, 'url' => ['owner/view', 'id' => $id]];

?>
<h1>Метрики устройства №<?=$id?></h1>
<div class="month_before">
<?php foreach ($events as $data => $eventArray) {
    if(date('m') === preg_split('/-/', $data)[1]) {
        echo '</div><div class="current_month">';
    }
    ?>
    <div class="date"><?= $data ?></div>
        <?php foreach($eventArray as $event) { ?>
            <div class="event_name">
            </div>
        <?php }?>
<?php } ?>
</div>
