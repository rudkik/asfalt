<header class="header-reserve">
    <div class="container">
        <h2>Choose a Room</h2>
        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png">

        <?php
        $result = Request_RequestParams::getParamArray('result');
        if((Arr::path($result, 'error', 0) == 1)){
            $result = Arr::path($result, 'msg', '');
            if (!empty($result)){
                if(!is_array($result)){
                    $result = array($result);
                }
                ?>
                <div class="msg-error">
                    <div class="title">Booking failed.</div>
                    <?php foreach ($result as $value){?>
                        <div class="error"><?php echo $value; ?></div>
                    <?php }?>
                </div>
            <?php } }?>

        <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/select2/select2.min.css">
        <script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/select2/select2.full.min.js"></script>
        <?php echo trim($siteData->globalDatas['view::View_Hotel_Shop_Rooms\free']); ?>
    </div>
</header>
<?php
$view = View::factory($siteData->shopShablonPath.'/36/maps');
$view->siteData = $siteData;
echo Helpers_View::viewToStr($view);
?>