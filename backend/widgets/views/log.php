<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 3/14/2019
 * Time: 12:51 PM
 */

use common\models\User;
use yii\helpers\Json;

?>  

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Latest Logs</h3>
    </div>
    <ul class="list-group" style="max-height:300px;overflow-y:auto;overflow-x:hidden;">
        <?php
        if (!empty($list) && is_array($list)) {
            foreach ($list as $item) {
                ?>
                <li class="list-group-item">
                    <h4 class="list-group-item-heading"><?= $item->message ?></h4>
                    <p class="list-group-item-text text-muted"><?= date('l,d F, Y H:i', strtotime($item->date)) ?></p>
                    <?php
                    if (Yii::$app->user->identity->type == User::TYPE_ROOT) {
                        ?>
                        <p class="list-group-item-text">
                            <?php
                            $item->data = Json::decode($item->data);
                            if (!empty($item->data) && is_array($item->data)) {
                                ob_start();
                                echo '<div class="text-danger">Changed Attributes</div>';
                                foreach ($item->data as $attr => $details) {
                                    echo '<div><strong>' . $attr . '</strong> : <span class="text-muted">`' . implode('`</span> &rsaquo; <span class="text-primary">`', $details) . '`</span></div>';
                                }
                                echo ob_get_clean();
                            } else {
                                echo '<div class="text-muted">no changes</div>';
                            }
                            ?>
                        </p>
                        <?php
                    }
                    ?>
                </li> 
                <?php
            }
        }
        ?>
    </ul>
    <div class="panel-footer text-center">
        <?= \yii\helpers\Html::a('View All', ['/admin/log/index', '_filter' => [
            'user_id' => [
                'value' => $this->context->userId,
                'condition' => '=',
            ],
        ]], ['target' => '_blank', 'class' => 'btn btn-info']); ?>
    </div>
</div>
