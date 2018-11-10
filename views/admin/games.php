<?php
/**
 * @var $games \app\models\Events[]
 */
use yii\grid\GridView;
use yii\widgets\Pjax;

?>

<div class="container">
    <div class="row">
        <div class="filter d-flex justify-content-start"  style="width:100%">
            <div class="btn-filter col-3 d-flex">
                <button type="button" name="button" class="btn btn-primary">Click</button>
            </div>
            <div class="filters hide col-9 d-flex">
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
            </div>
        </div>
    </div>
</div>

<?php Pjax::begin(); ?>

<div class="container">
<?php
echo GridView::widget([
    'dataProvider' => $games,
    'tableOptions' => [
        'class' => 'table table-striped table-bordered',
        'id' => 'games_table'
    ],
    'pager' => [
        'options' => [
            'class' => 'pagination'
        ],
        'linkOptions' => [
            'class' => 'page-link'
        ],
        'linkContainerOptions' => [
            'class' => 'page-item'
        ],
        'prevPageCssClass' => [
            'class' => 'prev'
        ],
        'prevPageLabel' => '<-',
        'nextPageLabel' => '->'
    ]
]);

?>
</div>

<?php Pjax::end(); ?>
