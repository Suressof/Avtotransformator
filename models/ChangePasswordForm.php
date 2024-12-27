<?php
namespace app\models;

use yii\base\Model;

class ChangePasswordForm extends Model
{
    public $currentPassword;
    public $newPassword;
    public $confirmNewPassword;

    public function rules()
    {
        return [
            // [['currentPassword', 'newPassword', 'confirmNewPassword'], 'required'],
            // ['currentPassword', 'validateCurrentPassword'],
            ['newPassword', 'string', 'min' => 6],
            ['confirmNewPassword', 'compare', 'compareAttribute' => 'newPassword', 'message' => 'Пароли не совпадают.'],
        ];
    }

    public function validateCurrentPassword($attribute, $params)
    {
        $user = \Yii::$app->user->identity;

        if (!$user || !$user->validatePassword($this->$attribute)) {
            $this->addError($attribute, 'Неверный текущий пароль.');
        }
    }
}
