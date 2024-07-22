<?php

/* @var $this \yii\web\View */
/* @var $searchModel \backend\models\UserSearch */
/* @var $dataProvider \yii\data\ActiveDataProvider */

use common\models\User;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\bootstrap5\Html;
use yii\helpers\Url;

$this->title = 'Users';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

    <div class="form-group">
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </div>
<?= GridView::widget([
    'filterModel' => $searchModel,
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'attribute' => 'id',
            'headerOptions' => ['width' => 100],
        ],
        'username',
        'email',
        [
            'attribute' => 'status',
            'value' => function(User $model) {
                $statuses = User::getStatuses();
                return $statuses[$model->status];
            },
            'filter' => User::getStatuses(),
        ],
        'is_admin:boolean',
        [
            'class' => ActionColumn::class,
            'urlCreator' => function ($action, \common\models\User $model, $key, $index, $column) {
                return Url::toRoute([$action, 'id' => $model->id]);
            }
        ],

    ]
]) ?>