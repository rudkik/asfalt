<div class="row">
    <div class="col-md-9">
        <?php if(! Request_RequestParams::getParamBoolean('is_main_shop')):?>
            <div class="row record-input record-list">
                <div class="col-md-3 record-title">
                    <span>
                        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                        Название
                        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                    </span>
                </div>
                <div class="col-md-9">
                    <input name="name" type="text" class="form-control" rows="5" placeholder="Название">
                </div>
            </div>
        <?php endif;?>

        <div class="row record-input2 record-list">
            <div class="col-md-3 record-title">
                <span>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Страна
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </span>

            </div>
            <div class="col-md-3">
                <select name="land_id" class="form-control select2" style="width: 100%;">
                    <option value="0" data-id="0"></option>
                    <?php echo trim($siteData->globalDatas['view::lands/list']); ?>
                </select>
            </div>

            <div class="col-md-3 record-title">
                <span>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Город
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </span>

            </div>
            <div id="city_id" class="col-md-3">
                <select name="city_id" class="form-control select2" style="width: 100%;">
                    <option value="0" data-id="0"></option>
                    <?php if (key_exists('view::cities/list', $siteData->globalDatas)){ echo trim($siteData->globalDatas['view::cities/list']);} ?>
                </select>
            </div>
        </div>

        <div class="row record-input2 record-list">
            <div class="col-md-3 record-title">
                <span>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Улица / микрорайон
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </span>

            </div>
            <div class="col-md-3">
                <input href="<?php echo $siteData->urlBasic; ?>/cabinet/shop/isunique" name="street" type="text" class="form-control" placeholder="Улица (ул. Лермантова / мкр. №1)">
            </div>

            <div class="col-md-3 record-title">
                <span>
                    Угол улицы
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </span>

            </div>
            <div class="col-md-3">
                <input name="street_conv" type="text" class="form-control" placeholder="Угол улицы (уг. ул. Лермантова)">
            </div>
        </div>
        <div class="row record-input2 record-list">
            <div class="col-md-3 record-title">
                <span>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    № дома
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </span>

            </div>
            <div class="col-md-3">
                <input name="house" type="text" class="form-control" placeholder="№ дома">
            </div>

            <div class="col-md-3 record-title">
                <span>
                    Офис / квартира
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </span>

            </div>
            <div class="col-md-3">
                <input name="office" type="text" class="form-control" placeholder="Офис / квартира">
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <span>
                    Примечание к адресу
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </span>
            </div>
            <div class="col-md-9">
                <textarea name="comment" placeholder="Примечание к адресу" rows="7" class="form-control"></textarea>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <span>
                    Данные карты
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                    <br>
                    <a href="https://tech.yandex.ru/maps/tools/constructor/">Яндекс карта</a>
                </span>
            </div>
            <div class="col-md-9">
                <textarea name="map_data" placeholder="Примечание к адресу" rows="7" class="form-control"></textarea>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div hidden>
        <input name="is_main_shop" value="<?php echo Arr::path($data->values, 'is_main_shop', 1);?>">
        <input name="data_language_id" value="<?php echo $siteData->dataLanguageID; ?>">
        <?php if($siteData->branchID > 0){ ?>
            <input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
        <?php } ?>
        <?php if($siteData->superUserID > 0){ ?>
            <input name="shop_id" value="<?php echo $siteData->shopID; ?>">
        <?php } ?>
    </div>

    <div class="modal-footer  text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>