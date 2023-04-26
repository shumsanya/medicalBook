<?php
use yii\helpers\Url;
?>

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
