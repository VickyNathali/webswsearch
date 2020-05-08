<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AsigDocPer;

/**
 * AsigDocPerSearch represents the model behind the search form of `app\models\AsigDocPer`.
 */
class AsigDocPerSearch extends AsigDocPer
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CODIGO_ASIG', 'CEDULA_DOC', 'PARALELO'], 'safe'],
            [['ID_PER', 'ID_CAR', 'ID_SEM'], 'integer'],
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
        $query = AsigDocPer::find();

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
            'ID_PER' => $this->ID_PER,
            'ID_CAR' => $this->ID_CAR,
            'ID_SEM' => $this->ID_SEM,
        ]);

        $query->andFilterWhere(['like', 'CODIGO_ASIG', $this->CODIGO_ASIG])
            ->andFilterWhere(['like', 'CEDULA_DOC', $this->CEDULA_DOC])
            ->andFilterWhere(['like', 'PARALELO', $this->PARALELO]);

        return $dataProvider;
    }
}
