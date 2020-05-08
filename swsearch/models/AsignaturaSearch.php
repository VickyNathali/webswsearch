<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Asignatura;

/**
 * AsignaturaSearch represents the model behind the search form of `app\models\Asignatura`.
 */
class AsignaturaSearch extends Asignatura {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['CODIGO_ASIG', 'NOMBRE_ASIG', 'OBSERVACIONES_ASIG'], 'safe'],
            [['ESTADO_ASIG'], 'integer'],
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
        $query = Asignatura::find();

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

        $query->andFilterWhere(['like', 'CODIGO_ASIG', $this->CODIGO_ASIG])
                ->andFilterWhere(['like', 'NOMBRE_ASIG', $this->NOMBRE_ASIG])
                ->andFilterWhere(['like', 'ESTADO_ASIG', $this->ESTADO_ASIG])
                ->andFilterWhere(['!=', 'ESTADO_ASIG', $id])
                ->andFilterWhere(['like', 'OBSERVACIONES_ASIG', $this->OBSERVACIONES_ASIG]);

        return $dataProvider;
    }

}
