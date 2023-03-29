<div class="col-auto order-1 order-xl-0">
    <nav class="nav" id="menu">
        <div class="nav__hamburger" onclick="menuToggle()">
            <span class="nav__hamburger__line"></span>
            <span class="nav__hamburger__line"></span>
            <span class="nav__hamburger__line"></span>
        </div>
        <ul class="nav__list nav__list--withhumb nav__list--right">
            <li class="nav__item">
                <a href="<?php echo $siteData->urlBasic;?>/#how-it-works" class="nav__link">Как это работает?</a>
            </li>
            <li class="nav__item">
                <a href="<?php echo $siteData->urlBasic;?>/#price" class="nav__link">Сколько стоит</a>
            </li>
            <li class="nav__item">
                <a href="<?php echo $siteData->urlBasic;?>/#form_new_address" class="nav__link">Регистрация</a>
            </li>
            <li class="nav__item">
                <a href="<?php echo $siteData->urlBasic;?>/#delivery" class="nav__link">Доставка</a>
            </li>
            <?php if($data->id == 0){ ?>
            <li class="nav__item">
	            <a href="<?php echo $siteData->urlBasic;?>/account/auth" class="btn btn--slim btn--p-little btn--invert btn--reg btn--noupper" style="background-color: transparent !important;">
	                Личный кабинет
	            </a>
            </li>
            <?php } ?>
            <hr class="d-xl-none" style="width: 180px;">

            <li class="nav__item--overlay" onclick="menuToggle()"></li>
        </ul>
    </nav>
</div>
</div>
<div class="row justify-content-end d-none d-xl-flex">
    <div class="col-auto">
<!--
        <div class="header__extra">
            <?php if($data->id > 0){ ?>
                <div class="login">
                    <a href="<?php echo $siteData->urlBasic;?>/account">
                        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/dist/img/icons/profile.svg" alt="">
                        <span>
                            <?php echo $data->values['name']; ?>
                        </span>
                    </a>
                    <a href="<?php echo $siteData->urlBasic;?>/user/unlogin">
                        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/dist/img/icons/exit.svg" alt="">
                        <span>
                            Выход
                        </span>
                    </a>
                </div>
            <?php }else{ ?>
            <a href="<?php echo $siteData->urlBasic;?>/account/auth" class="btn btn--slim btn--p-little btn--invert btn--reg btn--noupper">
                Личный кабинет
            </a>
            <?php } ?>
        </div>
-->
    </div>