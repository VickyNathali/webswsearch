<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CarreraSemestre;

/**
 * CarreraSemestreSearch represents the model behind the search form of `app\models\CarreraSemestre`.
 */
class CarreraSemestreSearch extends CarreraSemestre
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
             [['ID_SEM', 'ID_CAR', 'ESTADO_CARSEM'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = CarreraSemestre::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'ID_SEM' => $this->ID_SEM,
            'ID_CAR' => $this->ID_CAR,
             'ESTADO_CARSEM' => $this->ESTADO_CARSEM,
        ]);

        return $dataProvider;
    }
}
