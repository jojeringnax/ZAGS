<?php
/* @var $this yii\web\View */
?>
<h1>config/index</h1>

<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
</p>
<pre>
<?php
print_r(array_keys(\app\models\Events::getEventsForTime(date('2018-03-01'), date('2018-05-01'))));

?>