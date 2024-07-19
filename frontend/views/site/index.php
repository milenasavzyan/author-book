<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Books';
?>

<body>
<h1 class="display-5 fw-bold text-body-emphasis text-center">Books</h1>

<div class="container px-5 py-4">
    <div class="row row-cols-1 row-cols-md-3 g-5">
        <?php if (!empty($books)) : ?>
            <?php foreach ($books as $book) : ?>
            <div class="col">
                <div class="card h-100 border-0 shadow-sm">
                        <div class="card-header">
                            <img src="<?= Html::encode($book->getImageUrl()) ?>" class="card-img-top" alt="<?= Html::encode($book->title) ?>" style="width: 330px; height: 440px;">
                        </div>
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
                            <?php foreach ($book->authors as $author): ?>
                                <?= Html::encode($author->first_name . $author->last_name ) ?>
                            <?php endforeach; ?>
                            <span id="selectedAuthor"></span>
                        </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<div class="row">
    <div class="col">
        <?= \yii\widgets\LinkPager::widget([
            'pagination' => $pagination,
        ]) ?>
    </div>
</div>

</body>
