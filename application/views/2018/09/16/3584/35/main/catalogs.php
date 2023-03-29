<?php
$s = trim($siteData->replaceDatas['view::View_Shop_Good\catalogs-rubrika']);
if (!empty($s)){
    echo $s;
}else{
    $s = trim($siteData->globalDatas['view::View_Shop_Good\catalogs-brend']);
    if (!empty($s)){
        echo $s;
    }else{
        $name = Request_RequestParams::getParamStr($name);
        if (!empty($name)){
        ?>
            <nav class="woocommerce-breadcrumb">
                <a href="<?php echo $siteData->urlBasic; ?>">Главная</a>
                <span class="delimiter">
                <i class="tm tm-breadcrumbs-arrow-right"></i>
                </span>
                Результаты поиска: <?php echo $name; ?>
            </nav>
            <div id="primary" class="content-area">
                <main id="main" class="site-main">
                    <h1 class="jumbo-title find-title"><span>Результаты поиска:</span> <?php echo $name; ?></h1>
                    <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\catalogs-tovary']); ?>
                </main>
            </div>
        <?php }else{ ?>
            <nav class="woocommerce-breadcrumb">
                <a href="<?php echo $siteData->urlBasic; ?>">Главная</a>
                <span class="delimiter">
                <i class="tm tm-breadcrumbs-arrow-right"></i>
                </span>
                Товары
            </nav>
            <div id="primary" class="content-area">
                <main id="main" class="site-main">
                    <h1 class="jumbo-title">Товары</h1>
                    <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\catalogs-tovary']); ?>
                </main>
            </div>
    <?php  }
    }
}
?>
<div id="secondary" class="widget-area shop-sidebar" role="complementary">
    <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\catalogs-podrubriki']); ?>
    <div id="techmarket_products_filter-3" class="widget widget_techmarket_products_filter">
        <span class="gamma widget-title">Фильтр</span>
        <div class="widget woocommerce widget_layered_nav maxlist-more" id="woocommerce_layered_nav-2">
            <span class="gamma widget-title">Бренды</span>
            <ul>
                <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\catalogs-brendy']); ?>
            </ul>
        </div>
    </div>
    <div class="widget widget_techmarket_products_carousel_widget">
        <section id="single-sidebar-carousel" class="section-products-carousel">
            <header class="section-header">
                <h2 class="section-title">Оцените</h2>
                <nav class="custom-slick-nav"></nav>
            </header>
            <div class="products-carousel" data-ride="tm-slick-carousel" data-wrap=".products" data-slick="{&quot;infinite&quot;:false,&quot;slidesToShow&quot;:1,&quot;slidesToScroll&quot;:1,&quot;rows&quot;:2,&quot;slidesPerRow&quot;:1,&quot;dots&quot;:false,&quot;arrows&quot;:true,&quot;prevArrow&quot;:&quot;&lt;a href=\&quot;#\&quot;&gt;&lt;i class=\&quot;tm tm-arrow-left\&quot;&gt;&lt;\/i&gt;&lt;\/a&gt;&quot;,&quot;nextArrow&quot;:&quot;&lt;a href=\&quot;#\&quot;&gt;&lt;i class=\&quot;tm tm-arrow-right\&quot;&gt;&lt;\/i&gt;&lt;\/a&gt;&quot;,&quot;appendArrows&quot;:&quot;#single-sidebar-carousel .custom-slick-nav&quot;}">
                <div class="container-fluid">
                    <div class="woocommerce columns-1">
                        <div class="products">
                            <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\-otcenite-tovary']); ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>