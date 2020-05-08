<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "asig_doc_per".
 *
 * @property string $CODIGO_ASIG
 * @property int $ID_PER
 * @property string $CEDULA_DOC
 * @property string $PARALELO
 * @property int $ID_CAR
 * @property int $ID_SEM
 *
 * @property CarsemAsigPer $cAR
 * @property Docente $cEDULADOC
 * @property DiaAulaHora[] $diaAulaHoras
 */
class AsigDocPer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'asig_doc_per';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CODIGO_ASIG', 'ID_PER', 'CEDULA_DOC', 'PARALELO', 'ID_CAR', 'ID_SEM'], 'required'],
            [['ID_PER', 'ID_CAR', 'ID_SEM'], 'integer'],
            [['CODIGO_ASIG'], 'string', 'max' => 9],
            [['CEDULA_DOC'], 'string', 'max' => 10],
            [['PARALELO'], 'string', 'max' => 1],
            [['CODIGO_ASIG', 'ID_PER', 'CEDULA_DOC', 'PARALELO', 'ID_CAR', 'ID_SEM'], 'unique', 'targetAttribute' => ['CODIGO_ASIG', 'ID_PER', 'CEDULA_DOC', 'PARALELO', 'ID_CAR', 'ID_SEM']],
            [['ID_CAR', 'ID_SEM', 'CODIGO_ASIG', 'ID_PER'], 'exist', 'skipOnError' => true, 'targetClass' => CarsemAsigPer::className(), 'targetAttribute' => ['ID_CAR' => 'ID_CAR', 'ID_SEM' => 'ID_SEM', 'CODIGO_ASIG' => 'CODIGO_ASIG', 'ID_PER' => 'ID_PER']],
            [['CEDULA_DOC'], 'exist', 'skipOnError' => true, 'targetClass' => Docente::className(), 'targetAttribute' => ['CEDULA_DOC' => 'CEDULA_DOC']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CODIGO_ASIG' => 'Asignatura',
            'ID_PER' => 'Período académico',
            'CEDULA_DOC' => 'Docente',
            'PARALELO' => 'Paralelo',
            'ID_CAR' => 'Carrera',
            'ID_SEM' => 'Semstre',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCAR()
    {
        return $this->hasOne(CarsemAsigPer::className(), ['ID_CAR' => 'ID_CAR', 'ID_SEM' => 'ID_SEM', 'CODIGO_ASIG' => 'CODIGO_ASIG', 'ID_PER' => 'ID_PER']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCEDULADOC()
    {
        return $this->hasOne(Docente::className(), ['CEDULA_DOC' => 'CEDULA_DOC']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiaAulaHoras()
    {
        return $this->hasMany(DiaAulaHora::className(), ['CODIGO_ASIG' => 'CODIGO_ASIG', 'ID_PER' => 'ID_PER', 'CEDULA_DOC' => 'CEDULA_DOC', 'PARALELO' => 'PARALELO', 'ID_CAR' => 'ID_CAR', 'ID_SEM' => 'ID_SEM']);
    }
}
