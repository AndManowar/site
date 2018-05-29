<?php

/**
 * @var array $params
 * @var User $user
 */

use common\models\User;

$user = $params['user'];

?>


<table width="90%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="center">
            <div style="height: 60px; line-height: 60px; font-size: 10px;"></div>
            <div style="line-height: 44px;">
                <span
                        style="font-size: 34px; font-family: Arial, Helvetica, sans-serif;color: #57697e; ">
					<span style="font-family: Arial, Helvetica, sans-serif; font-size: 34px; color: #57697e;">
						<?= $user->fullName ?>, дякуємо за реєстрацію!
					</span></span>
            </div>
            <div style="height: 40px; line-height: 40px; font-size: 10px;"></div>
        </td>
    </tr>
    <tr>
        <td align="center">
            <div style="line-height: 24px;">
                <span
                        style="font-size: 15px; font-family: Arial, Helvetica, sans-serif; color: #57697e; ">
					<span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">
						Тепер ви можете слідкувати за Вашими замовленнями в <a
                                href="<?= \yii\helpers\Url::toRoute(['profile']) ?>">особистому кабінеті</a>
					</span></span>
            </div>
            <div style="height: 40px; line-height: 40px; font-size: 10px;"></div>
        </td>
    </tr>
</table>