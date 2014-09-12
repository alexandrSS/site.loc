<?php
/**
 * Theme main layout backend application.
 * @var \yii\web\View $this
 * @var string $content контент
 */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <?= $this->render('//layouts/head') ?>
    </head>
    <body class="skin-blue fixed">

    <?php $this->beginBody(); ?>
    <!-- header logo: style can be found in header.less -->
    <header class="header">
        <a href="<?= Yii::$app->homeUrl ?>" class="logo">
            <!-- Add the class icon to your logo image or logo icon to add the margining -->
            <?= Yii::$app->name ?>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <div class="navbar-right">
                <ul class="nav navbar-nav">
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="glyphicon glyphicon-user"></i>
                            <span><?= Yii::$app->user->identity->username ?><i class="caret"></i></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header bg-light-blue">
                                <img src="../../img/avatar3.png" class="img-circle" alt="User Image"/>

                                <p>
                                    Jane Doe - Web Developer
                                    <small>Member since Nov. 2012</small>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <?= Html::a(
                                        Yii::t('admin', 'Профиль'),
                                        ['/user/default/update', 'id' => Yii::$app->user->id],
                                        ['class' => 'btn btn-default btn-flat']
                                    ) ?>
                                </div>
                                <div class="pull-right">
                                    <?= Html::a(
                                        Yii::t('admin', 'Выйти'),
                                        ['/user/default/logout'],
                                        ['class' => 'btn btn-default btn-flat']
                                    ) ?>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <div class="wrapper row-offcanvas row-offcanvas-left">
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="left-side sidebar-offcanvas">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">

                <!-- sidebar menu: : style can be found in sidebar.less -->
                <?= $this->render('//layouts/sidebar-menu') ?>

            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Right side column. Contains the navbar and content of the page -->
        <aside class="right-side">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <?=
                Breadcrumbs::widget(
                    [
                        'homeLink' => [
                            'label' => '<i class="fa fa-home"></i> ' . Yii::t('admin', 'Главная'),
                            'url' => Yii::$app->homeUrl
                        ],
                        'encodeLabels' => false,
                        'tag' => 'ol',
                        'links' => $this->params['breadcrumbs']
                    ]
                ) ?>
            </section>

            <!-- Main content -->
            <section class="content">

                <!-- Control bar -->
                <?php if (isset($this->params['control'])) {
                    echo $this->render('//layouts/control-bar');
                } ?>
                <!--/ Control bar -->

                <section>
                    <?= $content ?>
                </section>

            </section>
            <!-- /.content -->
        </aside>
        <!-- /.right-side -->
    </div>
    <!-- ./wrapper -->

    <?php $this->endBody(); ?>
    </body>
</html>
<?php $this->endPage(); ?>