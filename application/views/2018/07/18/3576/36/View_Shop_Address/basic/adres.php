<div class="container">
    <div class="modal-contacts">
        <div class="logo">
            <img class="img-responsive" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/logo.png">
        </div>
        <div class="contacts">
            <div class="contact">
                <div class="media-left">
                    <img class="" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/point-b.png">
                </div>
                <div class="media-body">
                    <?php echo Helpers_Address::getAddressStr($siteData, $data->values, ', '); ?>
                </div>
            </div>
			<?php echo trim($siteData->globalDatas['view::View_Shop_AddressContacts\basic\telefony-snizu']); ?>
            <?php echo trim($siteData->globalDatas['view::View_Shop_AddressContacts\basic\e-mail-snizu']); ?>            
        </div>
    </div>
</div>
<div class="maps">
    <script type="text/javascript" charset="utf-8" async src="<?php echo $data->values['map_data']; ?>"></script>
</div>