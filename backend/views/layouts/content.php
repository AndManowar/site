<?php
/** @var string $content */

use backend\widgets\Alert;
use yii\widgets\Breadcrumbs;

?>

<div id="main" role="main">
    <!-- MAIN CONTENT -->
    <br>
    <div class="col-md-12 text-center">
        <?= Alert::widget() ?>
    </div>

    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <?php
            echo Breadcrumbs::widget([
                'itemTemplate' => "<li><i>{link}</i></li>\n",
                'links'        => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]);
            ?>
        </h1>
    </div>

    <div id="content">
        <?= $content ?>
    </div>
</div>
