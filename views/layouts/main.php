<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use app\models\custom\CustomNavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="stylesheet" href="../web/js/air-datepicker/dist/css/datepicker.css">
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    CustomNavBar::begin([
        'brandLabel' => 'ZAGS',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-lg navbar-dark fixed-top bg-dark',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'nav nav-tabs bg-dark justify-content-end d-flex', 'style' => 'width:100%'],
        'items' => [
            ['label' => 'Главная', 'url' => ['/site/index'],

            'linkOptions' => ['data-method' => 'post', 'class' => 'nav-link']
            ],
            Yii::$app->user->isGuest ?
                ['label' => 'Войти', 'url' => ['/site/login'],'linkOptions' => ['data-method' => 'post', 'class' => 'nav-link']] :
                [
                    'label' => 'Выйти (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post', 'class' => 'nav-link'],
                    'options' => ['class'=>'item-nav-li nav-item']
                ],
        ],
    ]);
    CustomNavBar::end();
    ?>

    <div class="container">
      <nav aria-label="breadcrumb">
        <?= Breadcrumbs::widget([
            'itemTemplate' => '<li class="breadcrumb-item">{link}</li>',
            'activeItemTemplate' => '<li class="breadcrumb-item active">{link}</li>',
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
      </nav>
        <div class="content_wrapper">
            <?= $content ?>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; ZAGS <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
