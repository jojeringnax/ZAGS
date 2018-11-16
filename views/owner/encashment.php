<?php
/**
 * @var $id integer
 * @var $encashments \app\models\Events[]
 */

$this->title = 'Инкассации устройства №'.$id;
$this->params['breadcrumbs'][] = ['label' => 'Устройства', 'url' => ['index', 'r' => 'owner']];
$this->params['breadcrumbs'][] = ['label' => 'Инкассации устройства №'.$id]; ?>
<script type="text/javascript">
    let ququ = [];
</script>
<?php
foreach($encashments as $encashment) { ?>
    <script type="text/javascript">
        // console.log("<?= $encashment->time ?>");
        ququ.push("<tr><td class='date-of-encashment'>"+
        "<?= $encashment->time ?>"+"</td><td class=value-of-encashment'>"+
        "<?= $encashment->data ?>"+"</td></tr>"
        );
    </script>
<?php } ?>
<!-- <form class="filter" action="" method="">
    <div class="input-group-text">
        <label for="date">Date</label><input id="date" type="checkbox" aria-label="Checkbox for following text input">
        <label for=""></label><input id="" type="checkbox" aria-label="Checkbox for following text input">
        <label for=""></label><input id="" type="checkbox" aria-label="Checkbox for following text input">
        <label for=""></label><input id="" type="checkbox" aria-label="Checkbox for following text input">
        <label for=""></label><input id="" type="checkbox" aria-label="Checkbox for following text input">
        <label for=""></label><input type="checkbox" aria-label="Checkbox for following text input">
        <label for=""></label><input id="" type="checkbox" aria-label="Checkbox for following text input">
    </div>
</form> -->
<form class="filter-data-encashment d-flex align-items-center" action="" method="">
    <div class="calendar">
        <label for="date_first_encashment" class="d-flex align-items-center">От<input id="date_first_encashment" placeholder="enter date" type='text' class="item-datepicker form-control datepicker-here" data-position="right top" /></label>
        <label for="date_second_encashment" class="d-flex align-items-center">До<input id="date_second_encashment" placeholder="enter date" type='text' class="item-datepicker form-control datepicker-here" data-position="right top" /></label>
    </div>
    <div class="btn-go d-flex align-items-center">
        <input id="go-game" class="btn btn-success" type="submit" name="" value="GO!!!">
    </div>
</form>
<table class="table table-striped">
    <thead>
      <tr>
        <th scope="col">Дата инкасации</th>
        <th scope="col">Сумма инкасации</th>
      </tr>
    </thead>
    <tbody id="data-container" ></tbody>
</table>
<div class="pagination"></div>
