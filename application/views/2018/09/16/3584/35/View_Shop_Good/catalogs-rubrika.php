<?php if ($data->id > 0){?>
<nav class="woocommerce-breadcrumb">
    <a href="<?php echo $siteData->urlBasic; ?>">Главная</a>
    <?php if ($data->values['root_id'] > 0){ ?>
        <?php if (Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.root_id.root_id', 0) > 0){ ?>
            <span class="delimiter">
                <i class="tm tm-breadcrumbs-arrow-right"></i>
            </span>
            ...
        <?php } ?>
        <span class="delimiter">
            <i class="tm tm-breadcrumbs-arrow-right"></i>
        </span>
        <a href="<?php echo $siteData->urlBasic; ?>/catalogs<?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.root_id.name_url', 0); ?>"><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.root_id.name', 0); ?></a>
    <?php } ?>
    <span class="delimiter">
        <i class="tm tm-breadcrumbs-arrow-right"></i>
    </span>
	<?php echo $data->values['name']; ?>
</nav>
<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <h1 class="jumbo-title find-title"><span>Товары категории:</span> <?php echo $data->values['name']; ?></h1>
        <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\catalogs-tovary']); ?>
    </main>
</div>
<?php }?>