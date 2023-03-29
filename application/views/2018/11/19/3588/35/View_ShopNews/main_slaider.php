<?php if(count($data['view::View_ShopNew\main_slaider']->childs) > 0){?>
    <div class="header header-slider">
        <div class="container">
            <div class="box-sliders">
                <a class="slider-left" href="#" data-action="left"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/s-left.png"></a>
                <div id="header-slider-photo" >
                    <?php
                    $i = 0;
                    foreach ($data['view::View_ShopNew\main_slaider']->childs as $value){
                        if($i == 0) {
                            $value->str = str_replace('<div class="item">', '<div class="item active">', $value->str);
                            $i++;
                        }

                        echo $value->str;
                    }
                    ?>
                </div>
                <a class="slider-right" href="#" data-action="right"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/s-right.png"></a>
            </div>
        </div>
    </div>

    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic;?>/css/_component/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic;?>/css/_component/slick/slick-theme.css"/>
    <script type="text/javascript" src="<?php echo $siteData->urlBasic; ?>/css/_component/slick/slick.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#header-slider-photo').slick({
                arrows:         false,
                dots:           false,
                infinite:       true,
                slidesToShow:   1,
                slidesToScroll: 1,
                adaptiveHeight: true,
                autoplay: true,
                autoplaySpeed: 10000,
                initialSlide: 0,
            });
            $('[data-action="right"]').on('click', function() {
                $('#header-slider-photo').slick('slickNext');
                return false;
            });
            $('[data-action="left"]').on('click', function() {
                $('#header-slider-photo').slick('slickPrev');
                return false;
            });
        });
    </script>
<?php } ?>