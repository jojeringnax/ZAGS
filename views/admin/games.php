<?php
/**
 * @var $this \yii\web\View
 * @var $games \yii\data\ActiveDataProvider
 * @var $columns array
 */

$this->title = 'Статистика по играм';
$this->params['breadcrumbs'][] = ['label' => 'Статистика', 'url' => ['index', 'r' => 'owner']];
$this->params['breadcrumbs'][] = ['label' => 'Игры'];
?>
<div class="container">
    <div class="row">
        <div class="filter d-flex justify-content-start"  style="width:100%">
            <div class="btn-filter col-3 d-flex btn btn-primary">Click</div>
            <form id="game" class="filters hide col-9 d-flex form-control">
                <div class="search-input d-flex">
                    <label for="search-game">ID</label><input id="search-game" class="form-control" aria-label="Default" type="text" name="" value="" placeholder="Enter text">
                </div>
                <div class="calendar">
                    <input id="date_first" placeholder="enter date" type='text' class="item-datepicker form-control datepicker-here" data-position="right top" />
                    <input id="date_second" placeholder="enter date" type='text' class="item-datepicker form-control datepicker-here" data-position="right top" />
                </div>
                <div class="btn-go d-flex align-items-center">
                    <input id="go-game" class="btn btn-success" type="submit" name="" value="GO!!!">
                </div>
            </form>
        </div>
    </div>
</div>

<div class="grid_wrapper">
<?=

$this->render('/tech/gridview', [
        'dataProvider' => $games,
        'columns' => $columns,
]);

?>
</div>
