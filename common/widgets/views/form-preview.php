<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 12/3/2018
 * Time: 11:32 AM
 *
 * @var $this View
 * @var $context FormPreview
 * @var $form Form
 */

use common\widgets\FormPreview;
use yii\web\View;
use common\models\Form;

$context = $this->context;

$structure = $form->structure;

?>
<div class="panel-heading">
    <h2>Form Preview</h2>
</div>
<div class="panel panel-default">
    <div class="panel-body">
        <?php $context->renderForm($structure); ?>
    </div>
</div>
