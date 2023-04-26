<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\helpers\Url;


AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="shortcut icon" href="<?php echo Yii::$app->request->baseUrl; ?>/favicon.png" type="image/x-icon" />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<div class="wrapper">
    <div class="sidebar" data ="blue">
        <!--
          Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red"
      -->
        <?php if (!Yii::$app->user->isGuest) { ?>

            <div class="sidebar-wrapper">
                <div class="logo">
                    <h4 >
                        Медецинская книга
                    </h4>
                </div>
                <ul class="nav">
                    <li class="active ">
                        <a href="<?= Url::to(['/user-params/view']); ?>">
                            <i class="tim-icons icon-chart-pie-36"></i>
                            <p>Измерения</p>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::to(['/personal-data/profile']); ?>">
                            <i class="tim-icons icon-single-02"></i>
                            <p>Профиль пользователя</p>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::to(['/visit/index']); ?>">
                            <i class="tim-icons icon-pin"></i>
                            <p>Визит к врачу</p>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::to(['/feelings/create']); ?>">
                            <i class="tim-icons icon-sound-wave"></i>
                            <p>Самочувствие</p>
                        </a>
                    </li>
                </ul>
            </div>
        <?php }
        else
        {
            include __DIR__ .'/../site/sidebar.php';
        } ?>
    </div>
    <div class="main-panel">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-absolute navbar-transparent">
            <div class="container-fluid">
                <div class="navbar-wrapper">
                    <div class="navbar-toggle d-inline">
                        <button type="button" class="navbar-toggler">
                            <span class="navbar-toggler-bar bar1"></span>
                            <span class="navbar-toggler-bar bar2"></span>
                            <span class="navbar-toggler-bar bar3"></span>
                        </button>
                    </div>
                    <a class="navbar-brand" href="<?= Url::home()?>">Medical book</a>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-bar navbar-kebab"></span>
                    <span class="navbar-toggler-bar navbar-kebab"></span>
                    <span class="navbar-toggler-bar navbar-kebab"></span>
                </button>
                <div class="collapse navbar-collapse" id="navigation">
                    <ul class="navbar-nav ml-auto">
                        <li class="search-bar input-group">
                            <button class="btn btn-link" id="search-button" data-toggle="modal" data-target="#searchModal"><i class="tim-icons icon-zoom-split" ></i>
                                <span class="d-lg-none d-md-block">Search</span>
                            </button>
                        </li>
                        <li class="dropdown nav-item">
                            <a href="javascript:void(0)" class="dropdown-toggle nav-link" data-toggle="dropdown">
                                <div class="notification d-none d-lg-block d-xl-block"></div>
                                <i class="tim-icons icon-sound-wave"></i>
                                <p class="d-lg-none">
                                    Notifications
                                </p>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right dropdown-navbar">
                                <li class="nav-link"><a href="#" class="nav-item dropdown-item">Mike John responded to your email</a></li>
                                <li class="nav-link"><a href="javascript:void(0)" class="nav-item dropdown-item">You have 5 more tasks</a></li>
                                <li class="nav-link"><a href="javascript:void(0)" class="nav-item dropdown-item">Your friend Michael is in town</a></li>
                                <li class="nav-link"><a href="javascript:void(0)" class="nav-item dropdown-item">Another notification</a></li>
                                <li class="nav-link"><a href="javascript:void(0)" class="nav-item dropdown-item">Another one</a></li>
                            </ul>
                        </li>
                        <li class="dropdown nav-item">
                            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                                <div class="photo">
                                    <?php
                                    $avatar = \app\models\PersonalData::getAvatar();
                                    if (Yii::$app->user->isGuest || !isset($avatar)){
                                        echo Html::img('@web/designCT/img/anime3.png', ['alt' => 'аватар']);
                                    }else{
                                        echo Html::img( $avatar->avatar , ['alt' => 'Ваш аватар']);
                                    }
                                    ?>
                                </div>
                                <b class="caret d-none d-lg-block d-xl-block"></b>
                                <p class="d-lg-none">
                                    Log out
                                </p>
                            </a>
                            <ul class="dropdown-menu dropdown-navbar">
                                <?php if (!Yii::$app->user->isGuest){ ?>
                                <li class="nav-link">
                                    <?= Html::a('Профиль', ['personal-data/profile', 'id' => Yii::$app->user->identity->getId()], ['class' => 'nav-item dropdown-item']) ?>
                                </li>
                                <li class="nav-link">
                                    <?= Html::a('Измерения', ['user-params/view', 'id' => Yii::$app->user->identity->getId()], ['class' => 'nav-item dropdown-item']) ?>
                                </li>
                                <li class="nav-link">
                                    <a href="javascript:void(0)" class="nav-item dropdown-item">Settings</a>
                                </li>
                                <li class="dropdown-divider"></li>
                                <li class="nav-link">
                                    <?php } ?>
                                    <?= Yii::$app->user->isGuest ?
                                        (
                                        Html::a('Войти', ['/site/login'], ['class' => 'profile-link btn-link'])
                                        )
                                        :
                                        (
                                            '<li>'
                                            . Html::beginForm(['/site/logout'], 'post', ['class' => 'nav-item dropdown-item'])
                                            . Html::submitButton(
                                                'Выйти (' . Yii::$app->user->identity->username . ')',
                                                ['class' => 'btn btn-link nav-item dropdown-item']
                                            )
                                            . Html::endForm()
                                            . '</li>'
                                        ) ?>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <?php
                            if ( Yii::$app->user->isGuest){
                                echo ( Html::a('Регистрация', ['/site/signup'], ['class' => 'btn-link profile-link']).' ' );
                                echo ( ' '.Html::a('Войти', ['/site/login'], ['class' => 'btn-link']) );
                            }
                            ?>
                        </li>
                        <li class="separator d-lg-none"></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="modal modal-search fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="SEARCH">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="tim-icons icon-simple-remove"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Navbar -->

        <div class="content">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>

            <?= $content ?>
        </div>


        <footer class="footer mt-auto py-3 text-muted">
            <div class="container">
                <p class="float-left">&copy; My Company </p>
                <p class="float-right"><?= Yii::powered() ?></p>
            </div>
        </footer>
        <!-- Fixed side setting menu -->
        <div class="fixed-plugin">
            <div class="dropdown show-dropdown">
                <a href="#" data-toggle="dropdown">
                    <i class="fa fa-cog fa-2x"> </i>
                </a>
                <ul class="dropdown-menu">
                    <li class="header-title"> Sidebar Background</li>
                    <li class="adjustments-line">
                        <a href="javascript:void(0)" class="switch-trigger background-color">
                            <div class="badge-colors text-center">
                                <span class="badge filter badge-primary active" data-color="primary"></span>
                                <span class="badge filter badge-info" data-color="blue"></span>
                                <span class="badge filter badge-success" data-color="green"></span>
                            </div>
                            <div class="clearfix"></div>
                        </a>
                    </li>
                    <li class="adjustments-line text-center color-change">
                        <span class="color-label">LIGHT MODE</span>
                        <span class="badge light-badge mr-2"></span>
                        <span class="badge dark-badge ml-2"></span>
                        <span class="color-label">DARK MODE</span>
                    </li>
                </ul>
            </div>
        </div>
        <!-- AND fixed menu -->
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

<?php
$this->endBody();

// настройки, внешнего вида, пользователя
include __DIR__ . '/../../sessions.php';
?>
</body>
</html>
<?php $this->endPage() ?>


