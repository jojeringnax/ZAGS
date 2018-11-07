<?php
/**
 * @var $games \app\models\Events[]
 */
foreach ($games as $game) {
    ?>
    <div class="poh">
        <?= $game->device_id ?>
        <?= $game->time ?>
    </div>
<?php } ?>
