<?php
/* @var $this \yii\web\View */
/* @var $model \common\models\Book */

use common\models\Author;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Update ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

<?= $form->field($model, 'publication_year')->textInput() ?>

<?= $form->field($model, 'imageFile')->fileInput() ?>

<?= $form->field($model, 'author_ids[]')->dropDownList(
    \yii\helpers\ArrayHelper::map(
        Author::find()->all(),
        'id',
        function($model) {
            return $model->first_name . ' ' . $model->last_name;
        }
    ),
) ?>


<div class="form-group">
    <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
