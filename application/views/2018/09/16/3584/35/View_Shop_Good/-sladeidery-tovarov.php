<section class="section-products-carousel" id="carousel-<?php echo $data->values['id']; ?>">
    <header class="section-header">
        <h2 class="section-title"><?php echo $data->values['name']; ?></h2>
        <nav class="custom-slick-nav"></nav>
    </header>
    <div class="products-carousel 6-column-carousel" data-ride="tm-slick-carousel" data-wrap=".products" data-slick="{&quot;infinite&quot;:false,&quot;slidesToShow&quot;:6,&quot;slidesToScroll&quot;:1,&quot;dots&quot;:true,&quot;arrows&quot;:true,&quot;prevArrow&quot;:&quot;&lt;a href=\&quot;#\&quot;&gt;&lt;i class=\&quot;tm tm-arrow-left\&quot;&gt;&lt;\/i&gt;&lt;\/a&gt;&quot;,&quot;nextArrow&quot;:&quot;&lt;a href=\&quot;#\&quot;&gt;&lt;i class=\&quot;tm tm-arrow-right\&quot;&gt;&lt;\/i&gt;&lt;\/a&gt;&quot;,&quot;appendArrows&quot;:&quot;#carousel-<?php echo $data->values['id']; ?> .custom-slick-nav&quot;,&quot;responsive&quot;:[{&quot;breakpoint&quot;:480,&quot;settings&quot;:{&quot;slidesToShow&quot;:1,&quot;slidesToScroll&quot;:1}},{&quot;breakpoint&quot;:750,&quot;settings&quot;:{&quot;slidesToShow&quot;:2,&quot;slidesToScroll&quot;:2}},{&quot;breakpoint&quot;:1200,&quot;settings&quot;:{&quot;slidesToShow&quot;:3,&quot;slidesToScroll&quot;:3}},{&quot;breakpoint&quot;:1400,&quot;settings&quot;:{&quot;slidesToShow&quot;:4,&quot;slidesToScroll&quot;:4}}]}">
        <div class="container-fluid">
            <div class="woocommerce columns-6">
                <div class="products">
					<?php echo $data->additionDatas['view::View_Shop_Goods\group\-sladeidery-tovarov']; ?>
                </div>
            </div>
        </div>
    </div>
</section>