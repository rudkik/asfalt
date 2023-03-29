<?php  $siteData->replaceDatas['view::title_page'] = $data->values['name']; ?>
<header class="header-text">
    <div class="container">
        <h2><?php echo $data->values['name']; ?></h2>
        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png">
        <div class="box-text">
            <?php echo $data->values['text']; ?>
        </div>
    </div>
</header>
<header class="header-main">
    <div class="container">
        <h2>Наши бассейны</h2>
        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png">
        <?php echo trim($siteData->globalDatas['view::View_Shop_News\water-basseiny']); ?>
    </div>
</header>
<header class="header-text">
    <div class="container">
        <h2><?php echo Arr::path($data->values['options'], 'title' , ''); ?></h2>
        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png">
        <div class="box-text">
            <?php echo Arr::path($data->values['options'], 'info' , ''); ?>
        </div>
    </div>
</header>