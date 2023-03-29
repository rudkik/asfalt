<div class="col-md-4 news">
    <div class="date"><?php echo Helpers_DateTime::getDateTimeFormatRusMonthStr($data->values['created_at']); ?></div>
    <a href="<?php echo $siteData->urlBasic; ?>/article?id=<?php echo $data->values['id']; ?>"><?php echo $data->values['name']; ?></a>
</div>