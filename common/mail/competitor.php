<?php

use yii\helpers\Html;
use common\mail\mime;

/* @var $this yii\web\View */
/* @var $competitor common\models\Competitor */

$na = "N/A";
$mime = new Mime();

?>
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Basic Information
                </div>
                <table class="table" style="table-layout:fixed;">
                    <tbody>
                    <?php
                    if ($competitor->logo || $competitor->file) {
                        ?>
                        <tr>
                            <td>
                                <?php
                                if ($competitor->logo) {
                                    $logoExt = strtolower($competitor->logo_ext);
                                    echo Html::img('data:/' . $mime->TypeExt($logoExt) . ';base64,' . $competitor->logo, ['class' => 'img-responsive', 'style' => 'max-width:100%;']);
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if ($competitor->file) {
                                    $fileExt = strtolower($competitor->file_ext);
                                    echo Html::a('Click To Download File', 'data:'.$mime->TypeExt($fileExt).';base64,'.$competitor->file, ['target' => '_blank', 'class' => 'text-navy']);
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    <tr>
                        <th>Name</th>
                        <td><?= $competitor->name ?></td>
                    </tr>
                    <tr>
                        <th>Business Unit</th>
                        <td>
                            <?php
                            if ($competitor->businessUnit && $competitor->businessUnit->portfolio) {
                                echo $competitor->businessUnit->portfolio->name;
                            } else {
                                echo $na;
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Salesman</th>
                        <td>
                            <?php
                            if ($competitor->salesman) {
                                echo $competitor->salesman->name;
                            } else {
                                echo $na;
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Company Profile</th>
                        <td><?= $competitor->company_profile ?? $na ?></td>
                    </tr>
                    <tr>
                        <th>Headquarter Location</th>
                        <td><?= $competitor->headquarter_location ?? $na ?></td>
                    </tr>
                    <tr>
                        <th>Manufacturing Locations</th>
                        <td><?= $model->manufacturing_locations ?? $na ?></td>
                    </tr>
                    <tr>
                        <th>Sales Offices Locations</th>
                        <td><?= $model->sales_offices_locations ?? $na ?></td>
                    </tr>
                    <tr>
                        <th>Website</th>
                        <td><?= $competitor->website ?? $na ?></td>
                    </tr>
                    <tr>
                        <th>Market Presence</th>
                        <td><?= $competitor->market_presence ?? $na ?></td>
                    </tr>
                    <tr>
                        <th>Established Year</th>
                        <td><?= $competitor->established_year ?? $na ?></td>
                    </tr>
                    <tr>
                        <th>Annual Sales Revenue</th>
                        <td><?= $competitor->annual_sales_revenue ?? $na ?></td>
                    </tr>
                    <tr>
                        <th>Employees Number</th>
                        <td><?= $competitor->employees_number ?? $na ?></td>
                    </tr>
                    <tr>
                        <th>Certification</th>
                        <td><?= $competitor->certification ?? $na ?></td>
                    </tr>
                    <tr>
                        <th>Other Certifications</th>
                        <td><?= $competitor->certification_others ?? $na ?></td>
                    </tr>
                    <tr>
                        <th>Merger</th>
                        <td><?= $model->merger_company_name ?? $na ?>, <?= $model->merger_country ?? '' ?></td>
                    </tr>
                    <tr>
                        <th>Acquisition</th>
                        <td><?= $model->acquisition_company_name ?? $na ?>, <?= $model->acquisition_country ?? '' ?></td>
                    </tr>
                    <tr>
                        <th>Marketing Strategy</th>
                        <td><?= $competitor->marketing_strategy ?? $na ?></td>
                    </tr>
                    <tr>
                        <th>Company Communication</th>
                        <td><?= $competitor->company_communication ?? $na ?></td>
                    </tr>
                    <tr>
                        <th>Quality</th>
                        <td><?= $competitor->quality ?? $na ?></td>
                    </tr>
                    <tr>
                        <th>Brand Equity</th>
                        <td><?= $competitor->brand_equity ?? $na ?></td>
                    </tr>
                    <tr>
                        <th>Problem Solving Response</th>
                        <td><?= $competitor->problem_solving_response ?? $na ?></td>
                    </tr>
                    <tr>
                        <th>Market Dominance</th>
                        <td><?= $competitor->market_dominance ?? $na ?></td>
                    </tr>
                    <tr>
                        <th>Comments</th>
                        <td><?= $competitor->comments ?? $na ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <?php
                    if (!empty($competitor->competitorManager) && is_array($competitor->competitorManager)) {
                        ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Managers
                            </div>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Linkedin</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($competitor->competitorManager as $m) {
                                    ?>
                                    <tr>
                                        <td><?= $m->first_name . ' ' . $m->last_name ?></td>
                                        <td><?= $m->position ?? $na ?></td>
                                        <td><?= $m->linkedin ? Html::a('<i class="fa fa-linkedin"></i>', $m->linkedin, ['target' => 'blank', 'class' => 'text-navy']) : $na ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <div class="col-md-6">
                    <?php
                    if (!empty($competitor->competitorSupplier) && is_array($competitor->competitorSupplier)) {
                        ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Suppliers
                            </div>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Raw Material</th>
                                    <th>Country</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($competitor->competitorSupplier as $m) {
                                    ?>
                                    <tr>
                                        <td><?= $m->supplier_name ?? $na ?></td>
                                        <td><?= $m->raw_material ?? $na ?></td>
                                        <td><?= $m->country ?? $na ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Mother Company
                        </div>
                        <table class="table" style="table-layout:fixed;">
                            <tbody>
                            <tr>
                                <th>Name</th>
                                <td><?= $competitor->mother_name ?></td>
                            </tr>
                            <tr>
                                <th>Company Profile</th>
                                <td><?= $competitor->mother_company_profile ?></td>
                            </tr>
                            <tr>
                                <th>Headquarter Location</th>
                                <td><?= $competitor->mother_headquarter_location ?></td>
                            </tr>
                            <tr>
                                <th>Other Locations</th>
                                <td><?= $competitor->mother_other_locations ?></td>
                            </tr>
                            <tr>
                                <th>Website</th>
                                <td><?= $competitor->mother_website ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-6">
                    <?php
                    if (!empty($competitor->competitorSocial) && is_array($competitor->competitorSocial)) {
                        ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Social Media
                            </div>
                            <table class="table" style="table-layout:fixed;">
                                <tbody>
                                <?php
                                foreach ($competitor->competitorSocial as $m) {
                                    ?>
                                    <tr>
                                        <th><?= Html::a($m->social_media, $m->url, ['target' => 'blank', 'class' => 'text-navy']) ?></th>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php
            if (!empty($competitor->competitorProductionLine) && is_array($competitor->competitorProductionLine)) {
                ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Production Lines
                    </div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Production Line</th>
                            <th># of Colors</th>
                            <th># of Layers</th>
                            <th>Brand Line</th>
                            <th>Output</th>
                            <th>Unit</th>
                            <th>Width</th>
                            <th># of Machines</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($competitor->competitorProductionLine as $m) {
                            ?>
                            <tr>
                                <td><?= $m->production_line ?? $na ?></td>
                                <td><?= $m->colors_number ?? $na ?></td>
                                <td><?= $m->layers_number ?? $na ?></td>
                                <td><?= $m->machines_number ?? $na ?></td>
                                <td><?= $m->brand_line ?? $na ?></td>
                                <td><?= $m->output ?? $na ?></td>
                                <td><?= $m->unit ?? $na ?></td>
                                <td><?= $m->width ?? $na ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <?php
            }
            if (!empty($competitor->competitorNews) && is_array($competitor->competitorNews)) {
                ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        News
                    </div>
                    <table class="table" style="table-layout:fixed;">
                        <tbody>
                        <?php
                        foreach ($competitor->competitorNews as $m) {
                            ?>
                            <tr>
                                <td><?= $m->url ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
<?php
if (!empty($competitor->competitorFlexible) && is_array($competitor->competitorFlexible)) {
    ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            Flexible Packaging Products
        </div>
        <?php
        foreach ($competitor->competitorFlexible as $m) {
            ?>
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-striped table-hover table-condensed" style="table-layout:fixed;">
                        <tbody>
                        <tr>
                            <th>Product Type</th>
                            <td colspan="3"><?= $m->product_type ?? $na ?></td>
                        </tr>
                        <tr>
                            <th>Sector</th>
                            <td colspan="3"><?= $m->sector ? $m->sector : $na ?></td>
                        </tr>
                        <tr>
                            <th>Quantity Sold/Year</th>
                            <td><?= $m->quantity_sold ?? $na ?></td>
                            <th>Unit</th>
                            <td><?= $m->quantity_unit ?? $na ?></td>
                        </tr>
                        <tr>
                            <th>Specs</th>
                            <td colspan="3">
                                <table class="table table-striped table-bordered table-hover table-condensed"
                                       style="table-layout:fixed;">
                                    <thead>
                                    <tr>
                                        <th>Thickness (&mu;)</th>
                                        <th>Width (cm)</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><?= $m->thickness ?? $na ?></td>
                                        <td><?= $m->width ?? $na ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table class="table table-striped table-bordered table-hover table-condensed"
                                       style="table-layout:fixed;">
                                    <thead>
                                    <tr>
                                        <th>Color</th>
                                        <th># of Printing Colors</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><?= $m->color ?? $na ?></td>
                                        <td><?= $m->printing_colors_number ?? $na ?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="fa fa-<?= $m->embossed ? 'check text-green' : 'times text-red' ?>"></i>
                                            Embossed
                                        </td>
                                        <td>
                                            <i class="fa fa-<?= $m->perforated ? 'check text-green' : 'times text-red' ?>"></i>
                                            Perforated
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Core ID (mm)
                                        </th>
                                        <td>
                                            <?= $m->core_id ?? $na ?>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <th>Terms of Business</th>
                            <td colspan="3"><?= $m->business_terms ?? $na ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-striped table-hover table-condensed" style="table-layout:fixed;">
                        <tbody>
                        <tr>
                            <th>Incoterms</th>
                            <td colspan="3"><?= $m->incoterms ?? $na ?></td>
                        </tr>
                        <tr>
                            <th>Payment Facilities</th>
                            <td colspan="3"><?= $m->payment ?? $na ?></td>
                        </tr>
                        <tr>
                            <th>Price</th>
                            <td><?= $m->price ?? $na ?></td>
                            <th>Currency</th>
                            <td><?= $m->currency ?? $na ?></td>
                        </tr>
                        <?php
                        if (!empty($m->competitorFlexibleCustomer) && is_array($competitor->competitorFlexibleCustomer)) {
                            ?>
                            <tr>
                                <td colspan="4">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            Customers
                                        </div>
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Country</th>
                                                <th>Share in Percentage</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach ($competitor->competitorFlexibleCustomer as $c) {
                                                ?>
                                                <tr>
                                                    <td><?= $c->name ?? $na ?></td>
                                                    <td><?= $c->country ?? $na ?></td>
                                                    <td><?= $c->share_percentage ?? $na ?></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>

                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <hr>
            <?php
        }
        ?>
    </div>
    <?php
}
if (!empty($competitor->competitorPackaging) && is_array($competitor->competitorPackaging)) {
    ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            Rigid Packaging Products
        </div>
        <?php
        foreach ($competitor->competitorPackaging as $m) {
            ?>
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-striped table-hover table-condensed" style="table-layout:fixed;">
                        <tbody>
                        <tr>
                            <th>Product Type</th>
                            <td colspan="3"><?= $m->product_type ?? $na ?></td>
                        </tr>
                        <tr>
                            <th>Sector</th>
                            <td colspan="3"><?= $m->sector ? $m->sector : $na ?></td>
                        </tr>
                        <tr>
                            <th>Quantity Sold/Year</th>
                            <td><?= $m->quantity_sold ?? $na ?></td>
                            <th>Unit</th>
                            <td><?= $m->quantity_unit ?? $na ?></td>
                        </tr>
                        <tr>
                            <th>Specs</th>
                            <td colspan="3">
                                <table class="table table-striped table-bordered table-hover table-condensed"
                                       style="table-layout:fixed;">
                                    <thead>
                                    <tr>
                                        <th>Material</th>
                                        <th>Weight</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><?= $m->material ?? $na ?></td>
                                        <td><?= $m->weight ?? $na ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table class="table table-striped table-bordered table-hover table-condensed"
                                       style="table-layout:fixed;">
                                    <thead>
                                    <tr>
                                        <th>Diameter (mm)</th>
                                        <th>Color</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><?= $m->diameter ?? $na ?></td>
                                        <td><?= $m->color ?? $na ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table class="table table-striped table-bordered table-hover table-condensed"
                                       style="table-layout:fixed;">
                                    <thead>
                                    <tr>
                                        <th>Height (mm)</th>
                                        <th>Neck (mm)</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><?= $m->height ?? $na ?></td>
                                        <td><?= $m->neck ?? $na ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table class="table table-striped table-bordered table-hover table-condensed"
                                       style="table-layout:fixed;">
                                    <thead>
                                    <tr>
                                        <th>Ctn Volume (ml)</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><?= $m->ctn_volume ?? $na ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <th>Terms of Business</th>
                            <td colspan="3"><?= $m->business_terms ?? $na ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-striped table-hover table-condensed" style="table-layout:fixed;">
                        <tbody>
                        <tr>
                            <th>Incoterms</th>
                            <td colspan="3"><?= $m->incoterms ?? $na ?></td>
                        </tr>
                        <tr>
                            <th>Payment Facilities</th>
                            <td colspan="3"><?= $m->payment ?? $na ?></td>
                        </tr>
                        <tr>
                            <th>Price</th>
                            <td><?= $m->price ?? $na ?></td>
                            <th>Currency</th>
                            <td><?= $m->currency ?? $na ?></td>
                        </tr>
                        <?php
                        if (!empty($m->competitorPackagingCustomer) && is_array($competitor->competitorPackagingCustomer)) {
                            ?>
                            <tr>
                                <td colspan="4">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            Customers
                                        </div>
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Country</th>
                                                <th>Share in Percentage</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach ($competitor->competitorPackagingCustomer as $c) {
                                                ?>
                                                <tr>
                                                    <td><?= $c->name ?? $na ?></td>
                                                    <td><?= $c->country ?? $na ?></td>
                                                    <td><?= $c->share_percentage ?? $na ?></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>

                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <hr>
            <?php
        }
        ?>
    </div>
    <?php
}
if (!empty($competitor->competitorMasterbatch) && is_array($competitor->competitorMasterbatch)) {
    ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            Masterbatches and Inks Products
        </div>
        <?php
        foreach ($competitor->competitorMasterbatch as $m) {
            ?>
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-striped table-hover table-condensed" style="table-layout:fixed;">
                        <tbody>
                        <tr>
                            <th>Product Type</th>
                            <td colspan="3"><?= $m->product_type ?? $na ?></td>
                        </tr>
                        <tr>
                            <th>Sector</th>
                            <td colspan="3"><?= $m->sector ? $m->sector : $na ?></td>
                        </tr>
                        <tr>
                            <th>Quantity Sold/Year</th>
                            <td><?= $m->quantity_sold ?? $na ?></td>
                            <th>Unit</th>
                            <td><?= $m->quantity_unit ?? $na ?></td>
                        </tr>
                        <tr>
                            <th>Specs</th>
                            <td colspan="3">
                                <table class="table table-striped table-bordered table-hover table-condensed"
                                       style="table-layout:fixed;">
                                    <thead>
                                    <tr>
                                        <th>Active Ingredient</th>
                                        <th>MFI (g / 10mm)</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><?= $m->active_ingredient ?? $na ?></td>
                                        <td><?= $m->mfi ?? $na ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table class="table table-striped table-bordered table-hover table-condensed"
                                       style="table-layout:fixed;">
                                    <thead>
                                    <tr>
                                        <th>Resin Type</th>
                                        <th>Ink Type</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><?= $m->resin_type ?? $na ?></td>
                                        <td><?= $m->ink_type ?? $na ?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="fa fa-<?= $m->outdoor ? 'check text-green' : 'times text-red' ?>"></i>
                                            Outdoor
                                        </td>
                                        <td>
                                            <i class="fa fa-<?= $m->food_grade ? 'check text-green' : 'times text-red' ?>"></i>
                                            Food Grade
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <th>Terms of Business</th>
                            <td colspan="3"><?= $m->business_terms ?? $na ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-striped table-hover table-condensed" style="table-layout:fixed;">
                        <tbody>
                        <tr>
                            <th>Incoterms</th>
                            <td colspan="3"><?= $m->incoterms ?? $na ?></td>
                        </tr>
                        <tr>
                            <th>Payment Facilities</th>
                            <td colspan="3"><?= $m->payment ?? $na ?></td>
                        </tr>
                        <tr>
                            <th>Price</th>
                            <td><?= $m->price ?? $na ?></td>
                            <th>Currency</th>
                            <td><?= $m->currency ?? $na ?></td>
                        </tr>
                        <?php
                        if (!empty($m->competitorMasterbatchCustomer) && is_array($competitor->competitorMasterbatchCustomer)) {
                            ?>
                            <tr>
                                <td colspan="4">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            Customers
                                        </div>
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Country</th>
                                                <th>Share in Percentage</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach ($competitor->competitorMasterbatchCustomer as $c) {
                                                ?>
                                                <tr>
                                                    <td><?= $c->name ?? $na ?></td>
                                                    <td><?= $c->country ?? $na ?></td>
                                                    <td><?= $c->share_percentage ?? $na ?></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>

                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <hr>
            <?php
        }
        ?>
    </div>
    <?php
}

