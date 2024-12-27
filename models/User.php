<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "User".
 *
 * @property int $id
 * @property string|null $login
 * @property string|null $password
 * @property string|null $email
 * @property string|null $address
 * @property int|null $status
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $newPassword;
    public $confirmNewPassword;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'User';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['login'], 'string', 'max' => 20],
            [['password'], 'string', 'max' => 30],
            [['email'], 'string', 'max' => 50],
            [['address'], 'string', 'max' => 100],

            ['newPassword', 'string', 'min' => 6],
            ['confirmNewPassword', 'compare', 'compareAttribute' => 'newPassword', 'message' => 'Пароли не совпадают.'],
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
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord || $this->isAttributeChanged('password')) {
                $this->password = md5($this->password);
            }
            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return self::find()->where(['login'=>$username])->one();
    }

    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    public function generateEmailVerificationToken()
    {
        $token = Yii::$app->security->generateRandomString() . '_' . time();

        // Сохранение токена в сессии
        Yii::$app->session->set('emailVerificationToken', $token);

        return $token;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
}
