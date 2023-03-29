<header class="header-main">
    <div class="container">
        <h2>Наши услуги</h2>
        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png">
        <div class="row box-button">
            <div class="col-sm-3">
                <button class="btn btn-flat btn-blue active" data-id="#water" data-action="click-service">Вода и бассейны</button>
            </div>
            <div class="col-sm-3">
                <button class="btn btn-flat btn-blue" data-id="#home" data-action="click-service">Проживание</button>
            </div>
            <div class="col-sm-3">
                <button class="btn btn-flat btn-blue" data-id="#kitcher" data-action="click-service">Домашняя кухня</button>
            </div>
            <div class="col-sm-3">
                <button class="btn btn-flat btn-blue" data-id="#other" data-action="click-service">Услуги</button>
            </div>
        </div>
        <div id="panels-all">
            <div id="water">
                <div id="carousel-1" class="carousel slide" data-ride="carousel" data-interval="10000">
                    <div class="carousel-inner">
                        <?php echo trim($siteData->globalDatas['view::View_Shop_News\-basseiny']); ?>
                    </div>
                    <a class="left carousel-control" href="#carousel-1" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Предыдущий</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-1" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Следующий</span>
                    </a>
                </div>
            </div>

            <div id="home">
                <div id="carousel-2" class="carousel slide" data-ride="carousel" data-interval="10000">
                    <div class="carousel-inner">
                        <?php echo trim($siteData->globalDatas['view::View_Shop_News\-nomera']); ?>
                    </div>
                    <a class="left carousel-control" href="#carousel-2" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Предыдущий</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-2" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Следующий</span>
                    </a>
                </div>
            </div>

            <div id="kitcher">
                <div class="row kitchen">
                    <?php echo trim($siteData->globalDatas['view::View_Shop_News\-domashnyaya-kukhnya']); ?>
                </div>
            </div>

            <div id="other">
                <div id="carousel-3" class="carousel slide" data-ride="carousel" data-interval="10000">
                    <div class="carousel-inner">
                        <?php echo trim($siteData->globalDatas['view::View_Shop_News\-drugie-uslugi']); ?>
                    </div>
                    <a class="left carousel-control" href="#carousel-3" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Предыдущий</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-3" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Следующий</span>
                    </a>
                </div>
            </div>
        </div>

        <script>
            $('[data-action="click-service"]').click(function () {
                $('#panels-all').children().css('display', 'none');
                $($(this).data('id')).css('display', 'block');

                $(this).parent().parent().find('[data-action="click-service"]').removeClass('active');
                $(this).addClass('active');

                return false;
            });
            $('#panels-all').children().css('display', 'none');
            $('#water').css('display', 'block');

        </script>
    </div>
</header>
<header class="header-about">
    <div class="container">
        <h2>О нас</h2>
        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png">
        <div class="row">
            <div class="col-sm-4">
                <div class="box-01">
                    <p class="name">Термальная Вода</p>
                    <img class="img-responsive"  src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/about/line-l.png">
                    <p class="info">Температура термальной воды в наших бассейнах комфортна для купания круглый год. Купаясь в такой воде, Вы можете укрепить свое здоровье.</p>
                </div>
                <div class="box-02">
                    <p class="name">Природа & Отдых</p>
                    <img class="img-responsive"  src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/about/line-l.png">
                    <p class="info">Мы находимся в экологически чистом уголке Алматинской области, вдали от городского шума  – зеленый остров посреди бескрайних степей Казахстана.</p>
                </div>
            </div>
            <div class="col-sm-4">
                <img class="img-responsive"  src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/about/m-about.png">
            </div>
            <div class="col-sm-4 text-righr">
                <div class="box-03">
                    <p class="name">Семья & Друзья</p>
                    <img class="img-responsive"  src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/about/line-r.png">
                    <p class="info">Наши номера удобны как для семейного отдыха, так и веселой компании друзей и коллег. Вы можете выбрать номер, исходя из своего бюджета и предпочтений.</p>
                </div>
                <div class="box-04">
                    <p class="name">Традиции & Качество</p>
                    <img class="img-responsive"  src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/about/line-r.png">
                    <p class="info">У нас Вы можете заказать блюда казахской и уйгурской кухни: лагман, бешбармак, плов, куырдак, манты… Наши повара готовят по-домашнему, вкусно и с душой.</p>
                </div>

            </div>
        </div>
    </div>
</header>
<header class="header-message">
    <div class="container">
        <h1>Остались вопросы?</h1>
        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png">
        <p>Оставьте Ваш номер, и мы Вам позвоним</p>
        <form class="reservation" action="/command/messageadd" method="post">
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

<div id="myModalBox" class="modal fade">
    <div class="modal-dialog" style="margin-top: 132px; max-width: 716px; z-index: 10003;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Уважаемые гости!</h4>
            </div>
            <div class="modal-body" style="padding-bottom: 0px;">
                <p>Для вашей безопасности мы стали участниками <b>«Ashyq»</b> и соблюдаем все меры по предотвращению распространения <b>коронавируса</b>:</p>
                <ol style="padding-left: 16px;">
                    <li><b>Не допускаем к заселению гостей с температурой 37 и выше градусов и с «красным» и «желтым» статусом «Ashyq»</b>,</li>
                    <li>Соблюдаем масочный режим и социальную дистанцию, что также обязательно и для всех гостей в помещениях и на территории базы отдыха,</li>
                    <li>Контролируем состояние здоровья наших работников,</li>
                    <li>Проводим регулярную дезинфекцию всех помещений и территории.</li>
                </ol>
                <p>В соответствии с действующим постановлением ГГСВ Алматинской области <b>заполняемость номерного фонда – 50%</b>.</p>
                <p><b>ЗАБРОНИРОВАТЬ</b> номера можно по телефону <b><a href="+7 707 33 55 717">+7 707 33 55 717</a> (звонки/WhatsApp) в будние дни с 08:00 до 17:00</b> (Бронирование на сайте <a href="http://karadala.kz">www.karadala.kz</a> временно отключено из-за санитарно-эпидемиологической ситуации.)</p>
                <p>Оплата  за проживание <b>в размере 100%</b> осуществляется <b>заранее</b> до заселения в номер, её можно производить <b>с указанием номера брони</b> следующими способами: </p>
                <ol style="padding-left: 16px;">
                    <li>на сайте <a href="https://karadala.kz">www.karadala.kz</a></li>
                    <li>в приложении <a href="https://kaspi.kz">kaspi.kz</a></li>
                    <li>в приложении и на сайте <a href="https://homebank.kz">homebank.kz</a></li>
                    <li>через кассы и терминалы Халык банка</li>
                    <li>банковским переводом из любого банка</li>
                    <li>банковской картой при заселении</li>
                </ol>
                <p><b>Время заезда – 15.00, выезда – 12.00.</b> Заселение после 20.00 разрешается только при условии наличия оплаченной брони, и при этом нужно обязательно заранее предупредить о позднем заезде! Оплата взимается за полные сутки.</p>

                <p><b>Четверг и пятница</b> - санитарные дни, в которые по очереди спускается вода в бассейнах для полной санитарной обработки. В эти дни гостям доступны три из семи бассейнов.</p>
                <p><b>Все новости публикуются на сайте и в соц. сетях. Приятного отдыха!</b></p>
                <p>Дата публикации: 2 августа 2021 года</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#myModalBox").modal('show');
    });
</script>