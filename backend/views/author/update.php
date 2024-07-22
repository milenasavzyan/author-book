<?php
/* @var $this \yii\web\View */
/* @var $model \common\models\Author */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Update ' . $model->first_name;
$this->params['breadcrumbs'][] = ['label' => 'Authors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<?php $form = ActiveForm::begin() ?>

<?= $form->field($model, 'first_name')->textInput() ?>

<?= $form->field($model, 'last_name')->textInput() ?>

<?= $form->field($model, 'biography')->textInput() ?>


    <hr>

<?= Html::submitButton('Update', ['class' => 'btn btn-success']) ?>



<?php ActiveForm::end() ?>