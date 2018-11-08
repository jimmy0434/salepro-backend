<?php
/**
 * Created by PhpStorm.
 * User: JawdatSobh
 * Date: 08/11/2018
 * Time: 08:46
 *
 * @var $this View
 * @var $model Salesman
 * @var $form \cnd\form\ActiveForm
 */

use cnd\filemanager\widgets\MediaInput;
use common\models\Salesman;
use yii\web\View;

?>
    <div class="panel panel-default">
        <div class="panel-heading"><?= 'Profile Information' ?></div>
        <div class="panel-body">
            <?=
            MediaInput::widget([
                'model' => $model,
                'attr' => 'image',
                'title' => false,
                'count' => 1,
            ])
            ?>
            <?= $form->field($model, 'name')->textInput(['autocomplete' => 'off']) ?>
            <?= $form->field($model, 'mac_address')->textInput(['autocomplete' => 'off']) ?>
        </div>
    </div>
<?php
