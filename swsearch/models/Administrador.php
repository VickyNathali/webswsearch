<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "administrador".
 *
 * @property string $CEDULA_PER
 * @property string $CARGO_ADM
 * @property string $TITULO_ADM
 *
 * @property Persona $persona
 */
class Administrador extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'administrador';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CEDULA_PER', 'CARGO_ADM', 'TITULO_ADM'], 'required'],
            [['CEDULA_PER'], 'string', 'max' => 10],
            [['CARGO_ADM', 'TITULO_ADM'], 'string', 'max' => 100],
            [['CEDULA_PER'], 'unique'],
            [['CEDULA_PER'], 'exist', 'skipOnError' => true, 'targetClass' => Persona::className(), 'targetAttribute' => ['CEDULA_PER' => 'CEDULA_PER']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CEDULA_PER' => 'Cedula',
            'CARGO_ADM' => 'Cargo ',
            'TITULO_ADM' => 'Título académico',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
     public function getCEDULAPER()
    {
        return $this->hasOne(Persona::className(), ['CEDULA_PER' => 'CEDULA_PER']);
    }
  
}
