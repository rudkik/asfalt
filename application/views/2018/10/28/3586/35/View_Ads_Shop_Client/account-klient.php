<div class="col-auto offset-md-1 col-lg-4 d-flex flex-column flex-lg-column justify-content-between align-items-start">
    <div class="block_with_icon margin-mob-tb-1">
        <div class="block_with_icon__block">
            <figure class="block_with_icon__icon">
                <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/dist/img/icons/profile-big.svg" alt="Profile icon 1">
            </figure>
            <div class="block_with_icon__text title--block">
                <span><?php echo $data->values['name']; ?></span>
                <span><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.user_id.email', ''); ?></span>
            </div>
        </div>
        <a href="<?php echo $siteData->urlBasic;?>/account/profile/edit" class="btn btn--fixed">
            Редактировать профиль
        </a>
    </div>
</div>
<div class="offset-md-1 col-lg-5 col-sm-auto margin-mob-tb-1">
    <div class="title--block margin-t-1-5 margin-b-1">
        Ваши адреса:
    </div>
    <div class="mail">
        <div class="mail__inner">
            <div class="mail__addresses">
                <a class="mail__address text--title" href="#mail_address_1">
                    Адрес в США
                </a>
                <a class="mail__address text--title" href="#mail_address_2" style="display: none">
                    Адрес в ОАЭ
                </a>
            </div>
            <div class="mail__info">
                <div class="mail__block" id="mail_address_1">
                    <ul class="mail__info__list">
                        <li class="mail__info__item">Adress 1 - 1263 Old Coochs Bridge Rd</li>
                        <li class="mail__info__item">Adress 2 - Ste.IPL-<?php echo $data->values['address_code']; ?>*</li>
                        <li class="mail__info__item">City - Newark,</li>
                        <li class="mail__info__item">State - DE</li>
                        <li class="mail__info__item">Zip code - 19713</li>
                        <li class="mail__info__item">Tel: +1 (302) 273-2981</li>
                    </ul>
                </div>
                <div class="mail__block" id="mail_address_2">
                    <ul class="mail__info__list">
                        <li class="mail__info__item">&nbsp;</li>
                        <li class="mail__info__item">&nbsp;</li>
                        <li class="mail__info__item">&nbsp;</li>
                        <li class="mail__info__item">&nbsp;</li>
                        <li class="mail__info__item">&nbsp;</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>