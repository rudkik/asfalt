<div class="container relative">
    <div class="main__page__contacts__block">
        <h5 class="main__page__contacts__block__title">
            Как нас найти?
        </h5>
        <h6 class="main__page__contacts__block__text">
            ТОО «Восточная Коммерческая»
        </h6>
        <p class="main__page__contacts__block__text__block">
            Центральный офис:<br>
            <?php echo Helpers_Address::getAddressStr($siteData, $data->values, '<br>', TRUE, TRUE); ?>
        </p>
        <p class="main__page__contacts__block__text__block">
            <?php echo trim($siteData->globalDatas['view::View_Shop_AddressContacts\-e-mail']); ?>
            <a href="http://www.vostkomer.kz">www.vostkomer.kz</a>
        </p>
        <h6 class="main__page__contacts__block__text main__page__contacts__block__tel">
           <?php echo trim($siteData->globalDatas['view::View_Shop_AddressContacts\-telefony']); ?>
        </h6>
        <span class="btn main__page__contacts__more_contacts">
            <a href="<?php echo $siteData->urlBasic; ?>/contacts">
                В другий городах
            </a>
        </span>
    </div>
</div>
<div id="maps" style="height: 400px"><script type="text/javascript" charset="utf-8" async src="<?php echo $data->values['map_data']; ?>"></script></div>