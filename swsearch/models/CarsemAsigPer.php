<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "carsem_asig_per".
 *
 * @property int $ID_CAR
 * @property int $ID_SEM
 * @property string $CODIGO_ASIG
 * @property int $ID_PER
 * @property int $ESTADO_CSAP
 *
 * @property AsigDocPer[] $asigDocPers
 * @property Asignatura $cODIGOASIG
 * @property CarreraSemestre $sEM
 * @property PeriodoAcademico $pER
 */
class CarsemAsigPer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carsem_asig_per';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID_CAR', 'ID_SEM', 'ID_PER','ESTADO_CSAP'], 'required'],
            [['ID_CAR', 'ID_SEM', 'ID_PER', 'ESTADO_CSAP'], 'integer'],
            [['CODIGO_ASIG'], 'string', 'max' => 9],
            [['ID_CAR', 'ID_SEM', 'CODIGO_ASIG', 'ID_PER'], 'unique', 'targetAttribute' => ['ID_CAR', 'ID_SEM', 'CODIGO_ASIG', 'ID_PER']],
            [['CODIGO_ASIG'], 'exist', 'skipOnError' => true, 'targetClass' => Asignatura::className(), 'targetAttribute' => ['CODIGO_ASIG' => 'CODIGO_ASIG']],
            [['ID_SEM', 'ID_CAR'], 'exist', 'skipOnError' => true, 'targetClass' => CarreraSemestre::className(), 'targetAttribute' => ['ID_SEM' => 'ID_SEM', 'ID_CAR' => 'ID_CAR']],
            [['ID_PER'], 'exist', 'skipOnError' => true, 'targetClass' => PeriodoAcademico::className(), 'targetAttribute' => ['ID_PER' => 'ID_PER']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
           'ID_CAR' => 'Carrera',
            'ID_SEM' => 'Nivel',
            'CODIGO_ASIG' => 'Asignatura',
            'ID_PER' => 'Período académico',
            'ESTADO_CSAP' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsigDocPers()
    {
        return $this->hasMany(AsigDocPer::className(), ['ID_CAR' => 'ID_CAR', 'ID_SEM' => 'ID_SEM', 'CODIGO_ASIG' => 'CODIGO_ASIG', 'ID_PER' => 'ID_PER']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCODIGOASIG()
    {
        return $this->hasOne(Asignatura::className(), ['CODIGO_ASIG' => 'CODIGO_ASIG']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSEM()
    {
        return $this->hasOne(CarreraSemestre::className(), ['ID_SEM' => 'ID_SEM', 'ID_CAR' => 'ID_CAR']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPER()
    {
        return $this->hasOne(PeriodoAcademico::className(), ['ID_PER' => 'ID_PER']);
    }
}
