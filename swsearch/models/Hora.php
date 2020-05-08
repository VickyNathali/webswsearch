<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hora".
 *
 * @property int $ID_HORA
 * @property string $INICIO_HORA
 * @property string $FIN_HORA
 *
 * @property DiaAulaHora[] $diaAulaHoras
 */
class Hora extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hora';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['INICIO_HORA', 'FIN_HORA','ESTADO_HORA'], 'required'],
            [['INICIO_HORA', 'FIN_HORA'], 'safe'],
            [[ 'ESTADO_HORA'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID_HORA' => 'Id Hora',
            'INICIO_HORA' => 'Hora inicial',
            'FIN_HORA' => 'Hora final',
            'ESTADO_HORA' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiaAulaHoras()
    {
        return $this->hasMany(DiaAulaHora::className(), ['ID_HORA' => 'ID_HORA']);
    }
}
