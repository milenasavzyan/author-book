<?php

/* @var $this \yii\web\View */
/* @var $model User */

use common\models\User;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

if ($model->isNewRecord) {
	$this->title = 'New User';
} else {
	$this->title = 'Update ' . $model->username;
}
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin() ?>

<?= $form->field($model, 'username')->textInput() ?>

<?= $form->field($model, 'email')->textInput(['type' => 'email']) ?>

<?= $form->field($model, 'status')->dropDownList(User::getStatuses()) ?>

<?= $form->field($model, 'is_admin')->dropDownList(['No', 'Yes']) ?>

<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>

<?php ActiveForm::end() ?>
