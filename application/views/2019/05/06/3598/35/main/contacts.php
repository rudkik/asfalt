<header class="header-breadcrumb">
    <div class="container">
        <h1>Контакты</h1>
        <div class="breadcrumbs">
            <a href="<?php echo $siteData->urlBasic;?>/">Главная</a> /
            <a class="active" href="<?php echo $siteData->urlBasic;?>/contacts">Контакты</a>
        </div>
    </div>
</header>
<header class="header-contact">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="box-contact-info">
                    <div class="line-green"></div>
                    <h2>Контакты</h2>
                    <div class="box-text">
                        Связаться с нами также можно в социальных сетях:
                    </div>
                    <div class="socials">
                        <?php echo trim($siteData->globalDatas['view::View_Shop_News\basic\sotcialnye-seti']); ?>
                    </div>
                    <div class="box-text">
                        Связаться с нами также можно в социальных сетях.
                        Связаться с нами также можно в социальных сетях.
                        Связаться с нами также можно в социальных сетях.
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box-contact">
                    <div class="logo">
                        <a href=""><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/logo.png"></a>
                    </div>
                    <div class="contacts">
                        <?php echo trim($siteData->globalDatas['view::View_Shop_AddressContacts\-contacts-kontakty']); ?>
                        <a href="" class="btn btn-flat btn-green">Оставить заявку</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<header class="header-homework header-center">
    <div class="container">
        <div class="line-green"></div>
        <h2>Отправить <span>подтверждение выполнения <br> домашнего задания</span></h2>
        <form class="box-send" action="post">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group input-group">
                        <input class="form-control input-meditation" name="name" value="" placeholder="Ваше имя">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group input-group">
                        <input class="form-control input-meditation" name="name" value="" placeholder="Номер телефона">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group input-group">
                        <textarea id="text" cols="40" rows="10" name="text" class="form-control input-meditation"></textarea>
                    </div>
                </div>
                <div class="col-md-8"></div>
                <div class="col-md-4">
                    <button class="btn btn-flat btn-green">Отправить заявку</button>
                </div>
            </div>
        </form>
    </div>
</header>