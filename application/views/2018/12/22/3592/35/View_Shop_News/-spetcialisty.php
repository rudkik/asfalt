<div id="workers" class="row">
    <?php
    foreach ($data['view::View_Shop_New\-spetcialisty']->childs as $value){
        echo $value->str;
    }
    ?>
</div>
<script>
    $(document).ready(function() {
        $('#workers').slick({
            arrows:         true,
            dots:           false,
            infinite:       true,
            slidesToShow:   5,
            slidesToScroll: 5,
            adaptiveHeight: true,
            autoplay: true,
            autoplaySpeed: 10000,
            initialSlide: 0,
            responsive: [
                {
                    breakpoint: 1030,
                    settings: {
                        slidesToShow: 4,
                    }
                },
                {
                    breakpoint: 840,
                    settings: {
                        slidesToShow: 3,
                    }
                },
                {
                    breakpoint: 640,
                    settings: {
                        slidesToShow: 2,
                    }
                },
                {
                    breakpoint: 440,
                    settings: {
                        slidesToShow: 1,
                    }
                }
            ]
        });
    });
</script>