<div class="row">
    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab1" data-toggle="tab">Общая информация</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="tab1">
                    <div class="row record-input2 record-tab">
                        <div class="col-md-3 record-title"></div>
                        <div class="col-md-3" style="max-width: 250px;">
                            <span class="span-checkbox">
                                <input name="is_public" value="1" checked type="checkbox" class="minimal">
                                Показать
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </span>
                        </div>
                        <?php if(count($siteData->shop->getLanguageIDsArray()) > 1){?>
                            <div class="col-md-3 record-title"></div>
                            <div class="col-md-3" style="max-width: 250px;">
                                <label class="span-checkbox">
                                    <input name="is_translate" value="1" checked type="checkbox" class="minimal">
                                    Переведено?
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                        <?php }?>
                    </div>
                    <?php if(! Request_RequestParams::getParamBoolean('is_main_shop')){?>
                        <div class="row record-input record-tab">
                            <div class="col-md-3 record-title">
                                <label>
                                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                    Название
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <input name="name" type="text" class="form-control" placeholder="Название">
                            </div>
                        </div>
                        <?php if (Func::isShopMenu('shopaddress/rubric', $siteData)){ ?>
                            <div class="row record-input record-tab margin-top-10px">
                                <div class="col-md-3 record-title">
                                    <label>
                                        Рубрика
                                        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                    </label>
                                </div>
                                <div class="col-md-9">
                                    <select name="shop_table_rubric_id" class="form-control select2" style="width: 100%;">
                                        <option value="0" data-id="0">Без значения</option>
                                        <?php echo trim($siteData->globalDatas['view::_shop/_table/rubric/list/list']); ?>
                                    </select>
                                </div>
                            </div>
                        <?php } ?>
                    <?php }?>
                    <div class="row record-input2 record-tab">
                        <?php if (((Func::isShopMenu('shopaddress/land', $siteData)))){  ?>
                            <div class="col-md-3 record-title">
                                <label>
                                    Страна
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control select2" style="width: 100%;" name="land_id">
                                    <option data-id="0" value="0">Без значения</option>
                                    <?php echo trim($siteData->globalDatas['view::land/list/list']); ?>
                                </select>
                            </div>
                        <?php } ?>
                        <?php if (((Func::isShopMenu('shopaddress/city', $siteData)))){  ?>
                            <div class="col-md-3 record-title">
                                <label>
                                    Город
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                            <div id="city_id" class="col-md-3">
                                <select class="form-control select2" style="width: 100%;" name="city_id">
                                    <option data-id="0" value="0">Без значения</option>
                                    <?php
                                    if (key_exists('view::city/list/list', $siteData->globalDatas)){
                                        echo trim($siteData->globalDatas['view::city/list/list']);
                                    }
                                    ?>
                                </select>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="row record-input2 record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Улица / микрорайон
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-3">
                            <input href="<?php echo $siteData->urlBasic; ?>/cabinet/shop/isunique" name="street" type="text" class="form-control" placeholder="Улица (ул. Лермантова / мкр. №1)">
                        </div>

                        <div class="col-md-3 record-title">
                            <label>
                                Угол улицы
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-3">
                            <input name="street_conv" type="text" class="form-control" placeholder="Угол улицы (уг. ул. Лермантова)">
                        </div>
                    </div>
                    <div class="row record-input2 record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                № дома
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-3">
                            <input name="house" type="text" class="form-control" placeholder="№ дома">
                        </div>
                        <div class="col-md-3 record-title">
                            <label>
                                Офис / квартира
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-3">
                            <input name="office" type="text" class="form-control" placeholder="Офис / квартира">
                        </div>
                    </div>
                    <?php if ((Func::isShopMenu('shopaddress/text', $siteData))
                    || (Func::isShopMenu('shopaddress/text-html', $siteData))){ ?>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                Примечание к адресу
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <textarea name="comment" placeholder="Примечание к адресу" rows="7" class="form-control"></textarea>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                Данные карты
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                <br>
                                <a href="https://tech.yandex.ru/maps/tools/constructor/">Яндекс карта</a>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <textarea name="map_data" placeholder="Данные карты" rows="7" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row record-input record-tab margin-t-15">
                        <div class="col-md-3 record-title">
                            <label>
                                Для каких стран показывать
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <select name="land_ids[]" class="form-control select2" multiple="multiple" data-placeholder="Выберите страны" style="width: 100%;">
                                <option data-id="0" value="0">Везде</option>
                                <?php echo trim($siteData->globalDatas['view::land/list/list']); ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <?php
        if (Func::isShopMenu('shopaddress/image', $siteData)){
            $view = View::factory('cabinet/35/_addition/files');
            $view->siteData = $siteData;
            $view->data = $data;
            $view->columnSize = 12;
            echo Helpers_View::viewToStr($view);
        }
        ?>
    </div>
</div>
<div class="row">
    <div hidden>
        <input name="is_main_shop" value="<?php echo intval(Request_RequestParams::getParamInt('is_main_shop'));?>">
        <input name="data_language_id" value="<?php echo $siteData->dataLanguageID; ?>">
        <?php if($siteData->branchID > 0){ ?>
            <input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
        <?php } ?>
        <?php if($siteData->superUserID > 0){ ?>
            <input name="shop_id" value="<?php echo $siteData->shopID; ?>">
        <?php } ?>
    </div>

    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>
<?php if (Func::isShopMenu('shopaddress/text-html', $siteData)){ ?>
    <script>
        CKEDITOR.replace('comment');
    </script>
<?php } ?>
