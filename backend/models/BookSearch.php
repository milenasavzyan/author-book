<?php

namespace backend\models;

use common\models\Book;
use yii\data\ActiveDataProvider;

class BookSearch extends Book
{
    public function rules()
    {
        return [
            [['id', 'publication_year'], 'integer'],
            [['title', 'description'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Book::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'publication_year' => $this->publication_year,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}