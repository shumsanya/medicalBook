<?php
use app\models\SettingsUser;

$session = Yii::$app->session;
$sidebar_color = '';
$background_color = '';

// проверяем открыта ли сессия
    if (!$session->isActive)
        {
            // открываем сессию
            $session->open();
        }

    if (Yii::$app->user->isGuest || SettingsUser::noSettings(Yii::$app->user->id))
        {
            if (isset($_SESSION['user']))
                {
                    $sidebar_color = $_SESSION['sidebar_color'];
                    $background_color = $_SESSION['background_color'];
                }
        }
    else
        {
            $_SESSION['user'] = Yii::$app->user->id;
            $sidebar_color = SettingsUser::getSidebarColor(Yii::$app->user->id);
            $background_color = SettingsUser::getBackgroundColor(Yii::$app->user->id);
        }
?>

<script>

// задать цвет фона для сайтбара
   if (<?php echo json_encode($sidebar_color) ?> )
   {
       $('.sidebar').attr('data', <?php echo json_encode($sidebar_color) ?>);
       $('.main_panel').attr('data', <?php echo json_encode($sidebar_color) ?>);
       $('body > .navbar-collapse').attr('data', <?php echo json_encode($sidebar_color) ?>);
   }

// задать цвет фона для сайта
   if (<?php echo json_encode($background_color) ?> === 'white-content' )
   {
       $('body').addClass('white-content');
   }
   else
    {
        $('body').removeClass('white-content');
    }

</script>
