<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PeriodoAcademico;

/**
 * PeriodoAcademicoSearch represents the model behind the search form of `app\models\PeriodoAcademico`.
 */
class PeriodoAcademicoSearch extends PeriodoAcademico {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['ID_PER', 'ESTADO_PER'], 'integer'],
            [['INICIO_PER', 'FIN_PER', 'OBSERVACIONES_PER'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios() {
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
    public function search($params) {
        $id = 3;
        $query = PeriodoAcademico::find();

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
        ]);

        $query->andFilterWhere(['like', 'INICIO_PER', $this->INICIO_PER])
                ->andFilterWhere(['like', 'FIN_PER', $this->FIN_PER])
                ->andFilterWhere(['like', 'OBSERVACIONES_PER', $this->OBSERVACIONES_PER])
                ->andFilterWhere(['like', 'ESTADO_PER', $this->ESTADO_PER])
                ->andFilterWhere(['!=', 'ESTADO_PER', $id]);

        return $dataProvider;
    }

}
