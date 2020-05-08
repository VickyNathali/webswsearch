<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "asignatura".
 *
 * @property string $CODIGO_ASIG
 * @property string $NOMBRE_ASIG
 * @property string $OBSERVACIONES_ASIG
 * @property int $ESTADO_ASIG
 *
 * @property CarsemAsigPer[] $carsemAsigPers
 */
class Asignatura extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'asignatura';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CODIGO_ASIG', 'NOMBRE_ASIG','ESTADO_ASIG'], 'required'],
            [['ESTADO_ASIG'], 'integer'],
            [['CODIGO_ASIG'], 'string', 'max' => 9],
            [['NOMBRE_ASIG','OBSERVACIONES_ASIG'], 'string', 'max' => 100],
            [['CODIGO_ASIG'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CODIGO_ASIG' => 'Código ',
            'NOMBRE_ASIG' => 'Nombre ',
            'OBSERVACIONES_ASIG' => 'Observaciones ',
            'ESTADO_ASIG' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarsemAsigPers()
    {
        return $this->hasMany(CarsemAsigPer::className(), ['CODIGO_ASIG' => 'CODIGO_ASIG']);
    }
}
