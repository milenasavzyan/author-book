<?php

namespace frontend\controllers;

use common\models\Book;
use yii\data\Pagination;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public function actionIndex($search = null)
    {
        $query = Book::find();

        $pagination = new Pagination([
            'defaultPageSize' => 3,
            'totalCount' => $query->count(),
        ]);

        $books = $query->orderBy('title')
            ->offset($pagination->offset)
            ->limit($pagination->limit);

        if ($search !== null) {
            $query->andFilterWhere(['like', 'title', $search]);
        }

        $books = $query->all();

        return $this->render('index', [
            'books' => $books,
            'pagination' => $pagination,
            'search' => $search,
        ]);
    }

}
