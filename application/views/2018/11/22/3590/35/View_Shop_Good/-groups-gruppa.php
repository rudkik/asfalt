<?php if ($data->id > 0){ ?>
    <?php
    Helpers_SEO::setSEOHeader(Model_Shop_Table_Hashtag::TABLE_NAME, $data, $siteData);
    $siteData->siteImage = $data->values['image_path'];
    ?>
    <header class="header-bread-crumbs">
        <div class="container">
            <h2><?php echo $data->values['name']; ?></h2>
            <div class="box-bread-crumbs">
                <a href="<?php echo $siteData->urlBasicLanguage; ?>">Главная</a> |
                <span>Группа "<?php echo $data->values['name']; ?>"</span>
            </div>
        </div>
    </header>
    <header class="header-catalogs">
        <div class="container">
            <div class="row">
                <div class="col-xs-3">
                    <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\-products-detvora']); ?>
                    <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\-products-brendy']); ?>
                </div>
                <div class="col-xs-9">
                    <h1 itemprop="headline" class="objectTitle2">Группа "<?php echo $data->values['name']; ?>"</h1>
                    <div class="line-red"></div>
                    <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\-products-produktciya']); ?>
                    <div class="line-grey"></div>
                    <div class="box_text">
                        <?php echo $data->values['text']; ?>
                    </div>
                </div>
            </div>
        </div>
    </header>
<?php }else{ ?>
    <header class="header-bread-crumbs">
        <div class="container">
            <h2><?php echo $data->values['name']; ?></h2>
            <div class="box-bread-crumbs">
                <a href="<?php echo $siteData->urlBasicLanguage; ?>">Главная</a> |
                <?php $name = Request_RequestParams::getParamStr('name_lexicon'); ?>
                <span>Результаты поиска <?php if (!empty($name)){echo 'по запросу «'.$name.'»';} ?></span>
            </div>
        </div>
    </header>
    <header class="header-catalogs">
        <div class="container">
            <div class="row">
                <div class="col-xs-3">
                    <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\-products-detvora']); ?>
                    <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\-products-brendy']); ?>
                </div>
                <div class="col-xs-9">
                    <h1 itemprop="headline" class="objectTitle2">Продукция</h1>
                    <div class="line-red"></div>
                    <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\-products-produktciya']); ?>
                </div>
            </div>
        </div>
    </header>
<?php } ?>

