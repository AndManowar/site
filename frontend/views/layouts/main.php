<?php
/* @var $this \yii\web\View */

use yii\helpers\Html;

/* @var $content string */

\frontend\assets\AppAsset::register($this);
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@webroot/style');
?>

<?php $this->beginPage() ?>
    <html class="html" lang="ru">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta property="og:type" content="website">
        <meta property="og:url" content="">
        <meta property="og:title" content="">
        <meta property="og:image" content="/img/logo.png">
        <meta property="og:description" content="">
        <meta property="og:site_name" content="Тея мебель">
        <meta property="og:locale" content="ru_RU">
        <title>Teya</title>
        <link href="//fonts.googleapis.com/css?family=Montserrat:400,500,600,700,800&amp;amp;subset=cyrillic" rel="stylesheet">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <link rel="stylesheet" type="text/css"
              href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <?php $this->head() ?>
    </head>
    <body class="body js-body">
    <script>
        document.querySelector('.js-body').classList.add('js-init')
    </script>
    <div class="page">
        <?php $this->beginBody() ?>
        <?= $this->render('header.php', ['directoryAsset' => $directoryAsset]) ?>
        <?= $this->render('sidebar.php', ['directoryAsset' => $directoryAsset]) ?>
        <?= $this->render('content.php', ['content' => $content]) ?>
        <?php $this->endBody() ?>
    </div>
    </body>
    </html>
<?php $this->endPage() ?>