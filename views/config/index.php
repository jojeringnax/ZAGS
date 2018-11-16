<?php
/* @var $this yii\web\View */
use \app\models\events\Encashment;
use \app\models\events\Payment;
?>
<h1>config/index</h1>

<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
</p>
<pre>
<?php

$timeFrom = new \DateTime();
$timeFrom->setDate(date('Y'), date('m') - 1, 1);
$timeTo = new \DateTime();
$timeTo->modify('+1 day');
$resultArray[$timeFrom->format('Y-m-d')] = 0;
$interval = $timeTo->diff($timeFrom);
print_r( $interval->days);
?>