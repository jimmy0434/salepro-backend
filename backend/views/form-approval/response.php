<?php

/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 12/3/2018
 * Time: 1:55 PM
 *
 * @var $this \yii\web\View
 * @var $model FormApproval
 */

use common\models\FormApproval;
use common\widgets\FormPreview;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "Review Form `".$model->form->title."` requested by `".$model->user->name."`";

?>
<div class="panel panel-default">
    <div class="panel-heading">
        <?= $model->form->title ?>
        <span class="label label-<?= ($model->status == FormApproval::STATUS_APPROVED ? 'success' : 'danger') ?> pull-right"><?= $model->status_label ?></span>
    </div>
    <div class="panel-body">
        <?php
        $users = $model->formApprovalUsers;
        if (!empty($users) && is_array($users)) {
            ?>
            <div class="panel-heading">
                <h2>Review Message</h2>
            </div>
            <div class="well">
                <dl>
                    <?php
                    foreach ($users as $requestedUser) {
                        if ($requestedUser->message) {
                            ?>
                            <dt class="text-primary"><?= $requestedUser->user->name ?></dt>
                            <dd class="text-<?= $requestedUser->status == FormApproval::STATUS_APPROVED ? 'success' : 'danger' ?>"><?= $requestedUser->message ?></dd>
                            <?php
                        }
                    }
                    ?>
                </dl>
            </div>
            <?php
        }
        try {
            echo FormPreview::widget([
                'form' => $model->form,
            ]);
        } catch (\Throwable $t) {

        } catch (\Exception $e) {

        }
        if (Yii::$app->permission->can('/form/manage-structure')) {
            echo Html::a('Open Form Structure Builder', Url::to(['/form/manage-structure', 'id' => $model->form->id]), ['class' => 'btn bg-orange']);
        }
        ?>
    </div>
</div>

