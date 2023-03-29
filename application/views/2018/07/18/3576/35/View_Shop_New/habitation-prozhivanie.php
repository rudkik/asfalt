<?php  $siteData->replaceDatas['view::title_page'] = $data->values['name']; ?>
<header class="header-text">
    <div class="container">
        <h2><?php echo Arr::path($data->values['options'], 'title', $data->values['name']); ?></h2>
        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png">
        <div class="box-text">
            <?php echo $data->values['text']; ?>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="box-finish-reserve">
                    <a href="<?php echo Arr::path($data->values['options'], 'price_list.file', '') ?>" class="btn btn-flat btn-blue pull-right" style="margin-top: 7px;">Скачать прайс-лист</a>
                </div>
            </div>
        </div>
    </div>
</header>
<header class="header-main">
    <div class="container">
        <h2>Наши номера</h2>
        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png">
        <?php echo trim($siteData->globalDatas['view::View_Shop_News\habitation-nomera']); ?>
    </div>
</header>