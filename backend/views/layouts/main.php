<?php

use backend\assets\AdminAsset;
use backend\assets\AppAsset;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

AdminAsset::register($this);

// Asset directory
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@webroot/style');

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta name="description" content="">
    <meta name="author" content="">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="stylesheet" type="text/css"
          href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <?php $this->head() ?>
</head>
<body class=" desktop-detected menu-on-top pace-done">
<?php $this->beginBody() ?>
<?= $this->render('header.php', ['directoryAsset' => $directoryAsset]) ?>
<?= $this->render('left.php', ['directoryAsset' => $directoryAsset]) ?>
<?= $this->render('content.php', ['content' => $content]) ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
