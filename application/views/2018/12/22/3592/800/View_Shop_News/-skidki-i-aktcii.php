<div id="sales" class="row">
    <?php
    foreach ($data['view::View_Shop_New\-skidki-i-aktcii']->childs as $value){
        echo $value->str;
    }
    ?>
</div>
<script>
    $(document).ready(function() {
        $('#sales').slick({
            arrows:         true,
            dots:           false,
            infinite:       true,
            slidesToShow:   2,
            slidesToScroll: 1,
            adaptiveHeight: true,
            autoplay: true,
            autoplaySpeed: 10000,
            initialSlide: 0,
            responsive: [
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