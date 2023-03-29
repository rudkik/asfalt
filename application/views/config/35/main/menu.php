<li <?php if(strpos($siteData->url, '/shopbill/')){echo 'class="active"';}?>>
    <a href="<?php echo $siteData->urlBasic; ?>/config/shopbill/index">
        <i class="fa fa-pagelines fa-fw">
            <div class="icon-bg bg-green"></div>
        </i>
        <span class="menu-title">Заказы</span>
        <span class="fa arrow"></span>
    </a>
    <ul class="nav nav-second-level">
        <li <?php if(strpos($siteData->url, '/mvc/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/config/mvc/index"><span class="submenu-title">Создание MVC</span></a></li>
    </ul>
</li>
