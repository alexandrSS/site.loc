<?php

namespace console\modules\rbac\controllers;

use Yii;
use yii\console\Controller;
use console\modules\rbac\rule\GroupRule;


class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // master controller backend application
        $BackendController = $auth->createPermission('BackendController');
        $BackendController->description = 'Master controller backend application';
        $auth->add($BackendController);

        // add Admin modules permission
        $indexAdmin = $auth->createPermission('indexAdmin');
        $indexAdmin->description = 'Admin index';
        $auth->add($indexAdmin);

        // add User modules permission
        $indexUser = $auth->createPermission('indexUser');
        $indexUser->description = 'List Users and Errors';
        $auth->add($indexUser);

        $viewUser = $auth->createPermission('viewUser');
        $viewUser->description = 'Users viewing';
        $auth->add($viewUser);

        $createUser = $auth->createPermission('createUser');
        $createUser->description = 'Create a user';
        $auth->add($createUser);

        $updateUser = $auth->createPermission('updateUser');
        $updateUser->description = 'Update user';
        $auth->add($updateUser);

        $deleteUser = $auth->createPermission('deleteUser');
        $deleteUser->description = 'Delete user';
        $auth->add($deleteUser);

        // Rules
        $groupRule = new GroupRule();

        $auth->add($groupRule);

        // Add Roles

        // Moderator
        $moderator = $auth->createRole(3);
        $moderator->description = 'Moderator';
        $moderator->ruleName = $groupRule->name;
        $auth->add($moderator);
        $auth->addChild($moderator, $BackendController);
        $auth->addChild($moderator, $indexAdmin);
        $auth->addChild($moderator, $indexUser);
        $auth->addChild($moderator, $viewUser);
        $auth->addChild($moderator, $createUser);
        $auth->addChild($moderator, $updateUser);

        // Administrator
        $admin = $auth->createRole(1);
        $admin->description = 'Administrator';
        $admin->ruleName = $groupRule->name;
        $auth->add($admin);
        $auth->addChild($admin, $moderator);
        $auth->addChild($admin, $deleteUser);

        // Super Administrator
        $superAdmin = $auth->createRole(2);
        $superAdmin->description = 'Super Administrator';
        $superAdmin->ruleName = $groupRule->name;
        $auth->add($superAdmin);
        $auth->addChild($superAdmin, $admin);


    }
}