<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AulaLaboratorio;

/**
 * AulaLaboratorioSearch represents the model behind the search form of `app\models\AulaLaboratorio`.
 */
class AulaLaboratorioSearch extends AulaLaboratorio
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID_AUL', 'ESTADO_AUL'], 'integer'],
            [['NOMBRE_AUL', 'LATITUD_AUL', 'LONGITUD_AUL', 'FOTO_AUL', 'OBSERVACIONES_AUL'], 'safe'],
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
        $query = AulaLaboratorio::find();

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
            'ID_AUL' => $this->ID_AUL,
        ]);

        $query->andFilterWhere(['like', 'NOMBRE_AUL', $this->NOMBRE_AUL])
            ->andFilterWhere(['like', 'LATITUD_AUL', $this->LATITUD_AUL])
            ->andFilterWhere(['like', 'LONGITUD_AUL', $this->LONGITUD_AUL])
            ->andFilterWhere(['like', 'FOTO_AUL', $this->FOTO_AUL])
            ->andFilterWhere(['like', 'ESTADO_AUL', $this->ESTADO_AUL])
            ->andFilterWhere(['!=', 'ESTADO_AUL', $id])
            ->andFilterWhere(['like', 'OBSERVACIONES_AUL', $this->OBSERVACIONES_AUL]);

        return $dataProvider;
    }
}
