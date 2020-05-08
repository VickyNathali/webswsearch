<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "carrera".
 *
 * @property int $ID_CAR
 * @property string $NOMBRE_CAR
 * @property string $DIRECTOR_CAR
 * @property int $DURACION_CAR
 * @property string $TITULO_OBT_CAR
 * @property int $ESTADO_CAR
 *
 * @property CarreraSemestre[] $carreraSemestres
 * @property Semestre[] $sEMs
 * @property Estudiante[] $estudiantes
 */
class Carrera extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carrera';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['NOMBRE_CAR', 'DIRECTOR_CAR', 'DURACION_CAR', 'TITULO_OBT_CAR','ESTADO_CAR'], 'required'],
            [['DURACION_CAR', 'ESTADO_CAR'], 'integer'],
            [['NOMBRE_CAR'], 'string', 'max' => 100],
            [['DIRECTOR_CAR'], 'string', 'max' => 60],
            [['TITULO_OBT_CAR'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID_CAR' => 'Código',
            'NOMBRE_CAR' => 'Nombre',
            'DIRECTOR_CAR' => 'Director',
            'DURACION_CAR' => 'Duración',
            'TITULO_OBT_CAR' => 'Título a obtener',
            'ESTADO_CAR' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarreraSemestres()
    {
        return $this->hasMany(CarreraSemestre::className(), ['ID_CAR' => 'ID_CAR']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSEMs()
    {
        return $this->hasMany(Semestre::className(), ['ID_SEM' => 'ID_SEM'])->viaTable('carrera_semestre', ['ID_CAR' => 'ID_CAR']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstudiantes()
    {
        return $this->hasMany(Estudiante::className(), ['ID_CAR' => 'ID_CAR']);
    }
}
