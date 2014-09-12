<?php
namespace common\modules\user\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Модель Пользователи [[User]]
 *
 * @property integer $id
 * @property string $username Логин
 * @property string $password_hash Хэш пароля
 * @property string $password_reset_token
 * @property string $email E-mail
 * @property string $auth_key Ключ активации
 * @property integer $role Роль
 * @property integer $status Статус пользователя
 * @property integer $created_at Дата регистрации
 * @property integer $updated_at Дата обновления
 *
 * @property string $password Пароль в чистом виде
 * @property string $repassword Повторный пароль
 */
class User extends ActiveRecord implements IdentityInterface
{

    /**
     *Статусы записей модели
     * -Неактивный
     * -Активный
     * -Забаненый
     * -Удаленный
     */
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_BANNED = 2;
    const STATUS_DELETED = 3;

    /**
     *Роли пользователей
     */
    const ROLE_USER = 0;
    const ROLE_ADMIN = 1;
    const ROLE_SUPERADMIN = 2;
    const ROLE_MODERATOR = 3;

    /**
     * Переменная используется для сбора пользовательской информации, но не сохраняется в базу.
     * @var string $password Пароль
     */
    public $password;

    /**
     * Переменная используется для сбора пользовательской информации, но не сохраняется в базу.
     * @var string $repassword Повторный пароль
     */
    public $repassword;

    /**
     * @var string Читабельная роль пользователя
     */
    protected $_role;

    /**
     * @var string Читабельный статус пользователя
     */
    protected $_status;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
      * @inheritdoc
      */
     public function rules()
     {
         return [
             // Логин [[username]]
             ['username', 'filter', 'filter' => 'trim', 'on' => ['signup', 'admin-update', 'admin-create']],
             ['username', 'required', 'on' => ['signup', 'admin-update', 'admin-create']],
             ['username', 'match', 'pattern' => '/^[a-zA-Z0-9_-]+$/',
                 'on' => ['signup', 'admin-update', 'admin-create'],
                 'message' => Yii::t('user', 'Логин может состоять из латинских символов [a-zA-z], цифр,
                    одинарного дефиса или подчеркивания.
                    Он должен содержать не менее 3 символов и не более 30 символов.'
                    ),
             ],
             ['username', 'string', 'min' => 3, 'max' => 30, 'on' => ['signup', 'admin-update', 'admin-create']],
             ['username', 'unique', 'on' => ['signup', 'admin-update', 'admin-create']],

             // E-mail [[email]]
             ['email', 'filter', 'filter' => 'trim', 'on' => ['signup', 'admin-create', 'admin-update']],
             ['email', 'required', 'on' => ['signup', 'admin-create', 'admin-update']],
             ['email', 'email', 'on' => ['signup', 'admin-create', 'admin-update']],
             ['email', 'string', 'max' => 100, 'on' => ['signup', 'admin-create', 'admin-update']],
             ['email', 'unique', 'on' => ['signup', 'admin-create', 'admin-update']],

             // Пароль [[password]]
             ['password', 'required', 'on' => ['signup', 'admin-create']],
             ['password', 'string', 'min' => 6, 'max' => 30, 'on' => ['signup', 'admin-create', 'admin-update']],

             // Подтверждение пароля [[repassword]]
             ['repassword', 'required', 'on' => ['signup', 'admin-create']],
             ['repassword', 'string', 'min' => 6, 'max' => 30, 'on' => ['signup', 'admin-create', 'admin-update']],
             ['repassword', 'compare', 'compareAttribute' => 'password', 'on' => ['signup', 'admin-create', 'admin-update']],
             ['repassword', 'compare', 'compareAttribute' => 'password', 'skipOnEmpty' => false, 'on' => ['admin-update']],

             // Роль [[role_id]]
             ['role', 'in', 'range' => array_keys(self::getRoleArray()), 'on' => ['admin-create', 'admin-update']],

             // Статус [[status_id]]
             ['status', 'in', 'range' => array_keys(self::getStatusArray()), 'on' => ['admin-create', 'admin-update']]
         ];
     }

    public function scenarios()
    {
        return [
            // Frontend scenarios
            'signup' => ['username', 'email', 'password', 'repassword'],
            'edit' => ['username', 'email'],

            // Backend scenarios
            'admin-create' => ['username', 'email', 'password', 'repassword', 'role', 'status'],
            'admin-update' => ['username', 'email', 'password', 'repassword', 'role', 'status'],
        ];
    }

    /**
     * @return array Массив доступных ролей пользователей
     */
    public static function getRoleArray()
    {
        return [
            self::ROLE_USER => Yii::t('user', 'Обычный пользователь'),
            self::ROLE_MODERATOR => Yii::t('user', 'Модератор'),
            self::ROLE_ADMIN => Yii::t('user', 'Админ'),
            self::ROLE_SUPERADMIN => Yii::t('user', 'Супер-Админ'),
        ];
    }

    /**
     * @return array Массив статуса пользователей
     */
    public static function getStatusArray()
    {
        return [
            self::STATUS_INACTIVE => Yii::t('user', 'Не активный'),
            self::STATUS_ACTIVE => Yii::t('user', 'Активный'),
            self::STATUS_BANNED => Yii::t('user', 'Забанен'),
        ];
    }

    /**
     * Выбор пользователя по [[id]]
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param  string      $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        $expire = \Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        if ($timestamp + $expire < time()) {
            // token expired
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * ID пользователя
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * Генирация ключа активации
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Читабельная роль пользователя
     * @return string
     */
    public function getRole()
    {
        if ($this->_role === null) {
            $roles = self::getRoleArray();
            $this->_role = $roles[$this->role];
        }
        return $this->_role;
    }

    /**
     * Читабельный статус пользователя
     * @return $this
     */
    public function getStatus()
    {
        if($this->_status === NULL){
            $status = self::getStatusArray();
            $this->_status = $status[$this->status];
        }
        return $this->_status;
    }

    /**
     * Валидация ключа авторизации
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Валидация пароля
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        //return Security::validatePassword($password, $this->password_hash);
        return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }


    /**
     * Генерация хэша пароля
     * @param $password
     * @return string
     */
    public function setPassword($password)
    {
        return $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        return $this->auth_key = Yii::$app->getSecurity()->generateRandomKey();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->getSecurity()->generateRandomKey() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function attributeLabels()
    {
        return [
            'username' => Yii::t('user', 'Логин'),
            'email' => Yii::t('user', 'E-mail'),
            'password' => Yii::t('user', 'Пароль'),
            'repassword' => Yii::t('user', 'Подтвердите пароль'),
            'role' => Yii::t('user', 'Роль'),
            'status' => Yii::t('user', 'Статус'),
            'created_at' => Yii::t('user', 'Дата регистрации'),
            'updated_at' => Yii::t('user', 'Дата обновления')
        ];
    }

    public function beforeSave($insert)
    {
        if(!parent::beforeSave($insert)){
            return false;
        }

        // Если новая запись
        if($this->isNewRecord){
            // Хешируем пароль
            if(!empty($this->password)){
                $this->password_hash = $this->setPassword($this->password);
            }
            // Генирируем уникальный ключ
            $this->auth_key = $this->generateAuthKey();

            // Регистрация
            if($this->scenario === 'signup'){
                $this->role = self::ROLE_USER ;
                if(Yii::$app->getModule('user')->activeAfterRegistration){
                    $this->status = self::STATUS_ACTIVE;
                }else{
                    $this->status = self::STATUS_INACTIVE;
                }
            }
        }

        return true;

    }

}
