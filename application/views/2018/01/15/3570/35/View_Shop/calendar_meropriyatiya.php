<?php
$year = Request_RequestParams::getParamInt('year');
$month = Request_RequestParams::getParamInt('month');

$date = strtotime(Arr::path($data->values['options'], 'date', ''));
if((($year === NULL) || ($year == date('Y', $date))) && (($month === NULL) || ($month == date('n', $date)))){
?>
<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
    <div class="tz-members-wrapper">
        <div class="tz-detail-member clearfix">
            <div class="tz-avatar pull-left">
                <a href="<?php echo $siteData->urlBasic; ?>/event?id=<?php echo $data->values['id']; ?>">
	                <img src="<?php echo Func::getPhotoPath($data->values['file_logotype'], 70, 70); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
	            </a>
            </div>
            <div class="tz-info pull-left">
                <h5><a href="<?php echo $siteData->urlBasic; ?>/event?id=<?php echo $data->values['id']; ?>"><?php echo $data->values['name']; ?></a></h5>
                <p><?php echo Arr::path($data->values['options'], 'info', ''); ?></p>
                <span class="tz-friend">
                    <a href="<?php echo $siteData->urlBasic; ?>/event?id=<?php echo $data->values['id']; ?>">Узнать больше</a>
                </span>
            </div>
        </div>
    </div>
</div>
<?php } ?>