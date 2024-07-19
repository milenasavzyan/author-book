<?php

/* @var $this \yii\web\View */
/* @var $searchModel \backend\models\BookSearch */
/* @var $dataProvider \yii\data\ActiveDataProvider */

use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\bootstrap5\Html;
use yii\helpers\Url;

$this->title = 'Book';
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <div class="form-group">
        <?= Html::a('Create Book', ['create'], ['class' => 'btn btn-success']) ?>
    </div>

<?= GridView::widget([
    'filterModel' => $searchModel,
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'attribute' => 'id',
            'headerOptions' => ['width' => 100],
        ],
        'title',
        'description',
        [
            'attribute' => 'Authors',
            'value' => function ($model) {
                $authors = $model->authors;
                if ($authors !== null) {
                    $authorNames = [];
                    foreach ($authors as $author) {
                        $authorNames[] = $author->fullName;
                    }
                    return implode(', ', $authorNames);
                } else {
                    return '';
                }
            },
            'format' => 'raw',
        ],
        [
            'class' => ActionColumn::class,
            'urlCreator' => function ($action, \common\models\Book $model, $key, $index, $column) {
                return Url::toRoute([$action, 'id' => $model->id]);
            }
        ],
    ]
]) ?>