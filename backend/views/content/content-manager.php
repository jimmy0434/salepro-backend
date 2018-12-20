<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 12/20/2018
 * Time: 8:57 AM
 *
 * @var $this View
 * @var $context ContentController
 */

use backend\controllers\ContentController;
use yii\web\View;

?>
<div id="content-manager">
    <div class="side-categories">
        <ul class="root-node">
            <item
                    v-for="(treeData, index) in tree" v-bind:key="'tree-item-'+index"
                    class="item"
                    :model="treeData" :level="1">
            </item>
        </ul>
    </div>
    <div class="grid-contents">Demo...</div>
</div>
</div>
<!-- item template -->
<script type="text/x-template" id="tree-item-template">
    <li>
        <div :class="{file: 'file', folder: isFolder}" @click="toggle">
            <div v-if="!editMode" @dblclick="edit">
                <span class="glyphicon glyphicon-plus text-success" v-if="isFolder && !open"></span>
                <span class="glyphicon glyphicon-minus text-danger" v-if="isFolder && open"></span>
                {{ model.data.name }}
                <span class="text-muted pull-right" v-if="count > 0">&nbsp;{{count}}</span>
            </div>
            <div v-if="editMode" class="input-new">
                <input type="text" class="form-control edit-input" v-model="model.data.name" @keyup.enter="applyEdit"
                       placeholder="Edit Category" :ref="'category-'+model.data.name">
            </div>
        </div>

        <ul v-show="open" v-if="isFolder">
            <item
                    class="item"
                    v-for="(model, index) in model.children"
                    :key="'child' + index + '-' + level"
                    :model="model" :level="level+1">
            </item>
            <li v-if="level === 2" class="input-new">
                <input type="text" class="form-control" v-model="newCategoryName" @keyup.enter="addChild"
                       placeholder="Add New Category, Then press Enter key">
            </li>
        </ul>
    </li>
</script>
