<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "semestre".
 *
 * @property int $ID_SEM
 * @property string $DESCRIPCION_SEM
 * @property int $ESTADO_SEM
 *
 * @property CarreraSemestre[] $carreraSemestres
 * @property Carrera[] $cARs
 */
class Semestre extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'semestre';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['DESCRIPCION_SEM','ESTADO_SEM'], 'required'],
            [['ESTADO_SEM'], 'integer'],
            [['DESCRIPCION_SEM'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID_SEM' => 'Id ',
            'DESCRIPCION_SEM' => 'Descripción',
            'ESTADO_SEM' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarreraSemestres()
    {
        return $this->hasMany(CarreraSemestre::className(), ['ID_SEM' => 'ID_SEM']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCARs()
    {
        return $this->hasMany(Carrera::className(), ['ID_CAR' => 'ID_CAR'])->viaTable('carrera_semestre', ['ID_SEM' => 'ID_SEM']);
    }
}
