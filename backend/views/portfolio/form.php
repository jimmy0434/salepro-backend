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
use cnd\admin\models\activerecords\Setting;
use cnd\filemanager\widgets\MediaInput;
use cnd\form\ActiveForm;
use common\models\Portfolio;
use yii\helpers\Html;
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
                    <?=
                    MediaInput::widget([
                        'model' => $model,
                        'attr' => 'image',
                        'title' => 'Image',
                        'count' => 1,
                    ])
                    ?>
                    <?= $form->field($model, 'name')->textInput() ?>
                    <?= $form->field($model, 'linkedin')->textInput() ?>
                    <?= $form->field($model, 'position')->textInput(['type' => 'number', 'min' => 0]) ?>
                    <?= $form->field($model, 'description')->textarea(['style' => ['min-height' => '250px', 'resize' => 'none']]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading"><?= 'Files' ?></div>
                <div class="panel-body">
                    <?= FileSelector::widget([
                        'model' => $model,
                        'property' => 'brochure_id',
                        'title' => 'Brochure',
                        'fileName' => uniqid('portfolio-brochure-', true),
                        'ext' => Setting::get('portfolio.brochure.extensions', 'pdf'),
                    ]) ?>

                    <?= FileSelector::widget([
                        'model' => $model,
                        'property' => 'presentation_id',
                        'title' => 'Presentation',
                        'fileName' => uniqid('portfolio-presentation-', true),
                        'ext' => Setting::get('portfolio.presentation.extensions', 'pptx,ppt'),
                    ]) ?>

                    <?= FileSelector::widget([
                        'model' => $model,
                        'property' => 'video_id',
                        'title' => 'Video',
                        'fileName' => uniqid('portfolio-video-', true),
                        'ext' => Setting::get('portfolio.video.extensions', 'mp4'),
                    ]) ?>

                    <?= FileSelector::widget([
                        'model' => $model,
                        'property' => 'info_graphic_id',
                        'title' => 'InfoGraphics',
                        'fileName' => uniqid('portfolio-infoGraphics-', true),
                        'ext' => Setting::get('portfolio.infoGraphics.extensions', 'png,jpg,pdf,ppt,pptx'),
                    ]) ?>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading"><?= 'Relations' ?></div>
                <div class="panel-body">
                    <?php
                    if (in_array($context->target, [Portfolio::TARGET_CORPORATE, Portfolio::TARGET_MOTHER_CORPORATE, Portfolio::TARGET_BRAND, Portfolio::TARGET_SECTOR, Portfolio::TARGET_PRODUCT, Portfolio::TARGET_BUNDLING_AND_PACKING])) {
                        echo AutoCompleteInput::widget([
                            'model' => $model,
                            'form' => $form,
                            'property' => 'businessUnitIds',
                            'findUrl' => ['/portfolio/find-business-unit'],
                            'addUrl' => ['/portfolio/add-business-unit'],
                            'title' => 'Manufacturing Plants',
                            'data' => $model->item ? $model->item->businessUnits : [],
                        ]);
                    }
                    if (in_array($context->target, [Portfolio::TARGET_BRAND, Portfolio::TARGET_PRODUCT, Portfolio::TARGET_BUNDLING_AND_PACKING, Portfolio::TARGET_CORPORATE, Portfolio::TARGET_MOTHER_CORPORATE])) {
                        echo AutoCompleteInput::widget([
                            'model' => $model,
                            'form' => $form,
                            'property' => 'sectorsIds',
                            'findUrl' => ['/portfolio/find-sectors'],
                            'addUrl' => ['/portfolio/add-sector'],
                            'title' => 'Sectors',
                            'data' => $model->item ? $model->item->sectors : [],
                        ]);
                    }
                    if (in_array($context->target, [Portfolio::TARGET_SECTOR, Portfolio::TARGET_PRODUCT, Portfolio::TARGET_BUNDLING_AND_PACKING])) {
                        echo AutoCompleteInput::widget([
                            'model' => $model,
                            'form' => $form,
                            'property' => 'brandsIds',
                            'findUrl' => ['/portfolio/find-brands'],
                            'addUrl' => ['/portfolio/add-brand'],
                            'title' => 'Brands',
                            'data' => $model->item ? $model->item->brands : [],
                        ]);
                    }
                    if (in_array($context->target, [Portfolio::TARGET_SECTOR, Portfolio::TARGET_BRAND])) {
                        echo AutoCompleteInput::widget([
                            'model' => $model,
                            'form' => $form,
                            'property' => 'productsIds',
                            'findUrl' => ['/portfolio/find-products'],
                            'addUrl' => ['/portfolio/add-product'],
                            'title' => 'Products',
                            'data' => $model->item ? $model->item->products : [],
                        ]);
                    }
                    if (in_array($context->target, [Portfolio::TARGET_BUSINESS_UNIT, Portfolio::TARGET_PRODUCT, Portfolio::TARGET_BUNDLING_AND_PACKING])) {
                        echo AutoCompleteInput::widget([
                            'model' => $model,
                            'form' => $form,
                            'property' => 'certificationsIds',
                            'findUrl' => ['/certification/find-certifications'],
                            'addUrl' => ['/certification/add-certification'],
                            'title' => 'Certifications',
                            'data' => $model->item ? $model->item->certifications : [],
                        ]);
                    }
                    echo AutoCompleteInput::widget([
                        'model' => $model,
                        'form' => $form,
                        'property' => 'officesIds',
                        'findUrl' => ['/sales-office/find-offices'],
                        'addUrl' => ['/sales-office/add-office'],
                        'title' => 'Sales Offices',
                        'data' => $model->salesOffices,
                    ]);
                    echo AutoCompleteInput::widget([
                        'model' => $model,
                        'form' => $form,
                        'property' => 'tags',
                        'findUrl' => ['/search/find-tags'],
                        'addUrl' => ['/search/add-tag'],
                        'title' => 'Tags',
                        'data' => $model->search ? $model->search->tags : [],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading"><?= 'News' ?></div>
                <div class="panel-body">
                    <?= $form->field($model, 'newsLinks')->jsonInput([
                        'Url' => 'text',
                    ])->label(false) ?>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading"><?= 'Websites' ?></div>
                <div class="panel-body">
                    <?= $form->field($model, 'links')->jsonInput([
                        'Name' => 'text',
                        'Url' => 'text',
                    ])->label(false) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group text-center">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary btn-lg']) ?>
    </div>
<?php
ActiveForm::end();

