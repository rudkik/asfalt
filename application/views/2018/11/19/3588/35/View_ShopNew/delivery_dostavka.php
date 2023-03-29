<?php Func::setSEOHeader(Model_ShopNew::TABLE_NAME, $data, $siteData); ?>
<div class="header header-breakpoint" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" data-qaid="breadcrumbs">
    <div class="container">
        <span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="<?php echo $siteData->urlBasic; ?>/">Главная</a></span> /
        <span typeof="v:Breadcrumb" class="active"><a rel="v:url" property="v:title" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->url; ?>"><?php echo $data->values['name']; ?></a></span>
    </div>
</div>
<div class="header header-info">
    <div class="container">
        <h1 itemprop="headline"><?php echo $data->values['name']; ?></h1>
        <div class="row">
			<?php if(empty($data->values['image_path'])){ ?>
			<div class="col-md-12 box_text">
                <?php echo $data->values['text']; ?>
            </div>
			<?php }else{ ?>
            <div class="col-md-4 box-img">
                <img src="<?php echo $data->values['image_path']; ?>" class="img-responsive width-100" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
            </div>
            <div class="col-md-8 box_text">
                <?php echo $data->values['text']; ?>
            </div>
			<?php } ?>
        </div>
    </div>
</div>