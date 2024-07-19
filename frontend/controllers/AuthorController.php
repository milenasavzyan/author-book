<?php

namespace frontend\controllers;

use common\models\Author;
use yii\data\Pagination;
use yii\web\Controller;

class AuthorController extends Controller
{
    public function actionIndex($search = null)
    {
        $query = Author::find();

        if ($search !== null) {
            $query->andWhere(['like', 'first_name', $search]);
        }

        $pagination = new Pagination([
            'defaultPageSize' => 2,
            'totalCount' => $query->count(),
        ]);

        $authors = $query->orderBy('first_name')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
            'authors' => $authors,
            'pagination' => $pagination,
            'search' => $search,
        ]);
    }

}