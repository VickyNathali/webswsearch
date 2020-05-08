<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "periodo_academico".
 *
 * @property int $ID_PER
 * @property string $INICIO_PER
 * @property string $FIN_PER
 * @property string $OBSERVACIONES_PER
 * @property int $ESTADO_PER
 *
 * @property CarsemAsigPer[] $carsemAsigPers
 */
class PeriodoAcademico extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'periodo_academico';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['INICIO_PER', 'FIN_PER','ESTADO_PER'], 'required'],
           // [['INICIO_PER', 'FIN_PER'], 'safe'], en caso de q sea date en la bd
            [['ESTADO_PER'], 'integer'],
            [['INICIO_PER', 'FIN_PER'], 'string', 'max' => 70],
            [['OBSERVACIONES_PER'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID_PER' => 'Id ',
            'INICIO_PER' => 'Fecha de inicio',
            'FIN_PER' => 'Fecha de fin',
            'OBSERVACIONES_PER' => 'Observaciones',
            'ESTADO_PER' => 'Estado ',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarsemAsigPers()
    {
        return $this->hasMany(CarsemAsigPer::className(), ['ID_PER' => 'ID_PER']);
    }
}
