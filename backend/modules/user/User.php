<?php

namespace backend\modules\user;

use Yii;
use yii\base\Module;

class User extends Module
{
    public $controllerNamespace = 'backend\modules\user\controllers';

    /**
     * @var integer Количество записей на главной странице модуля.
     */
    public $recordsPerPage = 18;

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
