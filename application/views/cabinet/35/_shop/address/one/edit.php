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
                            <label class="span-checkbox">
                                <input name="is_public" <?php if (Arr::path($data->values, 'is_public', 0) == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
                                Показать
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <?php if(count($siteData->shop->getLanguageIDsArray()) > 1){?>
                            <div class="col-md-3 record-title"></div>
                            <div class="col-md-3" style="max-width: 250px;">
                                <label class="span-checkbox">
                                    <input name="is_translate" <?php if (Arr::path($data->values['is_translates'], $siteData->dataLanguageID, 0) == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
                                    Переведено?
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                        <?php }?>
                    </div>
                    <?php if(Arr::path($data->values, 'is_main_shop', 1) != 1){?>
                        <div class="row record-input record-list">
                            <div class="col-md-3 record-title">
                                <label>
                                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                    Название
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <input name="name" type="text" class="form-control" rows="5" placeholder="Название" value="<?php echo htmlspecialchars(Arr::path($data->values, 'name', ''));?>">
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
                            <div id="options-rubric" class="margin-top-10px">
                                <?php
                                $view = View::factory('cabinet/35/_addition/options/edit');
                                $view->siteData = $siteData;
                                $view->data = $data;
                                $view->className = 'record-tab';
                                $view->fields = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_catalog_id.fields_options.shop_table_rubric', array());
                                if(count($view->fields) > 0) {
                                    echo Helpers_View::viewToStr($view);
                                }
                                ?>
                            </div>
                        <?php } ?>
                    <?php }  ?>
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
                            <input href="<?php echo $siteData->urlBasic; ?>/cabinet/shop/isunique" name="street" type="text" class="form-control" placeholder="Улица (ул. Лермантова / мкр. №1)" value="<?php echo htmlspecialchars(Arr::path($data->values, 'street', ''));?>">
                        </div>
                        <div class="col-md-3 record-title">
                            <label>
                                Угол улицы
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-3">
                            <input name="street_conv" type="text" class="form-control" placeholder="Угол улицы (уг. ул. Лермантова)" value="<?php echo htmlspecialchars(Arr::path($data->values, 'street_conv', ''));?>">
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
                            <input name="house" type="text" class="form-control" placeholder="№ дома" value="<?php echo htmlspecialchars(Arr::path($data->values, 'house', ''));?>">
                        </div>
                        <div class="col-md-3 record-title">
                            <label>
                                Офис / квартира
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-3">
                            <input name="office" type="text" class="form-control" placeholder="Офис / квартира" value="<?php echo htmlspecialchars(Arr::path($data->values, 'office', ''));?>">
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
                                <textarea name="comment" placeholder="Примечание к адресу" rows="7" class="form-control"><?php echo Arr::path($data->values, 'comment', '');?></textarea>
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
                            <textarea name="map_data" placeholder="Примечание к адресу" rows="7" class="form-control"><?php echo Arr::path($data->values, 'map_data', '');?></textarea>
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
                                <?php
                                $s = '<option data-id="0" value="0">Везде</option>'.trim($siteData->replaceDatas['view::land/list/list']);
                                foreach ($data->values['land_ids'] as $land){
                                    $d = 'data-id="'.$land.'"';
                                    $s = str_replace($d, $d.' selected', $s);
                                }
                                echo $s;
                                ?>
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
        <input name="is_main_shop" value="<?php echo $data->values['is_main_shop'];?>">
        <input name="data_language_id" value="<?php echo $siteData->dataLanguageID; ?>">
        <?php if($siteData->branchID > 0){ ?>
            <input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
        <?php } ?>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
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
