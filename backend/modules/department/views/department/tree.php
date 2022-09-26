<?php
use \yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $zNodes array */
?>

<div>
    <div class="panel panel-default">
        <div class="panel-heading">Дерево посадочных страниц</div>
        <div class="panel-body">
            <!-- TREEVIEW CODE -->
            <div class="treeview">
                <? \common\components\helpers\DepartmentHelper::buildTreeView($zNodes) ?>
            </div>
            <!-- TREEVIEW CODE -->
        </div>
    </div>
</div>
<style>
    div.panel:first-child {
        margin-top:20px;
    }

    div.treeview {
        min-width: 100px;
        min-height: 100px;
        overflow:auto;
        padding: 4px;
        margin-bottom: 20px;
        color: #369;
        border: solid 1px;
        border-radius: 4px;
    }
    div.treeview ul:first-child:before {
        display: none;
    }
    .treeview, .treeview ul {
        margin:0;
        padding:0;
        list-style:none;
        color: #369;
    }
    .treeview ul {
        margin-left:1em;
        position:relative
    }
    .treeview ul ul {
        margin-left:.5em
    }
    .treeview ul:before {
        content:"";
        display:block;
        width:0;
        position:absolute;
        top:0;
        left:0;
        border-left:1px solid;
        /* creates a more theme-ready standard for the bootstrap themes */
        bottom:15px;
    }
    .treeview li {
        margin:0;
        padding:0 1em;
        line-height:2em;
        font-weight:700;
        position:relative
    }
    .treeview ul li:before {
        content:"";
        display:block;
        width:10px;
        height:0;
        border-top:1px solid;
        margin-top:-1px;
        position:absolute;
        top:1em;
        left:0
    }
    .tree-indicator {
        margin-right:5px;
        cursor:pointer;
    }
    .treeview li a {
        text-decoration: underline;
        cursor:pointer;
        font-weight: normal;
        color: royalblue;
    }
    .treeview li span {
        font-weight: normal;
        color: brown
    }
    .treeview li button, .treeview li button:active, .treeview li button:focus {
        text-decoration: none;
        color:inherit;
        border:none;
        background:transparent;
        margin:0 0 0 0;
        padding:0 0 0 0;
        outline: 0;
    }
</style>