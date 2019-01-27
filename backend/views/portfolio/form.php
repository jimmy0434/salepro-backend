<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 1/25/2019
 * Time: 8:36 AM
 *
 * @var $this View
 * @var $model Portfolio
 * @var $isNew boolean
 * @var $context PortfolioController
 */

use backend\controllers\PortfolioController;
use backend\widgets\AutoCompleteInput;
use backend\widgets\FileSelector;
use backend\widgets\SearchTagInput;
use cnd\filemanager\widgets\MediaInput;
use cnd\form\ActiveForm;
use common\models\Portfolio;
use yii\helpers\Html;
use yii\web\JqueryAsset;
use yii\web\View;

$context = $this->context;

$this->title = ($isNew ? "Add New" : "Edit") . " " . $context->targets[$context->target] . " Portfolio";

$form = ActiveForm::begin(['id' => Yii::$app->controller->id . '-form']);
?>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading"><?= 'Information' ?></div>
                <div class="panel-body">
                    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
                    <?= $form->field($model, 'target')->hiddenInput()->label(false) ?>
                    <?= $form->field($model, 'name')->textInput() ?>
                    <?= $form->field($model, 'description')->editorInput() ?>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading"><?= 'Files' ?></div>
                <div class="panel-body">
                    <?=
                    MediaInput::widget([
                        'model' => $model,
                        'attr' => 'image',
                        'title' => 'Image',
                        'count' => 1,
                    ])
                    ?>
                    <?= FileSelector::widget([
                        'model' => $model,
                        'property' => 'brochure_id',
                        'title' => 'Brochure',
                        'fileName' => uniqid('portfolio-brochure-', true),
                        'ext' => 'pdf',
                    ]) ?>

                    <?= FileSelector::widget([
                        'model' => $model,
                        'property' => 'presentation_id',
                        'title' => 'Presentation',
                        'fileName' => uniqid('portfolio-presentation-', true),
                        'ext' => 'pptx',
                    ]) ?>

                    <?= FileSelector::widget([
                        'model' => $model,
                        'property' => 'video_id',
                        'title' => 'Video',
                        'fileName' => uniqid('portfolio-video-', true),
                        'ext' => 'mp4',
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading"><?= 'Relations' ?></div>
                <div class="panel-body">
                    <?php
                    if (in_array($context->target, [Portfolio::TARGET_BRAND, Portfolio::TARGET_PRODUCT])) {
                        $sectorsWidget = AutoCompleteInput::widget([
                            'model' => $model,
                            'form' => $form,
                            'property' => 'sectorsIds',
                            'findUrl' => ['/portfolio/find-sectors'],
                            'addUrl' => ['/portfolio/add-sector'],
                            'title' => 'Sectors',
                            'data' => $model->item->sectors,
                        ]);
                    }
                    if (in_array($context->target, [Portfolio::TARGET_SECTOR, Portfolio::TARGET_PRODUCT])) {
                        $brandsWidget = AutoCompleteInput::widget([
                            'model' => $model,
                            'form' => $form,
                            'property' => 'brandsIds',
                            'findUrl' => ['/portfolio/find-brands'],
                            'addUrl' => ['/portfolio/add-brand'],
                            'title' => 'Brands',
                            'data' => $model->item->brands,
                        ]);
                    }
                    if (in_array($context->target, [Portfolio::TARGET_SECTOR, Portfolio::TARGET_BRAND])) {
                        $productsWidget = AutoCompleteInput::widget([
                            'model' => $model,
                            'form' => $form,
                            'property' => 'productsIds',
                            'findUrl' => ['/portfolio/find-products'],
                            'addUrl' => ['/portfolio/add-product'],
                            'title' => 'Products',
                            'data' => $model->item->products,
                        ]);
                    }
                    if ($context->target == Portfolio::TARGET_SECTOR) {
                        echo $brandsWidget;
                        echo $productsWidget;
                    } else if ($context->target == Portfolio::TARGET_BRAND) {
                        echo $sectorsWidget;
                        echo $productsWidget;
                    } else if ($context->target == Portfolio::TARGET_PRODUCT) {
                        echo $sectorsWidget;
                        echo $brandsWidget;
                    }
                    echo AutoCompleteInput::widget([
                        'model' => $model,
                        'form' => $form,
                        'property' => 'tags',
                        'findUrl' => ['/search/find-tags'],
                        'addUrl' => ['/search/add-tag'],
                        'title' => 'Tags',
                        'data' => $model->search->tags,
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group text-center">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary btn-lg']) ?>
    </div>
<?php
ActiveForm::end();

