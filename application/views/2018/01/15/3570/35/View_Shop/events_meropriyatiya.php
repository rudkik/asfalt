<?php
$isCurrent = Request_RequestParams::getParamInt('is_current');
$date = strtotime(Arr::path($data->values['options'], 'date', ''));
$dateCurrent = time();
if((($isCurrent == 1) && ($date > $dateCurrent)) || (($isCurrent == 0) && ($date < $dateCurrent)) || (($isCurrent != 1) && ($isCurrent != 0))){
?>
<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
    <div class="tz-events-item">
        <div class="tz-image">
            <img src="<?php echo Func::getPhotoPath($data->values['file_logotype'], 270, 270); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
            <a href="<?php echo $siteData->urlBasic; ?>/event?id=<?php echo $data->values['id']; ?>"><?php echo $data->values['name']; ?></a>
        </div>
        <div class="tz-description">
            <img alt="Images" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/images/check-01-home1.png">
            <h3><a href="<?php echo $siteData->urlBasic; ?>/event?id=<?php echo $data->values['id']; ?>"><?php echo $data->values['name']; ?></a></h3>
            <strong><?php echo Func::getShopBillDateTimeStrRus(Arr::path($data->values['options'], 'date', ''), TRUE); ?></strong>
        </div>
    </div>
</div>
<?php } ?>