<header class="header-slider">
   <?php echo trim($siteData->globalDatas['view::View_Shop_News\-slaider-na-glavnoi']); ?>
</header>
<header class="header-department">
    <div class="container">
        <div class="row">
            <?php echo trim($siteData->globalDatas['view::View_Shop_News\-napravleniya']); ?>
        </div>
    </div>
</header>
<header class="header-about">
    <div class="container">
        <?php echo trim($siteData->globalDatas['view::View_Shop_News\-o-nashei-studii']); ?>
        <a href="<?php echo $siteData->urlBasic;?>/portfolio" class="btn btn-default btn-red">Посмотреть работы</a>
    </div>
</header>
<header class="header-send">
    <div class="container">
        <div class="box-left">
            <h2>Хотите сайт?</h2>
            <p class="info">Закажите сейчас и получите скидку <span class="blue-circle">30%</span> на услугу</p>
        </div>
        <div class="box-send ">
            <input type="text" class="form-control" placeholder="Телефон">
            <button type="button" class="btn btn-default btn-white">Заказать</button>
        </div>
    </div>
</header>
<header class="header-work">
    <div class="container">
        <h2>Как мы работаем?</h2>
        <div class="row">
            <?php echo trim($siteData->globalDatas['view::View_Shop_News\-kak-my-rabotaem']); ?>
        </div>
    </div>
</header>
<header class="header-articles">
    <div class="container">
        <h2>Последние статьи</h2>
        <div class="row">
            <?php echo trim($siteData->globalDatas['view::View_Shop_News\-stati']); ?>
        </div>
    </div>
</header>