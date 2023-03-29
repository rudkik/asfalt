<div class="news">
    <div class="col-md-3"><?php echo Helpers_DateTime::getDateTimeFormatRusMonthStr($data->values['created_at']); ?></div>
    <div class="col-md-9">
        <a href="<?php echo $siteData->urlBasicLanguage; ?>/sector-article?id=<?php echo $data->values['id']; ?>"><?php echo $data->values['name']; ?></a>
    </div>
</div>