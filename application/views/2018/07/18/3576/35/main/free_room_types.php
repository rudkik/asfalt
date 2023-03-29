<header class="header-reserve">
    <div class="container">
        <h2>Самый выгодный вариант</h2>
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
                    <div class="title">Забронировать не удалось.</div>
                    <?php foreach ($result as $value){?>
                        <div class="error"><?php echo $value; ?></div>
                    <?php }?>
                </div>
            <?php } }?>

        <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/select2/select2.min.css">
        <script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/select2/select2.full.min.js"></script>
        <div>
            <?php
            $s = trim($siteData->replaceDatas['view::View_Hotel_Shop_Room_Types\free']);
            if (!empty($s)){
                echo $s;
            }else{
            ?>
                <h4 class="not-free-room">Свободных номеров не найдено</h4>
            <?php } ?>
        </div>
    </div>
</header>
<?php
$view = View::factory($siteData->shopShablonPath.'/35/maps');
$view->siteData = $siteData;
echo Helpers_View::viewToStr($view);
?>