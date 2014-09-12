<?php
namespace frontend\modules\user\models;

use common\modules\user\models\User;
use yii\base\Model;
use Yii;

/**
 * Модель регистрации пользователей
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'match', 'pattern' => '/^[a-zA-Z0-9_-]+$/', 'message' => Yii::t(
                    'user', 'Логин может состоять из латинских символов [a-zA-z], цифр,
                    одинарного дефиса или подчеркивания.
                    Он должен содержать не менее 3 символов и не более 30 символов.'
                )],
            ['username', 'unique', 'targetClass' => '\common\modules\user\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\modules\user\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(){
        return [
            'username' => Yii::t('user', 'Логин'),
            'email' => Yii::t('user', 'E-mail (Электронная почта)'),
            'password' => Yii::t('user', 'Пароль'),
        ];
    }

    /**
     * Регистрация пользователя
     *
     * @return User|null сохранить модель или null при ошибке сохранения
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->save();
            return $user;
        }

        return null;
    }
}
