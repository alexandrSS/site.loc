<?php

namespace console\modules\rbac\rule;

use Yii;
use yii\rbac\Rule;

/**
 * User group rule class.
 */
class GroupRule extends Rule
{
    /**
     * @inheritdoc
     */
    public $name = 'group';

    /**
     * @inheritdoc
     */
    public function execute($user, $item, $params)
    {
        if (!Yii::$app->user->isGuest) {
            $role = Yii::$app->user->identity->role;

            if ($item->name === 2) {
                return $role === $item->name;
            } elseif ($item->name === 1) {
                return $role === $item->name || $role === 2;
            } elseif ($item->name === 3) {
                return $role === $item->name || $role === 2 || $role === 1;
            }
        }
        return false;
    }
}