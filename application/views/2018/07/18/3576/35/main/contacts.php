<header class="header-message">
    <div class="container">
        <h1>Остались вопросы?</h1>
        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png">
        <p>Оставьте Ваш номер, и мы Вам позвоним</p>
        <form class="reservation" action="/command/message_add" method="post">
            <div class="row">
                <div class="col-sm-4">
                    <div class="input-group">
                        <input class="form-control input-transparent" name="name" value="" placeholder="Ваше имя">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input class="form-control input-transparent" name="options['phone']" value="" placeholder="Номер телефона">
                    </div>
                </div>
                <div class="col-sm-4">
                    <input name="text" value="Клиент сделал заявку на выписку счета" hidden="">
                    <input name="type" value="5308" hidden="">
                    <input name="url" value="<?php echo $siteData->urlBasicLanguage; ?>/send-message" hidden="">
                    <button type="submit" class="btn btn-flat btn-blue active">Отправить</button>
                </div>
            </div>
        </form>
    </div>
</header>