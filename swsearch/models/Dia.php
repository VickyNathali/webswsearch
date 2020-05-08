<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dia".
 *
 * @property int $ID_DIA
 * @property string $DESCRIPCION_DIA
 *
 * @property DiaAulaHora[] $diaAulaHoras
 */
class Dia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['DESCRIPCION_DIA'], 'required'],
            [['DESCRIPCION_DIA'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID_DIA' => 'Id ',
            'DESCRIPCION_DIA' => 'Descripcion ',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiaAulaHoras()
    {
        return $this->hasMany(DiaAulaHora::className(), ['ID_DIA' => 'ID_DIA']);
    }
}
