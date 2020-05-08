<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Persona;

/**
 * PersonaSearch represents the model behind the search form of `app\models\Persona`.
 */
class PersonaSearch extends Persona {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['CEDULA_PER', 'NOMBRES_PER', 'APELLIDOS_PER', 'USUARIO_PER', 'CONTRASENA_PER', 'FOTO_PER', 'TOKEN_PER'], 'safe'],
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
        $query = Persona::find();
  
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
        $query->andFilterWhere(['like', 'CEDULA_PER', $this->CEDULA_PER])
                ->andFilterWhere(['like', 'NOMBRES_PER', $this->NOMBRES_PER])
                ->andFilterWhere(['like', 'APELLIDOS_PER', $this->APELLIDOS_PER])
                ->andFilterWhere(['like', 'USUARIO_PER', $this->USUARIO_PER])
                ->andFilterWhere(['like', 'CONTRASENA_PER', $this->CONTRASENA_PER])
                ->andFilterWhere(['like', 'FOTO_PER', $this->FOTO_PER])
                ->andFilterWhere(['!=', 'TOKEN_PER', $id]); //solo me muestra administradores acivos e inactivo

        return $dataProvider;
    }

}
