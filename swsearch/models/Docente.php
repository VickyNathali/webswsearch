<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "docente".
 *
 * @property string $CEDULA_DOC
 * @property string $NOMBRES_DOC
 * @property string $APELLIDOS_DOC
 * @property string $TITULO_DOC
 * @property string $CELULAR_DOC
 * @property string $CORREO_DOC
 * @property string $LINK_PAG_DOC
 * @property int $ESTADO_DOC
 *
 * @property AsigDocPer[] $asigDocPers
 */
class Docente extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'docente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CEDULA_DOC', 'NOMBRES_DOC', 'APELLIDOS_DOC','ESTADO_DOC'], 'required'],
            [['ESTADO_DOC'], 'integer'],
            [['CEDULA_DOC', 'CELULAR_DOC'], 'string', 'max' => 10],
            [['NOMBRES_DOC', 'APELLIDOS_DOC'], 'string', 'max' => 30],
            [['TITULO_DOC'], 'string', 'max' => 200],
            [['CORREO_DOC'], 'string', 'max' => 50],
            [['LINK_PAG_DOC'], 'string', 'max' => 80],
            [['CEDULA_DOC'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CEDULA_DOC' => 'Cédula',
            'NOMBRES_DOC' => 'Nombres',
            'APELLIDOS_DOC' => 'Apellidos',
            'TITULO_DOC' => 'Título',
            'CELULAR_DOC' => 'Celular',
            'CORREO_DOC' => 'Correo',
            'LINK_PAG_DOC' => 'Link de página personal',
            'ESTADO_DOC' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsigDocPers()
    {
        return $this->hasMany(AsigDocPer::className(), ['CEDULA_DOC' => 'CEDULA_DOC']);
    }
}
