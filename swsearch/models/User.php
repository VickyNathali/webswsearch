<?php

namespace app\models;
use Yii;

use yii\db\ActiveRecord;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Usuario;


class User extends ActiveRecord implements \yii\web\IdentityInterface {

    public static function tableName() {
        return 'persona';
    }

    /**
     * @inheritdoc
     */
    public function rules() {

        return [
            [['CEDULA_PER', 'NOMBRES_PER', 'APELLIDOS_PER', 'USUARIO_PER', 'CONTRASENA_PER'], 'required'],
            [['FOTO_PER'], 'file'],
            [['CEDULA_PER'], 'string', 'max' => 10],
            [['NOMBRES_PER', 'APELLIDOS_PER'], 'string', 'max' => 70],
            [['USUARIO_PER','TOKEN_PER'], 'string', 'max' => 30],
            [['TOKEN_PER'], 'string', 'max' => 50],
            [['CONTRASENA_PER'], 'string', 'max' => 30],
            [['CEDULA_PER'], 'unique'],
            
        ];
    }

    public static function findIdentity($id) {
        $user = self::find()
                ->where([
                    "CEDULA_PER" => $id
                ])
                ->one();
//    if (!count($user)) {
//        return null;
//    }
        return new static($user);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $userType = null) {

        $user = self::find()
                ->where(["accessToken" => $token])
                ->one();
        if (!count($user)) {
            return null;
        }
        return new static($user);
    }

    /**
     * Finds user by Usuario
     *
     * @param  string      $usuario
     * @return static|null
     */
    public static function findByUsuario($usuario) {
        $user = self::find()
                ->where([
                    "USUARIO_PER" => $usuario,
                        "TOKEN_PER"=>1
                ])
                ->one();
        //  $usua = Usuario::find()->where(['USUARIO_PER' => $usuario])->one();
        // var_dump($usua); exit();
//    if (!count($usua)) {
//        return null;
//    }
        return new static($user);
    }

    public static function findByUser($usuario) {
        $user = self::find()
                ->where([
                    "USUARIO_PER" => $usuario
                ])
                ->one();
        $user;
        if (!count($user)) {
            return null;
        }
        return $user;
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->CEDULA_PER;
    }

    /**
     * @inheritdoc
     */
    public function getClaveAutenticacion() {
        return $this->CONTRASENA_PER;
    }

    /**
     * @inheritdoc
     */
    public function validateClaveAutenticacion($clave_autenticacion) {
        return $this->CONTRASENA_PER === $clave_autenticacion;
    }

    /**
     * Validates clave
     *
     * @param  string  $clave clave to validate
     * @return boolean if clave provided is valid for current user
     */
    public function validateClave($clave) {
        return $this->CONTRASENA_PER === ($clave); //se quito md5 antes de clave xq ya no se está encriptando
    }

    public function getAuthKey() {
        return $this->CONTRASENA_PER;
    }

    public function validateAuthKey($authKey) {
        return $this->CONTRASENA_PER === $authKey;
    }

    public function validatePassword($password) {
        return $this->password === $password;
    }

}
