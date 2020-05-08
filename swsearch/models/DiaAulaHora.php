<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dia_aula_hora".
 *
 * @property string $CODIGO_ASIG
 * @property int $ID_PER
 * @property string $CEDULA_DOC
 * @property int $ID_HORA
 * @property int $ID_DIA
 * @property int $ID_AUL
 * @property string $PARALELO
 * @property int $ID_CAR
 * @property int $ID_SEM
 * @property string $OBSERVACIONES_DAH
 *
 * @property AsigDocPer $cODIGOASIG
 * @property AulaLaboratorio $aUL
 * @property Dia $dIA
 * @property Hora $hORA
 */
class DiaAulaHora extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dia_aula_hora';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CODIGO_ASIG', 'ID_PER', 'CEDULA_DOC', 'ID_HORA', 'ID_DIA', 'ID_AUL', 'PARALELO', 'ID_CAR', 'ID_SEM'], 'required'],
            [['ID_PER', 'ID_HORA', 'ID_DIA', 'ID_AUL', 'ID_CAR', 'ID_SEM'], 'integer'],
            [['CODIGO_ASIG'], 'string', 'max' => 9],
            [['CEDULA_DOC'], 'string', 'max' => 10],
            [['PARALELO'], 'string', 'max' => 1],
            [['CODIGO_ASIG', 'ID_PER', 'CEDULA_DOC', 'ID_HORA', 'ID_DIA', 'ID_AUL', 'PARALELO', 'ID_CAR', 'ID_SEM'], 'unique', 'targetAttribute' => ['CODIGO_ASIG', 'ID_PER', 'CEDULA_DOC', 'ID_HORA', 'ID_DIA', 'ID_AUL', 'PARALELO', 'ID_CAR', 'ID_SEM']],
            [['CODIGO_ASIG', 'ID_PER', 'CEDULA_DOC', 'PARALELO', 'ID_CAR', 'ID_SEM'], 'exist', 'skipOnError' => true, 'targetClass' => AsigDocPer::className(), 'targetAttribute' => ['CODIGO_ASIG' => 'CODIGO_ASIG', 'ID_PER' => 'ID_PER', 'CEDULA_DOC' => 'CEDULA_DOC', 'PARALELO' => 'PARALELO', 'ID_CAR' => 'ID_CAR', 'ID_SEM' => 'ID_SEM']],
            [['ID_AUL'], 'exist', 'skipOnError' => true, 'targetClass' => AulaLaboratorio::className(), 'targetAttribute' => ['ID_AUL' => 'ID_AUL']],
            [['ID_DIA'], 'exist', 'skipOnError' => true, 'targetClass' => Dia::className(), 'targetAttribute' => ['ID_DIA' => 'ID_DIA']],
            [['ID_HORA'], 'exist', 'skipOnError' => true, 'targetClass' => Hora::className(), 'targetAttribute' => ['ID_HORA' => 'ID_HORA']],
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
            'ID_HORA' => 'Hora',
            'ID_DIA' => 'Dia',
            'ID_AUL' => 'Aula o laboratorio',
            'PARALELO' => 'Paralelo',
            'ID_CAR' => 'Carrera',
            'ID_SEM' => 'Semestre',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCODIGOASIG()
    {
        return $this->hasOne(AsigDocPer::className(), ['CODIGO_ASIG' => 'CODIGO_ASIG', 'ID_PER' => 'ID_PER', 'CEDULA_DOC' => 'CEDULA_DOC', 'PARALELO' => 'PARALELO', 'ID_CAR' => 'ID_CAR', 'ID_SEM' => 'ID_SEM']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAUL()
    {
        return $this->hasOne(AulaLaboratorio::className(), ['ID_AUL' => 'ID_AUL']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDIA()
    {
        return $this->hasOne(Dia::className(), ['ID_DIA' => 'ID_DIA']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHORA()
    {
        return $this->hasOne(Hora::className(), ['ID_HORA' => 'ID_HORA']);
    }
}
