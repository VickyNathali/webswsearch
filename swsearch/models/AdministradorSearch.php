<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Administrador;

/**
 * AdministradorSearch represents the model behind the search form of `app\models\Administrador`.
 */
class AdministradorSearch extends Administrador
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CEDULA_PER', 'CARGO_ADM', 'TITULO_ADM'], 'safe'],
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
        $query = Administrador::find();

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
            
        ]);

        $query->andFilterWhere(['like', 'CEDULA_PER', $this->CEDULA_PER])
            ->andFilterWhere(['like', 'CARGO_ADM', $this->CARGO_ADM])
            ->andFilterWhere(['like', 'TITULO_ADM', $this->TITULO_ADM]);

        return $dataProvider;
    }
}
