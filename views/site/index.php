<?php

use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'Личный кабинет';
?>
<div class="site-index">

    <div class="jumbotron">
        <?php
        if(Yii::$app->user->id == 1) {
            echo "<p><a class=\"btn btn-lg btn-success\" href = \"index.php?r=admin\" > УСТРОЙСТВА И ЛИЦЕНЗИИ </a></p>";
            echo "<p><a class=\"btn btn-lg btn-success\" href = \"index.php?r=admin/requests\" > ЗАПРОСЫ АКТИВАЦИИ </a></p>";
            echo "<p><a class=\"btn btn-lg btn-success\" href = \"index.php?r=admin/users_list\" > ПОЛЬЗОВАТЕЛИ </a></p>";
        } else if(Yii::$app->user->id != null){
            echo "<p><a class=\"btn btn-lg btn-success\" href = \"index.php?r=owner\" > МОИ УСТРОЙСТВА </a></p>";
        }
        ?>
    </div>

    <div class="body-content">

    </div>
</div>
