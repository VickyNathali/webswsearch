<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Docente;

/**
 * DocenteSearch represents the model behind the search form of `app\models\Docente`.
 */
class DocenteSearch extends Docente {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['CEDULA_DOC', 'NOMBRES_DOC', 'APELLIDOS_DOC', 'TITULO_DOC', 'CELULAR_DOC', 'CORREO_DOC', 'LINK_PAG_DOC', 'ESTADO_DOC'], 'safe'],
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
        $query = Docente::find();

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
        ]);
        // grid filtering conditions
        $query->andFilterWhere(['like', 'CEDULA_DOC', $this->CEDULA_DOC])
                ->andFilterWhere(['like', 'NOMBRES_DOC', $this->NOMBRES_DOC])
                ->andFilterWhere(['like', 'APELLIDOS_DOC', $this->APELLIDOS_DOC])
                ->andFilterWhere(['like', 'TITULO_DOC', $this->TITULO_DOC])
                ->andFilterWhere(['like', 'CELULAR_DOC', $this->CELULAR_DOC])
                ->andFilterWhere(['like', 'CORREO_DOC', $this->CORREO_DOC])
                ->andFilterWhere(['like', 'LINK_PAG_DOC', $this->LINK_PAG_DOC])
                ->andFilterWhere(['like', 'ESTADO_DOC', $this->ESTADO_DOC])
                ->andFilterWhere(['!=', 'ESTADO_DOC', $id]);

        return $dataProvider;
    }

}
