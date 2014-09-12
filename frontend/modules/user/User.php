<?php

namespace frontend\modules\user;

use Yii;
use common\extensions\consoleRunner\ConsoleRunner;

class User extends \common\modules\user\User
{
    public $controllerNamespace = 'frontend\modules\user\controllers';

    /**
     * Отправляем ключ активации учётной записи на указаный при регистарции e-mail.
     * Вызывается только если $this->activeAfterRegistration = false.
     * @param User $event
     * @return boolean
     */
    public function onSignup($event)
    {
        $model = $event->sender;
        $cr = new ConsoleRunner();
        return $cr->run('user/signup ' . $model['email'] . ' ' . $model['auth_key']);
    }

    /**
     * Данная функция срабатывает в момент повторной отправки кода активации, новому пользователю.
     * @param User $event
     * @return boolean
     */
    public function onResend($event)
    {
        $model = $event->sender;
        $cr = new ConsoleRunner();
        return $cr->run('user/resend ' . $model['email'] . ' ' . $model['auth_key']);
    }

    /**
     * Данная функция срабатывает в момент запроса восстановления пароля.
     * @param User $event
     * @return boolean
     */
    public function onRecoveryConfirm($event) {
        $model = $event->sender;
        $cr = new ConsoleRunner();
        return $cr->run('user/recovery-confirm ' . $model['email'] . ' ' . $model['auth_key']);
    }

    /**
     * Данная функция срабатывает в момент подтверждения запроса на восстановление пароля.
     * @param User $event
     * @return boolean
     */
    public function onRecoveryPassword($event) {
        $model = $event->sender;
        $cr = new ConsoleRunner();
        return $cr->run('user/recovery-password ' . $model['email'] . ' ' . $model['password']);
    }

    /**
     * Данная функция срабатывает в момент смены почтового адреса.
     * @param UserEmail $event
     * @return boolean
     */
    public function onEmailChange($event) {
        $model = $event->sender;
        $cr = new ConsoleRunner();
        return $cr->run('user/email ' . $model['email'] . ' ' . $model['token']);
    }
}
