<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CarsemAsigPer;

/**
 * CarsemAsigPerSearch represents the model behind the search form of `app\models\CarsemAsigPer`.
 */
class CarsemAsigPerSearch extends CarsemAsigPer
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID_CAR', 'ID_SEM', 'ID_PER', 'ESTADO_CSAP'], 'integer'],
            [['CODIGO_ASIG'], 'safe'],
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
        $id = 1;
        $query = CarsemAsigPer::find();

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
            'ID_CAR' => $this->ID_CAR,
            'ID_SEM' => $this->ID_SEM,
            'ID_PER' => $this->ID_PER,
        ]);

        $query->andFilterWhere(['like', 'CODIGO_ASIG', $this->CODIGO_ASIG])
                ->andFilterWhere(['=', 'ESTADO_CSAP', $id]);

        return $dataProvider;
    }
}
