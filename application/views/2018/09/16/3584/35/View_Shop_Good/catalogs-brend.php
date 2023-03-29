<?php if ($data->id > 0){?>
<nav class="woocommerce-breadcrumb">
    <a href="<?php echo $siteData->urlBasic; ?>">Главная</a>	
    <span class="delimiter">
        <i class="tm tm-breadcrumbs-arrow-right"></i>
    </span>
	<?php echo $data->values['name']; ?>
</nav>
<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <h1 class="jumbo-title find-title"><span>Товары бренда:</span>  <?php echo $data->values['name']; ?></h1>
        <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\catalogs-tovary']); ?>
    </main>
</div>
<?php }?>