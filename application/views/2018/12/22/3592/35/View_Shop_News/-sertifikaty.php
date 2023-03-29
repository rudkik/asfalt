<div id="certificates" class="row">
    <?php
    foreach ($data['view::View_Shop_New\-sertifikaty']->childs as $value){
        echo $value->str;
    }
    ?>
</div>
<script>
    $(document).ready(function() {
        $('#certificates').slick({
            arrows:         true,
            dots:           false,
            infinite:       true,
            slidesToShow:   4,
            slidesToScroll: 4,
            adaptiveHeight: true,
            autoplay: true,
            autoplaySpeed: 10000,
            initialSlide: 0,
            responsive: [
                {
                    breakpoint: 980,
                    settings: {
                        slidesToShow: 3,
                    }
                },
                {
                    breakpoint: 770,
                    settings: {
                        slidesToShow: 2,
                    }
                },
                {
                    breakpoint: 500,
                    settings: {
                        slidesToShow: 1,
                    }
                }
            ]
        });
    });
</script>