<div id="services" class="row" style="width: 100% !important;">
    <div class="col-md-4">
        <div class="row">
            <?php
            $n = 2;
            $i = 1;
            foreach ($data['view::View_Shop_New\-nashi-uslugi']->childs as $value) {
                if($i == $n + 1){
                    echo '</div></div><div class="col-md-4"><div class="row">';
                    $i = 1;
                }
                $i++;
                echo $value->str;
            }
            ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#services').slick({
            arrows:         true,
            dots:           false,
            infinite:       true,
            slidesToShow:   3,
            slidesToScroll: 3,
            adaptiveHeight: true,
            autoplay: true,
            autoplaySpeed: 10000,
            initialSlide: 0,
            responsive: [
                {
                    breakpoint: 970,
                    settings: {
                        slidesToShow: 2,
                    }
                },
                {
                    breakpoint: 728,
                    settings: {
                        slidesToShow: 1,
                    }
                }
            ]
        });
    });
</script>