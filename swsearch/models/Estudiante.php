<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estudiante".
 *
 * @property string $CEDULA_PER
 * @property int $ID_CAR
 *
 * @property Carrera $cAR
 * @property Persona $cEDULAPER
 */
class Estudiante extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estudiante';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CEDULA_PER', 'ID_CAR'], 'required'],
            [['ID_CAR'], 'integer'],
            [['CEDULA_PER'], 'string', 'max' => 10],
            [['CEDULA_PER'], 'unique'],
            [['ID_CAR'], 'exist', 'skipOnError' => true, 'targetClass' => Carrera::className(), 'targetAttribute' => ['ID_CAR' => 'ID_CAR']],
            [['CEDULA_PER'], 'exist', 'skipOnError' => true, 'targetClass' => Persona::className(), 'targetAttribute' => ['CEDULA_PER' => 'CEDULA_PER']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CEDULA_PER' => 'Cédula',
            'ID_CAR' => 'Carrera',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCAR()
    {
        return $this->hasOne(Carrera::className(), ['ID_CAR' => 'ID_CAR']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCEDULAPER()
    {
        return $this->hasOne(Persona::className(), ['CEDULA_PER' => 'CEDULA_PER']);
    }
}
