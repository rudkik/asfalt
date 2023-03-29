<header class="header-reserve background">
    <div class="container">
        <h2>Оплата по брони №<?php echo Request_RequestParams::getParamInt('bill_id'); ?> прошла успешно.</h2>
        <div class="text-center">
            <div class="box-btn-save-reserve">
                <a href="<?php echo $siteData->urlBasic;?>/client-hotel/bill_save_pdf?id=<?php echo Request_RequestParams::getParamInt('bill_id');?>" class="btn btn-flat btn-blue" style="margin-top: 7px;">Скачать подтверждение</a>
            </div>
        </div>
        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png">
        <div class="row box-pays">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <h3 class="text-center">Приятного отдыха</h3>
            </div>
        </div>
    </div>
</header>
