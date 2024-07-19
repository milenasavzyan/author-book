<?php

namespace backend\models;

use common\models\Author;
use yii\data\ActiveDataProvider;

class AuthorSearch extends Author
{
    public function rules()
    {
        return [
          [['id'], 'integer'],
          [['id', 'first_name', 'last_name', 'biography'], 'safe'],

        ];
    }

    public function search($params)
    {
        $query = Author::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
        ]);
        $query->andFilterWhere([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'biography' => $this->biography,
        ]);

        return $dataProvider;
    }

}