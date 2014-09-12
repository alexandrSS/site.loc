<?php

namespace common\modules\user;

class User extends \yii\base\Module
{
    public $controllerNamespace = 'common\modules\user\controllers';

    /**
     * @var boolean Если данное значение false, пользователи при регистрации
     * должны будут подтверждать свои электронные адреса
     */
    public $activeAfterRegistration = false;

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
