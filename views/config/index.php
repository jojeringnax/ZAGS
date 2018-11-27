<?php
/* @var $this yii\web\View */

$config = \app\models\Config::findOne(82);
if ($config === null) {
    return 'Устройсто не найдено в БД';
}

?>

<script>
    new Tooltip(referenceElement, {
        placement: 'top', // or bottom, left, right, and variations
        title: "Top"
    });
</script>
