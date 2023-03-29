<div class="contact">
    <div class="phone">
        <div class="media-left">
            <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/<?php
            switch ($data->values['contact_type_id']){
                case Model_ContactType::CONTACT_TYPE_PHONE:
                case Model_ContactType::CONTACT_TYPE_MOBILE:
                    echo 'phone';
                    break;
                case Model_ContactType::CONTACT_TYPE_SKYPE:
                    echo 'skype';
                    break;
                case Model_ContactType::CONTACT_TYPE_EMAIL:
                    echo 'email';
                    break;
            }
            ?>.png">
        </div>
        <div class="media-body">
            <?php echo Func::getContactHTMLRus($data->values, false, true);?>
            <span><?php echo $data->values['text']; ?></span>
        </div>
    </div>
</div>