<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 3/14/2019
 * Time: 12:25 PM
 */

$this->title = "Salesman";

?>
<div class="panel panel-default">
    <div class="panel-heading">
        <?= $user->name ?>
        <span class="badge pull-right"><?= $user->status_label ?></span>
    </div>
    <ul class="list-group">
        <li class="list-group-item">
            Job Title : <code><?= $user->profile->job_title ?></code>
        </li>
        <li class="list-group-item">
            Mac Address : <code><?= $user->profile->mac_address ?></code>
        </li>
    </ul>
</div>
<?= \cnd\admin\widgets\Log::widget(['userId'=>$user->id]) ?>
<?php

