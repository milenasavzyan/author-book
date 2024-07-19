<?php

/* @var $this \yii\web\View */
/* @var $searchModel \backend\models\AuthorSearch */
/* @var $dataProvider \yii\data\ActiveDataProvider */

use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\bootstrap5\Html;
use yii\helpers\Url;

$this->title = 'Author';
$this->params['breadcrumbs'][] = ['label' => 'Authors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

    <div class="form-group">
        <?= Html::a('Create Author', ['create'], ['class' => 'btn btn-success']) ?>
    </div>

<?= GridView::widget([
    'filterModel' => $searchModel,
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'attribute' => 'id',
            'headerOptions' => ['width' => 100],
        ],
        'first_name',
        'last_name',
        'biography',
        [
            'class' => ActionColumn::className(),
            'urlCreator' => function ($action, \common\models\Author $model, $key, $index, $column) {
                return Url::toRoute([$action, 'id' => $model->id]);
            }
        ],
    ]
]) ?>