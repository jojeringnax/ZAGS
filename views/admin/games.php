<?php
/**
 * @var $games \app\models\Events[]
 */
 ?>
 <table class="table table-striped">
   <thead>
     <tr class="row">
       <!-- <th class="col-4" scope="col">device_id</th>
       <th class="col-2" scope="col">time</th>
       <th class="col-2" scope="col">name</th>
       <th class="col-2" scope="col">data</th>
       <th class="col-2" scope="col">nonce</th> -->
       <?php if ($games !== null) {
           $i = 0;
           foreach ($games[0]->attributeLabels() as $key => $value) { ?>
               <th class="col-<?= $i === 0 ? "4" : "2" ?>" scope="col"><?= $value ?></th>

          <?php
           $i++;
           }
       } ?>
     </tr>
   </thead>
   <tbody>
   <?php
   foreach ($games as $game) {
    ?>
    <tr class="row">
      <th class="col-4" scope="row"><?= $game->device_id ?></th>
      <td class="col-2"><?= $game->time ?></td>
      <td class="col-2"><?= $game->name ?></td>
      <td class="col-2"><?= $game->data ?></td>
      <td class="col-2"><?= $game->nonce ?></td>
    </tr>
<?php } ?>
    </tbody>
  </table>
