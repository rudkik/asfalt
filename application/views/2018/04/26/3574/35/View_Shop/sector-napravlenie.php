<header class="header-body" style="background: url('<?php echo Arr::path($data->values['files'], '3.file', ''); ?>') no-repeat scroll top left transparent;">
<div class="sector-background">
    <div class="col-md-12">
        <div class="box-menu">
            <a href="<?php echo $siteData->urlBasic;?>"><img class="logo" src="<?php echo $siteData->shop->getImagePath();?>"></a>
            <div class="menus">
                <div class="menu">
                    <a href="<?php echo $siteData->urlBasic;?>/about">О компании</a>
                </div>
                <div class="menu">
                    <a href="<?php echo $siteData->urlBasic;?>/sectors">Направления</a>
                </div>
                <div class="menu">
                    <a href="<?php echo $siteData->urlBasic;?>/sector-articles?sector=<?php echo $data->values['id']; ?>">Статьи</a>
                </div>
                <div class="menu">
                    <a href="<?php echo $siteData->urlBasic;?>/contacts">Контакты</a>
                </div>
            </div>
            <div class="contact">
                <?php echo trim($siteData->globalDatas['view::View_Shop_AddressContacts\basic\telefony-sverkhu']); ?>
            </div>
        </div>
        <div class="box-body">
            <div class="box-direct-info">
                <h1><?php echo $data->values['name']; ?></h1>
                <div class="info"><?php echo $data->values['text']; ?></div>
            </div>
        </div>
    </div>
</div>

    <div class="col-md-12">
        <div class="row box-goods">
            <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\sector-rubric-tovary']); ?>
        </div>
    </div>
</header>