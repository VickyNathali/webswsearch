<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Carrera;

/**
 * CarreraSearch represents the model behind the search form of `app\models\Carrera`.
 */
class CarreraSearch extends Carrera {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['ID_CAR', 'DURACION_CAR', 'ESTADO_CAR'], 'integer'],
            [['NOMBRE_CAR', 'DIRECTOR_CAR', 'TITULO_OBT_CAR'], 'safe'],
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
        $query = Carrera::find();

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
            'DURACION_CAR' => $this->DURACION_CAR,           
        ]);

        $query->andFilterWhere(['like', 'NOMBRE_CAR', $this->NOMBRE_CAR])
                ->andFilterWhere(['like', 'DIRECTOR_CAR', $this->DIRECTOR_CAR])
                ->andFilterWhere(['like', 'ESTADO_CAR', $this->ESTADO_CAR])
                ->andFilterWhere(['!=', 'ESTADO_CAR', $id])
                ->andFilterWhere(['like', 'TITULO_OBT_CAR', $this->TITULO_OBT_CAR]);

        return $dataProvider;
    }

}
