<?php

use yii\helpers\Html;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>"/>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->

    <style>
        /***
        User Profile Sidebar by @keenthemes
        A component of Metronic Theme - #1 Selling Bootstrap 3 Admin Theme in Themeforest: http://j.mp/metronictheme
        Licensed under MIT
        ***/

        body {
            padding: 0;
            margin: 0;
        }

        html {
            -webkit-text-size-adjust: none;
            -ms-text-size-adjust: none;
        }

        @media only screen and (max-device-width: 680px), only screen and (max-width: 680px) {
            *[class="table_width_100"] {
                width: 96% !important;
            }

            *[class="border-right_mob"] {
                border-right: 1px solid #dddddd;
            }

            *[class="mob_100"] {
                width: 100% !important;
            }

            *[class="mob_center"] {
                text-align: center !important;
            }

            *[class="mob_center_bl"] {
                float: none !important;
                display: block !important;
                margin: 0px auto;
            }

            .iage_footer a {
                text-decoration: none;
                color: #929ca8;
            }

            img.mob_display_none {
                width: 0px !important;
                height: 0px !important;
                display: none !important;
            }

            img.mob_width_50 {
                width: 40% !important;
                height: auto !important;
            }
        }

        .table_width_100 {
            width: 680px;
        }
    </style>

    <div id="mailsub" class="notification" align="center">

        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="min-width: 320px;">
            <tr>
                <td align="center" bgcolor="#eff3f8">
                    <table width="680" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td>

                                <table border="0" cellspacing="0" cellpadding="0" class="table_width_100" width="100%"
                                       style="max-width: 680px; min-width: 300px;">
                                    <tr>
                                        <td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" bgcolor="#ffffff">
                                            <!-- padding -->
                                            <table width="90%" border="0" cellspacing="0" cellpadding="0">
                                                <div style="height: 30px; line-height: 30px; font-size: 10px;"></div>
                                                <tr>
                                                    <td align="center">
                                                        <a href="#" target="_blank"
                                                           style="color: #596167; font-family: Arial, Helvetica, sans-serif; float:left; width:100%; padding:20px;text-align:center; font-size: 13px;">
                                                            <font face="Arial, Helvetica, sans-seri; font-size: 13px;"
                                                                  size="3"
                                                                  color="#596167">
                                                                КАРТИНКА С ЛОГО</a>
                                                    </td>
                                                    <td align="right">

                                                        <div style="height: 50px; line-height: 50px; font-size: 10px;"></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="center" bgcolor="#fbfcfd">
                                                        <?= $content ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="iage_footer" align="center" bgcolor="#ffffff">
                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                <td align="center"
                                                                    style="padding:20px;float:left;width:100%; text-align:center;">
                                                                    <font face="Arial, Helvetica, sans-serif" size="3"
                                                                          color="#96a5b5"
                                                                          style="font-size: 13px;">
				<span style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;">
					2018 © TestShop. ALL Rights Reserved.
				</span></font>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>

                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>