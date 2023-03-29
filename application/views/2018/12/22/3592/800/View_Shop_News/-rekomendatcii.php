<div id="recomen" class="row">
    <?php
    $n = 3;
    $i = 1;
    foreach ($data['view::View_Shop_New\-rekomendatcii']->childs as $value){
        echo $value->str;
    }
    ?>
</div>
<script>
    $(document).ready(function() {
        $('#recomen').slick({
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