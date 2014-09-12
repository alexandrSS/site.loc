<?php

namespace frontend\modules\site\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, обязательны к заполнению
            [['name', 'email', 'subject', 'body'], 'required'],
            // email должен быть валидным E-mail
            ['email', 'email'],
            // [[verifyCode]] должен быть введен правильно
            ['verifyCode', 'captcha', 'captchaAction' => 'site/default/captcha']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('yii', 'ФИО'),
            'email' => Yii::t('yii', 'E-mail адрес'),
            'subject' => Yii::t('yii', 'Тема'),
            'body' => Yii::t('yii', 'Сообщение'),
            'verifyCode' => Yii::t('yii', 'Проверочный код'),
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param  string  $email the target email address
     * @return boolean whether the email was sent
     */
    public function sendEmail($email)
    {
        return Yii::$app->mail->compose()
            ->setTo($email)
            ->setFrom([$this->email => $this->name])
            ->setSubject($this->subject)
            ->setTextBody($this->body)
            ->send();
    }
}
