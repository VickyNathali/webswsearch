<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "aula_laboratorio".
 *
 * @property int $ID_AUL
 * @property string $NOMBRE_AUL
 * @property string $LATITUD_AUL
 * @property string $LONGITUD_AUL
 * @property string $FOTO_AUL
 * @property string $OBSERVACIONES_AUL
 * @property int $ESTADO_AUL
 *
 * @property DiaAulaHora[] $diaAulaHoras
 */
class AulaLaboratorio extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'aula_laboratorio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['NOMBRE_AUL', 'LATITUD_AUL', 'LONGITUD_AUL','ESTADO_AUL'], 'required'],
            [['FOTO_AUL'], 'file','extensions'=>'jpg,png,jpeg,gif'],
            [['ESTADO_AUL'], 'integer'],
            [['NOMBRE_AUL'], 'string', 'max' => 50],
            [['LATITUD_AUL', 'LONGITUD_AUL'], 'string', 'max' => 20],
            [['OBSERVACIONES_AUL'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID_AUL' => 'Id',
            'NOMBRE_AUL' => 'Nombre',
            'LATITUD_AUL' => 'Latitud',
            'LONGITUD_AUL' => 'Longitud',
            'FOTO_AUL' => 'Foto',
            'OBSERVACIONES_AUL' => 'Observaciones',
            'ESTADO_AUL' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiaAulaHoras()
    {
        return $this->hasMany(DiaAulaHora::className(), ['ID_AUL' => 'ID_AUL']);
    }
}
