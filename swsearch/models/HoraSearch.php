<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Hora;

/**
 * HoraSearch represents the model behind the search form of `app\models\Hora`.
 */
class HoraSearch extends Hora
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID_HORA','ESTADO_HORA'], 'integer'],
            [['INICIO_HORA', 'FIN_HORA'], 'safe'],
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
        $query = Hora::find();

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
            'ID_HORA' => $this->ID_HORA,
            'INICIO_HORA' => $this->INICIO_HORA,
            'FIN_HORA' => $this->FIN_HORA,
        ]);
        $query->andFilterWhere(['like', 'ESTADO_HORA', $this->ESTADO_HORA])
                ->andFilterWhere(['!=', 'ESTADO_HORA', $id]);

        return $dataProvider;
    }
}
