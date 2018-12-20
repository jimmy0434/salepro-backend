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
    <div class="grid-contents">
        <div v-if="activeFolder">
            <ol class="breadcrumb">
                <li class="active">
                    <img :src="activeFolder.directory.logo" v-if="activeFolder.directory.logo" style="position:relative;top:-2px;display:inline-block;height:24px;">
                    {{ activeFolder.directory.model.data.name }}
                </li>
                <li class="active">
                    <img :src="activeFolder.classification.logo" v-if="activeFolder.classification.logo" style="position:relative;top:-2px;display:inline-block;height:24px;">
                    {{ activeFolder.classification.model.data.name }}
                </li>
                <li class="active">
                    <img :src="activeFolder.logo" v-if="activeFolder.logo" style="position:relative;top:-2px;display:inline-block;height:24px;">
                    {{ activeFolder.model.data.name }}
                </li>
            </ol>
        </div>
    </div>
</div>
</div>
<!-- item template -->
<script type="text/x-template" id="tree-item-template">
    <li>
        <div :class="{file: 'file', folder: isFolder}" @click="toggle">
            <input type="file" @change="uploadIcon" :ref="'file-browse-'+model.data.id">
            <div v-if="!editMode" @dblclick="edit" @click="openFolder">
                <span class="glyphicon glyphicon-plus text-success" v-if="isFolder && !open"></span>
                <span class="glyphicon glyphicon-minus text-danger" v-if="isFolder && open"></span>
                <span class="glyphicon glyphicon-picture text-muted" v-if="!logo" @click="browseIcon"></span>
                <img :src="logo" v-if="logo" style="height:14px;display:inline-block;position:relative;top:-2px;" @click="browseIcon">
                <span :title="level === 3?'click to show contents, double click to edit':null">{{ model.data.name }}</span>
                <span class="text-muted" v-if="count > 0"> ( {{count}} )</span>
            </div>
            <div v-if="editMode" class="input-new">
                <input type="text" class="form-control edit-input" v-model="model.data.name" @keyup.enter="applyEdit"
                       placeholder="Edit Category" :ref="'category-'+model.data.name">
            </div>
        </div>

        <ul v-show="open" v-if="isFolder">
            <item
                    class="item"
                    v-for="(subCategory, index) in model.children"
                    :key="'child' + index + '-' + level"
                    :model="subCategory" :level="level+1" :directory="directory" :classification="classification">
            </item>
            <li v-if="level === 2" class="input-new">
                <input type="text" class="form-control" v-model="newCategoryName" @keyup.enter="addChild"
                       placeholder="Add New Category, then press Enter key">
            </li>
        </ul>
    </li>
</script>
