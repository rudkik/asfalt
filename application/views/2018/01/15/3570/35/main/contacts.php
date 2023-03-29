			<div class="header-title">
                <h1>Разборка автомобилей в Москве</h1>
            </div>
            <div class="header-find">
                <form method="get" action="<?php echo $siteData->urlBasic;?>/catalogs"  class="input-group">
                    <span class="input-group-addon btn-find-car"><img class="" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/find-car.png"></span>
                    <div class="input-group-addon box-line"><div class="line"></div></div>
                    <input name="name" class="form-control" type="text" placeholder="Поиск запчасти по названию…" value="<?php echo Request_RequestParams::getParamStr('name'); ?>">
                    <div class="input-group-addon box-line"><div class="line gray"></div></div>
                    <div class="input-group-addon box-rubric">
                        <div>
                            <a href="">
                                <img class="" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/rubric.png">
                                <div class="rubric-name">Все рубрики</div>
                                <img class="" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/points.png">
                            </a>
                        </div>
                    </div>
                    <span class="input-group-addon btn-find"><button type="submit"><img class="" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/find.png"></button></span>
                </form>
            </div>
            <div class="header-top-car">
                <h2>Наша разборка специализируется <br>на продаже б/у запчастей</h2>
            </div>
        </div>
        <div data-action="scroll-line" data-id="5" class="background-5">
            <div class="header-maps">
                <h2>Связаться с нами </h2>
                <h3>Остались вопросы, позвоните нам</h3>
                <?php echo trim($siteData->globalDatas['view::View_Shop_AddressContacts\kontakty']); ?>
                <div class="phone">
                    <div class="media-left">
                        <img class="" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/contact/point.png">
                    </div>
                    <div class="media-body">
                        г. Москва, Егорьевский проезд, 22 Б
                    </div>
                </div>
                <div class="phone">
                    <div class="media-left">
                        <img class="" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/contact/time.png">
                    </div>
                    <div class="media-body">
                        Пн-Пт с 9:00 до 20:00, Сб-Вс с 10:00 до 18:00
                    </div>
                </div>
                <div class="box-btn">
                    <a href="<?php echo $siteData->urlBasic;?>/catalogs" class="btn btn-flat btn-background">КАТАЛОГ ЗАПЧАСТЕЙ</a>
                </div>
                <div class="pays">
                    <img class="" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/pay/visa.png">
                    <img class="" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/pay/master.png">
                    <img class="" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/pay/sberbank.png">
                </div>
                <img class="img-car-footer" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/car-6.png">
                <p class="copyrighted">© 2018 Razbor-city.ru - “Разборка автомобилей в Москве”</p>
            </div>
        </div>
    </div>
</div>
<script>
    $(window).on("scroll", function() {
        var scrolTop = $(window).scrollTop();
        var screenWidth = screen.width;

        $('.oval').removeClass('active');
        var last = 0;
        var topMax = screenWidth * (-1);
        $('[data-action="scroll-line"]').each(function(index, value){
            var top = $(this).position().top - 100;
            if (topMax < top){
                topMax = top;
                if ((scrolTop >= top - screenWidth / 6)) {
                    last = $(this).data('id');
                }
            }
        });
        $('.oval[data-id="'+ last +'"]').addClass('active');
    });
</script>