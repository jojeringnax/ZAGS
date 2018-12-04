<?php
/* @var $this yii\web\View */

$uptimes = \app\models\Uptime::getForCurrentMonthForModule(1);
var_dump($uptimes);


?>

<script>
    new Tooltip(referenceElement, {
        placement: 'top', // or bottom, left, right, and variations
        title: "Top"
    });
</script>
