<?php echo trim($siteData->globalDatas['view::View_Shop_Good\-marathon-marafon']); ?>
<header class="header-comment header-center">
    <div class="container">
        <div class="line-green"></div>
        <h2>Отзывы <span>клиентов</span></h2>
        <div id="comments-carousel" class="carousel slide carousel-green" data-ride="carousel" data-interval="10000">
            <div class="carousel-inner">
                <?php echo trim($siteData->globalDatas['view::View_Shop_Comments\-articles-otzyvy']); ?>
            </div>
            <a class="left carousel-control" href="#comments-carousel" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Предыдущий</span>
            </a>
            <a class="right carousel-control" href="#comments-carousel" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Следующий</span>
            </a>
        </div>
    </div>
</header>
<header class="header-individually header-center">
    <div class="container">
        <div class="line-green"></div>
        <h2>Записаться <span>на первое бесплатное занятие</span></h2>
        <form class="box-send" action="/command/subscribe_add" method="post">
            <div class="row">
                <div class="col-md-3">
                    <div class="input-group">
                        <input class="form-control input-meditation" name="name" type="text" placeholder="Ваше имя">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <input class="form-control input-meditation" name="email" type="email" placeholder="E-mail">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <input class="form-control input-meditation" name="options[phone]" type="text" placeholder="Номер телефона">
                    </div>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-flat btn-green" type="submit">Отправить заявку</button>
                </div>
                <input name="type" value="23" style="display:none">
                <input name="is_not_captcha_hash" value="1" style="display:none">
                <input name="url" value="/marathon-send" style="display:none">
            </div>
        </form>
        <p class="text-center">Оставьте заявку и мы свяжемся с Вами в ближайщее время</p>
    </div>
</header>