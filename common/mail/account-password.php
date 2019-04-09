<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 4/9/2019
 * Time: 12:08 PM
 *
 * @var $user User
 */

use common\models\User;

echo Yii::$app->core->emailTemplate('clientNewPassword', [
    'name' => $user->name,
    'email' => $user->email,
    'username' => $user->username,
    'password' => $user->password,
    'type' => $user->type_label,
    'status' => $user->status_label
]);
