<?php
/** @var string $content */

use backend\widgets\Alert;
use yii\widgets\Breadcrumbs;

?>

<div class="page__content">
    <main class="content">
        <?= $content ?>
    </main>
    <?= $this->render('footer.php') ?>
</div>
