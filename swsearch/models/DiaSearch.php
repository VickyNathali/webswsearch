<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Dia;

/**
 * DiaSearch represents the model behind the search form of `app\models\Dia`.
 */
class DiaSearch extends Dia
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID_DIA'], 'integer'],
            [['DESCRIPCION_DIA'], 'safe'],
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
        $query = Dia::find();

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
            'ID_DIA' => $this->ID_DIA,
        ]);

        $query->andFilterWhere(['like', 'DESCRIPCION_DIA', $this->DESCRIPCION_DIA]);

        return $dataProvider;
    }
}
