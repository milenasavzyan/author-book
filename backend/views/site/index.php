<?php

/* @var $this \yii\web\View */

use yii\widgets\Menu;

$this->title = "Welcome!"
?>

<div class="row">
    <div class="col-lg-4 col-xs-12">
        <h5>Users</h5>
        <div class="icon">
            <i class="fa fa-user"></i>
        </div>
        <a href="<?= \yii\helpers\Url::to(['user/index']) ?>" class="small-box-footer">
            More info <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div>

    <div class="col-lg-4 col-xs-12">
        <h5>Books</h5>
        <div class="icon">
            <i class="fa fa-book"></i>
        </div>
        <a href="<?= \yii\helpers\Url::to(['book/index']) ?>" class="small-box-footer">
            More info <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div>

    <div class="col-lg-4 col-xs-12">
        <h5>Authors</h5>
        <div class="icon">
            <i class="fa fa-male"></i>
        </div>
        <a href="<?= \yii\helpers\Url::to(['author/index']) ?>" class="small-box-footer">
            More info <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div>
</div>

