<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "carrera_semestre".
 *
 * @property int $ID_SEM
 * @property int $ID_CAR
 * @property int $ESTADO_CARSEM
 *
 * @property Carrera $cAR
 * @property Semestre $sEM
 * @property CarsemAsigPer[] $carsemAsigPers
 */
class CarreraSemestre extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carrera_semestre';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID_SEM', 'ID_CAR','ESTADO_CARSEM'], 'required'],
            [['ID_SEM', 'ID_CAR', 'ESTADO_CARSEM'], 'integer'],
            [['ID_SEM', 'ID_CAR'], 'unique', 'targetAttribute' => ['ID_SEM', 'ID_CAR']],
            [['ID_CAR'], 'exist', 'skipOnError' => true, 'targetClass' => Carrera::className(), 'targetAttribute' => ['ID_CAR' => 'ID_CAR']],
            [['ID_SEM'], 'exist', 'skipOnError' => true, 'targetClass' => Semestre::className(), 'targetAttribute' => ['ID_SEM' => 'ID_SEM']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID_SEM' => 'Id Sem',
            'ID_CAR' => 'Id Car',
            'ESTADO_CARSEM' => 'Estado Carsem',
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
    public function getSEM()
    {
        return $this->hasOne(Semestre::className(), ['ID_SEM' => 'ID_SEM']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarsemAsigPers()
    {
        return $this->hasMany(CarsemAsigPer::className(), ['ID_SEM' => 'ID_SEM', 'ID_CAR' => 'ID_CAR']);
    }
}
