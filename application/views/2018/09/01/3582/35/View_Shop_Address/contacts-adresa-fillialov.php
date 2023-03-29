<div class="container">
    <div class="row justify-content-between relative">
        <div class="col-12 col-md-auto">
            <div class="contacts__block">
                <h1 class="contacts__block__main_title">Как нас найти?</h1>
                <div>
                    <h2 class="contacts__block__title">
                        <?php echo $data->values['name']; ?>
                    </h2>
                    <h3 class="contacts__block__address">
                        Филиал: <br>
                        <?php echo Helpers_Address::getAddressStr($siteData, $data->values, '<br>', TRUE, TRUE); ?>
                    </h3>
                    <?php echo $data->additionDatas['view::View_Shop_Addresss\group\contacts-adresa-fillialov']; ?>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-auto contacts__cityes__wrap">
            <?php echo trim($siteData->globalDatas['view::View_Shop_Addresss\contacts-goroda']); ?>
        </div>
    </div>
</div>
<div id="maps" style="height: 400px"><script type="text/javascript" charset="utf-8" async src="<?php echo $data->values['map_data']; ?>"></script></div>