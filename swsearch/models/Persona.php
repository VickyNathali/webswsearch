<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "persona".
 *
 * @property string $CEDULA_PER
 * @property string $NOMBRES_PER
 * @property string $APELLIDOS_PER
 * @property string $USUARIO_PER
 * @property string $CONTRASENA_PER
 * @property string $FOTO_PER
 * @property int $TOKEN_PER
 *
 * @property Estudiante $estudiante
 * @property Administrador $cEDULAPER
 */
class Persona extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'persona';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CEDULA_PER', 'NOMBRES_PER', 'APELLIDOS_PER', 'USUARIO_PER','CONTRASENA_PER'], 'required'],
            [['FOTO_PER'], 'file','extensions'=>'jpg,png,jpeg'],
            [['CEDULA_PER'], 'string', 'max' => 10],
            [['TOKEN_PER'], 'string', 'max' => 50],
            [['USUARIO_PER'], 'string', 'length' => [4, 30]],
            [['CONTRASENA_PER'], 'string', 'length' => [6, 30]],
            [['NOMBRES_PER', 'APELLIDOS_PER'], 'string', 'max' => 30],
            [['CEDULA_PER'], 'unique'],          
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CEDULA_PER' => 'Cédula',                    
            'NOMBRES_PER' => 'Nombres',
            'APELLIDOS_PER' => 'Apellidos',
            'USUARIO_PER' => 'Usuario',
            'CONTRASENA_PER' => 'Contraseña',
            'FOTO_PER' => 'Foto',
            'TOKEN_PER' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstudiante()
    {
        return $this->hasOne(Estudiante::className(), ['CEDULA_PER' => 'CEDULA_PER']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
        
     public function getAdministrador()
    {
        return $this->hasOne(Administrador::className(), ['CEDULA_USU' => 'CEDULA_USU']);
    }
    

}
