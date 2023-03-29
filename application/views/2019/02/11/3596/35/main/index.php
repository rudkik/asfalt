<header class="header-find">
    <div class="container">
        <h1>Поиск строительной техники</h1>
        <p class="count"><?php echo trim($siteData->globalDatas['view::View_Shop_Cars\-kolichestvo-mashin-na-glavnoy']); ?></p>
        <div class="box-btn">
            <div class="row">
                <div class="col-xs-12">
                    <button class="btn btn-block btn-transparent active">Продажа</button>
                </div>
            </div>
        </div>
        <div class="box-categories">
            <div class="title">Популярные  категории:</div>
            <div class="categories">
                <div class="row">
                    <?php echo trim($siteData->globalDatas['view::View_Shop_Cars\-rubrikatciya']); ?>
                </div>
            </div>
        </div>
        <form action="<?php echo $siteData->urlBasicLanguage;?>/trucks" method="get" class="box-find">
            <div class="box-mark">
                <div class="mark-select">
                    <select id="mark" name="mark" class="form-control select2" style="width: 100%;">
                        <option value="-1" data-id="-1">Марка</option>
                        <?php echo trim($siteData->globalDatas['view::View_Shop_Marks\-marki']); ?>
                    </select>
                </div>
            </div>
            <div class="box-model">
                <div class="mark-select">
                    <select id="model" name="model" class="form-control select2" style="width: 100%;">
                        <option value="-1" data-id="-1">Модель</option>
                    </select>
                </div>
            </div>
            <div class="box-land">
                <div class="mark-select">
                    <select id="land" name="land" class="form-control select2" style="width: 100%;">
                        <option value="-1" data-id="-1">Страна</option>
                        <?php echo trim($siteData->globalDatas['view::View_Lands\-strany']); ?>
                    </select>
                </div>
            </div>
            <div class="find">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Что Вы ищете?">
                    <span class="input-group-btn">
                        <div class="corner-yellow"></div>
                        <button class="btn btn-find-yellow" type="submit"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/find.png"></button>
                    </span>
                </div>
            </div>
        </form>
    </div>
</header>
<header class="header-catalogs">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="box-sale">
                    <div class="box-grey"></div>
                    <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/sale.png">
                    <h2><span class="yellow">Выбрать</span> спецтехнику</h2>
                    <p class="info">Воспользуйтесь удобным каталогом с широким ассортиментом спецтехники. Позиции постоянно дополняются и обновляются.</p>
                    <a href="<?php echo $siteData->urlBasicLanguage;?>/trucks" class="btn btn-block btn-yellow btn-oblique"><span>Начать</span></a>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="box-sale">
                    <div class="box-grey"></div>
                    <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/lease.png">
                    <h2><span class="yellow">Найти </span> запчасти</h2>
                    <p class="info">Приобретайте оригинальные запасные части по лучшим ценам.</p>
                    <a href="<?php echo $siteData->urlBasicLanguage;?>/spares" class="btn btn-block btn-yellow btn-oblique"><span>Начать</span></a>
                </div>
            </div>
        </div>
    </div>
</header>
<header class="header-new">
    <div class="container">
        <h2><span class="yellow">Новые</span> объявления</h2>
        <div class="col-md-12">
            <div id="trucks-list">
                <?php echo trim($siteData->globalDatas['view::View_Shop_Cars\-novye-mashiny']); ?>
            </div>
        </div>
    </div>
</header>
<script>
    $(function () {
        $(".select2").select2();

        $('#mark').change(function () {
            var id = $(this).val();
            jQuery.ajax({
                url: '/get-models',
                data: ({
                    'shop_mark_id': (id),
                }),
                type: "POST",
                success: function (data) {
                    $('#model').select2('destroy').empty().html(data).select2().val(-1);
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });
        });
    });
    $(document).ready(function() {
        $('#trucks-list').slick({
            arrows:         true,
            dots:           false,
            infinite:       true,
            slidesToShow:   4,
            slidesToScroll: 1,
            adaptiveHeight: true,
            autoplay: true,
            autoplaySpeed: 20000,
            initialSlide: 0,
            responsive: [
                {
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 3,
                    }
                },
                {
                    breakpoint: 780,
                    settings: {
                        slidesToShow: 2,
                    }
                },
                {
                    breakpoint: 495,
                    settings: {
                        slidesToShow: 1,
                    }
                }
            ]
        });
    });
</script>