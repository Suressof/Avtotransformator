<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class RegForm extends User
{
    public $agree;
    public $passwordConfirm;
    // public $rememberMe = true;

    // private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['login', 'email', 'address', 'password', 'passwordConfirm', 'agree'], 'required', 'message' => 'Поле обязательно для заполнения'],
            ['login', 'match', 'pattern' => '/^[A-Za-z]{1,}$/u', 'message'=>'Только латинские символы'],
            ['login', 'unique', 'message'=>'Такой логин уже используется'],
            ['email', 'email', 'message'=>'Некорректный email'],
            ['passwordConfirm', 'compare', 'compareAttribute'=>'password', 'message'=>'Пароли не совпадают'],
            ['agree', 'boolean'],
            ['agree', 'compare', 'compareValue'=>true, 'message'=>'Необходимо согласие'],
            [['status'], 'integer'],
            [['login', 'email', 'password'], 'string', 'max' => 255],
        ];
    }

    /**
    * {@inheritdoc}
    */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Login',
            'password' => 'Password',
            'email' => 'Email',
            'address' => 'Address',
            'status' => 'Status',
            'agree' => 'Даю согласие на обработку',
            'passwordConfirm' => 'Подтверждение пароля',
        ];
    }

}
