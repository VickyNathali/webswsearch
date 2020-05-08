<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Estudiante;

/**
 * EstudianteSearch represents the model behind the search form of `app\models\Estudiante`.
 */
class EstudianteSearch extends Estudiante
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CEDULA_PER','ID_CAR'], 'safe'] //se cambio ID_CAR a safe para buscar
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
        $query = Estudiante::find();
        $query->joinWith('cEDULAPER');

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
           // 'ID_CAR' => $this->ID_CAR,
        ]);

        $query->andFilterWhere(['like', 'CEDULA_PER', $this->CEDULA_PER])
             // ->andFilterWhere(['like', 'ID_CAR', $this->ID_CAR])
              ->andFilterWhere(['like', 'CONCAT(`persona`.`NOMBRES_PER`," ",`persona`.`APELLIDOS_PER`)', $this->ID_CAR]);


        return $dataProvider;
    }
}
