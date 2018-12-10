<?php
/* @var $this yii\web\View */
$events = \app\models\Events::getEventsForTime(101);

?>
<pre>
    <?= var_dump($events) ?>
</pre>
<script>
    new Tooltip(referenceElement, {
        placement: 'top', // or bottom, left, right, and variations
        title: "Top"
    });
</script>
