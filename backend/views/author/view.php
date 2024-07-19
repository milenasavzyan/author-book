<?php
/* @var $this \yii\web\View */
/* @var $author \common\models\Author */


$this->title = 'View Author';
$this->params['breadcrumbs'][] = ['label' => 'Authors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container px-5 py-4">
    <div class="user row row-cols-1 row-cols-md-12 g-5">
        <?php if (!empty($author)) : ?>
            <div class="col">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-header" style="background-color: #4a5568; color: white;">
                        <h5 class="card-title mb-0"><?= $author->first_name ?></h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            <strong>Name:</strong> <?= $author->first_name ?>
                        </p>
                        <p class="card-text">
                            <strong>Last Name:</strong> <?= $author->last_name ?>
                        </p>
                        <p class="card-text">
                            <strong>Biography:</strong> <?= $author->biography ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>