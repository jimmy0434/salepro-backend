<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 12/24/2018
 * Time: 9:41 AM
 */

/* @var $this \yii\web\View */

/* @var $content string */

use cnd\core\CoreAsset;
use cnd\admin\AdminAsset;
use cnd\admin\BowerAsset;
use cnd\admin\NpmAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

CoreAsset::register($this);
AdminAsset::register($this);
BowerAsset::register($this);
NpmAsset::register($this);

$adminModule = Yii::$app->getModule('admin');

$key = md5(Yii::getAlias('@webroot'));

$bodyClasses = 'skin-purple-dark sidebar-mini';
if (isset($_COOKIE[$key . '-body'])) {
    $bodyClasses = $_COOKIE[$key . '-body'];
}

$script = <<< JS
$('.page-loader').show();
$(document).ready(function(){
    $('.page-loader').fadeOut(500);
});
$(window).bind('beforeunload',function(){
    $('.page-loader').fadeIn(500);
});
JS;
$this->registerJs($script);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" dir="ltr">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="hold-transition <?= $bodyClasses ?>">
<div class="page-loader">
    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
    <div style="margin-top:20px;"><?= Yii::$app->name ?> Loading...</div>
</div>
<?php $this->beginBody() ?>
<section class="content-header">
    <h1>
        <?php
        if ($this->title !== null) {
            echo \yii\helpers\Html::encode($this->title);
        } else {
            echo \yii\helpers\Inflector::camel2words(
                \yii\helpers\Inflector::id2camel($this->context->module->id)
            );
            echo ($this->context->module->id !== \Yii::$app->id) ? '<small>Module</small>' : '';
        } ?>
    </h1>
    <?=
    Breadcrumbs::widget(
        [
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]
    ) ?>
</section>
<section class="content">
    <?= Alert::widget() ?>
    <?= $content ?>
</section>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
