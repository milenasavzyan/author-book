<?php
$this->title = 'View User';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container px-5 py-4">
    <div class="user row row-cols-1 row-cols-md-12 g-5">
        <?php if (!empty($user)) : ?>
            <div class="col">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-header" style="background-color: #4a5568; color: white;">
                        <h5 class="card-title mb-0"><?= $user->username ?></h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            <strong>Name:</strong> <?= $user->username ?>
                        </p>
                        <p class="card-text">
                            <strong>E-mail:</strong> <?= $user->email ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>