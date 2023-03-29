<?php if(count($data['view::View_Shop_Good\goods-tovary-kategorii']->childs) > 1){ ?>
<section class="section-landscape-products-carousel recently-viewed" id="recently-viewed">
    <header class="section-header">
        <h2 class="section-title">Товары в категории</h2>
        <nav class="custom-slick-nav"></nav>
    </header>
    <div class="products-carousel" data-ride="tm-slick-carousel" data-wrap=".products" data-slick="{&quot;slidesToShow&quot;:5,&quot;slidesToScroll&quot;:2,&quot;dots&quot;:true,&quot;arrows&quot;:true,&quot;prevArrow&quot;:&quot;&lt;a href=\&quot;#\&quot;&gt;&lt;i class=\&quot;tm tm-arrow-left\&quot;&gt;&lt;\/i&gt;&lt;\/a&gt;&quot;,&quot;nextArrow&quot;:&quot;&lt;a href=\&quot;#\&quot;&gt;&lt;i class=\&quot;tm tm-arrow-right\&quot;&gt;&lt;\/i&gt;&lt;\/a&gt;&quot;,&quot;appendArrows&quot;:&quot;#recently-viewed .custom-slick-nav&quot;,&quot;responsive&quot;:[{&quot;breakpoint&quot;:992,&quot;settings&quot;:{&quot;slidesToShow&quot;:2,&quot;slidesToScroll&quot;:2}},{&quot;breakpoint&quot;:1200,&quot;settings&quot;:{&quot;slidesToShow&quot;:3,&quot;slidesToScroll&quot;:3}},{&quot;breakpoint&quot;:1400,&quot;settings&quot;:{&quot;slidesToShow&quot;:3,&quot;slidesToScroll&quot;:3}},{&quot;breakpoint&quot;:1700,&quot;settings&quot;:{&quot;slidesToShow&quot;:4,&quot;slidesToScroll&quot;:4}}]}">
        <div class="container-fluid">
            <div class="woocommerce columns-5">
                <div class="products">
                    <?php
                    foreach ($data['view::View_Shop_Good\goods-tovary-kategorii']->childs as $value){
                        echo $value->str;
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php } ?>