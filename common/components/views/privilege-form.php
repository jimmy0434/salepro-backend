<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 4/24/2019
 * Time: 10:09 AM
 */

use common\models\Group;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use common\models\User;

if ($model->isOwner) {
    $options = [
        'item' => function ($index, $label, $name, $checked, $value) {
            ob_start();
            if ($index == 0) {
                ?>
                <div class="btn-group btn-group-justified privilege-options-list">
                <?php
            }
            ?>
            <div class="btn-group" role="group">
                <label class="btn btn-default btn-privilege glyphicon" style="overflow:hidden;">
                    <input type="radio" name="<?= $name ?>" value="<?= $value ?>"
                           tabindex="3" <?= ($checked ? 'checked="checked"' : '') ?>
                           style="position:relative;left:-1000px;">
                    <!--<span class="glyphicon glyphicon-ok text-success"></span>-->
                    <span class="text"><?= ucwords($label) ?></span>
                </label>
            </div>
            <?php
            if ($index == 1) {
                ?>
                </div>
                <hr>
                <?php
            }
            return ob_get_clean();
        },
        'style' => 'height:auto;border:none;',
    ];
    ?>
    <?= $form->field($model, $model->privilegePrefix . 'privilege[owner]')->hiddenInput()->label(false) ?>
    <?php
    if (CND_APPLICATION != 'backend') {
        echo $form->field($model, $model->privilegePrefix . 'privilege[admin]')->hiddenInput()->label(false);
    }
    ?>
    <div class="privilege-form">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <?php
                    echo $form->field($model, $model->privilegePrefix . 'privilege[public]')->hiddenInput()->label(false);
                    echo $form->field($model, $model->privilegePrefix . 'privilege[protected]')->hiddenInput()->label(false);
                    echo $form->field($model, $model->privilegePrefix . 'privilege[groups]')->hiddenInput()->label(false);
                    /*
                    ?>
                    <div class="col-md-6">
                        <div class="page-header">
                            <h3>Guest Visitors</h3>
                        </div>
                        <?= $form->field($model, $model->privilegePrefix . 'privilege[public]')->radioList([
                            'guest.0.0.0' => 'Hidden',
                            'guest.1.0.0' => 'Visible',
                            //'guest.1.1.0' => 'Read,Write',
                        ], $options)->label(false) ?>
                    </div>

                    <div class="col-md-6">
                        <div class="page-header">
                            <h3>System Users</h3>
                        </div>
                        <?= $form->field($model, $model->privilegePrefix . 'privilege[protected]')->radioList([
                            'user.*.0.0.0' => 'Hidden',
                            'user.*.1.0.0' => 'Visible',
                            //'user.*.1.1.0' => 'Read,Write',
                        ], $options)->label(false) ?>
                    </div>
                    <div class="col-md-6">
                        <div class="page-header">
                            <h3>All Groups</h3>
                        </div>
                        <?= $form->field($model, $model->privilegePrefix . 'privilege[groups]')->radioList([
                            'group.*.0.0.0' => 'Hidden',
                            'group.*.1.0.0' => 'Visible',
                            //'group.*.1.1.0' => 'Read,Write',
                        ], $options)->label(false) ?>
                    </div>
                    <?php */ ?>
                    <?php
                    /*if (CND_APPLICATION == 'backend') {
                        ?>
                        <div class="col-md-6">
                            <div class="page-header">
                                <h3>Administrations</h3>
                            </div>
                            <?= $form->field($model, $model->privilegePrefix . 'privilege[admin]')->radioList([
                                'admin.0.0.0' => 'Hidden',
                                'admin.1.0.0' => 'Visible',
                                //'admin.1.1.0' => 'Read,Write',
                            ], $options)->label(false) ?>
                        </div>
                        <?php
                    }*/
                    ?>
                </div>
                <?php
                $groups = Group::find()->orderBy(['name' => SORT_ASC])->all();
                if (!empty($groups) && is_array($groups)) {
                    ?>
                    <div class="page-header">
                        <h3>Groups Customization</h3>
                    </div>
                    <div class="row">
                        <?php
                        foreach ($groups AS $key => $group) {
                            $privilege = $model->privilege;
                            if (!isset($privilege['group'][$group->id])) {
                                $privilege['group'][$group->id] = 'group.' . $group->id . '.0.0.0';
                            }
                            $model->privilege = $privilege;
                            ?>
                            <div class="col-md-6">
                                <?php
                                echo $form->field($model, $model->privilegePrefix . 'privilege[group][' . $group->id . ']')->radioList([
                                    'group.' . $group->id . '.0.0.0' => 'Hidden',
                                    'group.' . $group->id . '.1.0.0' => 'Visible',
                                    //'group.' . $group->id . '.1.1.0' => 'Read,Write',
                                ], $options)->label($group->name, [
                                    'style' => 'display:block;',
                                ]);
                                ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                }
                if (Yii::$app->has('userGroup')) {
                    $groups = Yii::$app->userGroup->groups;
                    $list = [];
                    $data = [];
                    if (!empty($groups) && is_array($groups)) {
                        ?>
                        <div class="page-header">
                            <h3>Users Customization</h3>
                        </div>
                        <div class="row">
                            <?php
                            foreach ($groups AS $key => $group) {
                                $list[$key] = $group->title;
                                $data[$key] = $group->list;
                                if (!empty($group->list) && is_array($group->list)) {
                                    foreach ($group->list as $id => $name) {
                                        if (Yii::$app->user->identity->id != $id) {
                                            $privilege = $model->privilege;
                                            if (!isset($privilege['private'][$id])) {
                                                $privilege['private'][$id] = 'user.' . $id . '.0.0.0';
                                            }
                                            $model->privilege = $privilege;
                                            ?>
                                            <div class="col-md-6">
                                                <?php
                                                echo $form->field($model, $model->privilegePrefix . 'privilege[private][' . $id . ']')->radioList([
                                                    'user.' . $id . '.0.0.0' => 'None',
                                                    'user.' . $id . '.1.0.0' => 'Visible',
                                                    //'user.' . $id . '.1.1.0' => 'Read,Write',
                                                ], $options)->label($name . '<span class="pull-right text-muted">' . $group->title . '</span>', [
                                                    'style' => 'display:block;',
                                                ]);
                                                ?>
                                            </div>
                                            <?php
                                        }
                                    }
                                }
                            }
                            ?>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <style type="text/css">
        /*.privilege-options-list input[type=radio] + .glyphicon{display:none; position:absolute; top:8px; left:5px;}
        .privilege-options-list .btn-privilege:before{content:"\e013"; display:block; position:absolute; top:5px; left:5px; color:#E7E7E7;}
        .privilege-options-list .btn-privilege:hover:before{color:#ddd;}
        .privilege-options-list input[type=radio]:checked + .glyphicon{display:block;}*/


        .privilege-options-list input[type=radio] + .text {
            color: #ccc;
        }

        .privilege-options-list .btn-privilege:hover .text {
            color: #aaa;
        }

        .privilege-options-list input[type=radio]:checked + .text {
            color: #000;
        }

        .privilege-form .form-control {
            box-shadow: none;
            padding: 0;
        }
    </style>
    <?php
}
