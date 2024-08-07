<?php
/* @var $this \yii\web\View */
/* @var $model \common\models\Book */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;


$this->title = 'View Book';
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container px-5 py-4">
    <div class="row row-cols-1 row-cols-md-12 g-5">
        <?php if (!empty($book)) : ?>
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li><strong>Title:</strong><?= $book->title ?></li>
                            </ul>
                            <ul class="list-unstyled">
                                <li><strong>Description:</strong><?= $book->description ?></li>
                            </ul>
                            <ul class="list-unstyled">
                                <li><strong>Publication:</strong><?= $book->publication_year ?></li>
                            </ul>
                            <strong>Author:</strong>
                            <?= GridView::widget([
                                'dataProvider' => new \yii\data\ArrayDataProvider([
                                    'allModels' => $book->authors,
                                    'pagination' => false,
                                ]),
                                'columns' => [
                                        'id',
                                    'first_name',
                                    'last_name',
                                ],
                            ]); ?>

                            <span id="selectedAuthor"></span>
                        </div>
                    </div>
                </div>
        <?php endif; ?>
    </div>
</div>
