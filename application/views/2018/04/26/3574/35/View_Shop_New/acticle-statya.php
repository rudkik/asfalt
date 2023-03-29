<div class="box-top">
    <div class="date"><?php echo Helpers_DateTime::getDateTimeFormatRusMonthStr($data->values['created_at']); ?></div>
    <div class="category">
        <a href="<?php echo $siteData->urlBasic; ?>/articles">
            <div class="media-left">
                <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/s-left.png">
            </div>
            <div class="media-body">
                Назад к списку
            </div>
        </a>
    </div>
</div>
<h1><?php echo $data->values['name']; ?></h1>
<div class="news-info">
    <?php echo $data->values['text']; ?>
</div>
<div class="bg-grey">
    <div class="row">
        <div class="col-md-3 socials-title">
            Поделиться
        </div>
        <div class="col-md-9 socials">
            <a href=""><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/socials/facebook-c.png"></a>
            <a href=""><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/socials/instagram-c.png"></a>
            <a href=""><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/socials/twitter-c.png"></a>
        </div>
    </div>
</div>