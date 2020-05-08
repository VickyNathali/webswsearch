<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Semestre;

/**
 * SemestreSearch represents the model behind the search form of `app\models\Semestre`.
 */
class SemestreSearch extends Semestre
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID_SEM','ESTADO_SEM'], 'integer'],
            [['DESCRIPCION_SEM'], 'safe'],
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
        $id = 3;
        $query = Semestre::find();

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
            
        ]);

        $query->andFilterWhere(['like', 'DESCRIPCION_SEM', $this->DESCRIPCION_SEM])
                ->andFilterWhere(['like', 'ESTADO_SEM', $this->ESTADO_SEM])
                ->andFilterWhere(['!=', 'ESTADO_SEM', $id]);

        return $dataProvider;
    }
}
