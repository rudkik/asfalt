<?php  $siteData->replaceDatas['view::title_page'] = $data->values['name']; ?>
<header class="header-text">
    <div class="container">
        <?php
        $billID = Request_RequestParams::getParamInt('bill');
        if ($billID > 0){?>
            <div class="row" style="margin-bottom: 15px;">
                <div class="col-sm-12">
                    <a href="<?php echo $siteData->urlBasicLanguage;?>//bill/client?id=<?php echo $billID; ?>" style="width: 200px" class="btn btn-flat btn-blue-un pull-left">Order</a>
                </div>
            </div>
        <?php } ?>
        <h2><?php echo $data->values['name']; ?></h2>
        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png">
        <div class="box-text">
            <?php echo $data->values['text']; ?>
        </div>
    </div>
</header>