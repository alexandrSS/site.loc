<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\modules\user\models\User;


class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        //  Backend application  //

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

        // add Pages [category controller] modules permission
        $indexCategory = $auth->createPermission('indexCategory');
        $indexCategory->description = 'List Category and Errors';
        $auth->add($indexCategory);
        $auth->add($indexUser);

        $viewCategory = $auth->createPermission('viewCategory');
        $viewCategory->description = 'Categorys viewing';
        $auth->add($viewCategory);

        $createCategory = $auth->createPermission('createCategory');
        $createCategory->description = 'Create a Category';
        $auth->add($createCategory);

        $updateCategory = $auth->createPermission('updateCategory');
        $updateCategory->description = 'Update Category';
        $auth->add($updateCategory);

        $deleteCategory = $auth->createPermission('deleteCategory');
        $deleteCategory->description = 'Delete Category';
        $auth->add($deleteCategory);

        // add Pages [page controller] modules permission
        $indexPage = $auth->createPermission('indexPage');
        $indexPage->description = 'List Page and Errors';
        $auth->add($indexPage);
        $auth->add($indexUser);

        $viewPage = $auth->createPermission('viewPage');
        $viewPage->description = 'Pages viewing';
        $auth->add($viewPage);

        $createPage = $auth->createPermission('createPage');
        $createPage->description = 'Create a Page';
        $auth->add($createPage);

        $updatePage = $auth->createPermission('updatePage');
        $updatePage->description = 'Update Page';
        $auth->add($updatePage);

        $deletePage = $auth->createPermission('deletePage');
        $deletePage->description = 'Delete Page';
        $auth->add($deletePage);

        // Rules  //////////////////////////////////////////////////////////////////////////////////////////////////////
        $groupRule = new GroupRule();

        $auth->add($groupRule);

        // Add Roles ///////////////////////////////////////////////////////////////////////////////////////////////////

        // User
        $user = $auth->createRole(User::ROLE_USER);
        $user->description = 'User';
        $user->ruleName = $groupRule->name;
        $auth->add($user);


        // Moderator
        $moderator = $auth->createRole(User::ROLE_MODERATOR);
        $moderator->description = 'Moderator';
        $moderator->ruleName = $groupRule->name;
        $auth->add($moderator);
        $auth->addChild($moderator, $user);
        $auth->addChild($moderator, $BackendController);
        $auth->addChild($moderator, $indexAdmin);
        $auth->addChild($moderator, $indexUser);
        $auth->addChild($moderator, $viewUser);
        $auth->addChild($moderator, $createUser);
        $auth->addChild($moderator, $updateUser);
        $auth->addChild($moderator, $indexCategory);
        $auth->addChild($moderator, $viewCategory);
        $auth->addChild($moderator, $createCategory);
        $auth->addChild($moderator, $updateCategory);
        $auth->addChild($moderator, $indexPage);
        $auth->addChild($moderator, $viewPage);
        $auth->addChild($moderator, $createPage);
        $auth->addChild($moderator, $updatePage);

        // Administrator
        $admin = $auth->createRole(User::ROLE_ADMIN);
        $admin->description = 'Administrator';
        $admin->ruleName = $groupRule->name;
        $auth->add($admin);
        $auth->addChild($admin, $moderator);
        $auth->addChild($admin, $deleteUser);
        $auth->addChild($admin, $deleteCategory);
        $auth->addChild($admin, $deletePage);

        // Super Administrator
        $superAdmin = $auth->createRole(User::ROLE_SUPERADMIN);
        $superAdmin->description = 'Super Administrator';
        $superAdmin->ruleName = $groupRule->name;
        $auth->add($superAdmin);
        $auth->addChild($superAdmin, $admin);


    }
}