<div class="row">
    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab1" data-toggle="tab">Общая информация</a></li>
                <?php if (Func::isShopMenu('shopcar/filter?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
                    <li><a href="#tab4" data-toggle="tab"><?php echo SitePageData::setPathReplace('type.form_data.shop_car.fields_title.filter', SitePageData::CASE_FIRST_LETTER_UPPER); ?></a></li>
                <?php } ?>
                <?php if (Func::isShopMenu('shopcar/seo?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
                    <li class=""><a href="#tab7" data-toggle="tab">SEO-настройки <i class="fa fa-fw fa-info text-blue"></i></a></li>
                <?php } ?>
                <?php if (Func::isShopMenu('shopcar/remarketing?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
                    <li class=""><a href="#tab5" data-toggle="tab">Код ремаркетинга <i class="fa fa-fw fa-info text-blue"></i></a></li>
                <?php } ?>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="tab1">
                    <div class="row record-input record-tab">
                        <div class="col-md-3 record-title"></div>
                        <div class="col-md-3" style="max-width: 250px;">
                            <label class="span-checkbox">
                                <input name="is_public" value="1" checked type="checkbox" class="minimal">
                                Показать
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
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
                    <div class="row record-input record-tab">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                <?php echo SitePageData::setPathReplace('type.form_data.shop_car.fields_title.name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input name="name" type="text" class="form-control" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_car.fields_title.name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>">
                        </div>
                    </div>
                    <div class="row record-input2 record-tab">
                        <?php if (((Func::isShopMenu('shopcar/mark?type='.Request_RequestParams::getParamInt('type'), $siteData)))){  ?>
                            <div class="col-md-3 record-title">
                                <label>
                                    <?php echo SitePageData::setPathReplace('type.form_data.shop_car.fields_title.mark', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <select id="shop_mark_id" class="form-control select2" style="width: 100%;" name="shop_mark_id">
                                    <option data-id="0" value="0">Без значения</option>
                                    <?php echo trim($siteData->globalDatas['view::_shop/mark/list/list']); ?>
                                </select>
                            </div>
                        <?php } ?>
                        <?php if (((Func::isShopMenu('shopcar/model?type='.Request_RequestParams::getParamInt('type'), $siteData)))){  ?>
                            <div class="col-md-3 record-title">
                                <label>
                                    <?php echo SitePageData::setPathReplace('type.form_data.shop_car.fields_title.model', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <select id="shop_model_id" class="form-control select2" style="width: 100%;" name="shop_model_id">
                                    <option data-id="0" value="0">Без значения</option>
                                </select>
                            </div>
                        <?php } ?>
                        <?php if (((Func::isShopMenu('shopcar/location_land?type='.Request_RequestParams::getParamInt('type'), $siteData)))){  ?>
                            <div class="col-md-3 record-title">
                                <label>
                                    <?php echo SitePageData::setPathReplace('type.form_data.shop_car.fields_title.location_land', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <select id="location_land_id" class="form-control select2" style="width: 100%;" name="location_land_id"
                                    <?php if (((Func::isShopMenu('shopcar/location_city?type='.Request_RequestParams::getParamInt('type'), $siteData)))){  ?>
                                        data-action="find-city" data-city="#location_city_id"
                                    <?php } ?>>
                                    <option data-id="0" value="0">Без значения</option>
                                    <?php echo trim($siteData->globalDatas['view::shop/land/list/list']); ?>
                                </select>
                            </div>
                        <?php } ?>
                        <?php if (((Func::isShopMenu('shopcar/location_city?type='.Request_RequestParams::getParamInt('type'), $siteData)))){  ?>
                            <div class="col-md-3 record-title">
                                <label>
                                    <?php echo SitePageData::setPathReplace('type.form_data.shop_car.fields_title.location_city', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <select id="location_city_id" class="form-control select2" style="width: 100%;" name="location_city_id">
                                    <option data-id="0" value="0">Без значения</option>
                                    <?php echo trim($siteData->globalDatas['view::city/list/list']); ?>
                                </select>
                            </div>
                        <?php } ?>
                        <?php if (((Func::isShopMenu('shopcar/production_land?type='.Request_RequestParams::getParamInt('type'), $siteData)))){  ?>
                            <div class="col-md-3 record-title">
                                <label>
                                    <?php echo SitePageData::setPathReplace('type.form_data.shop_car.fields_title.production_land', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <select id="production_land_id" class="form-control select2" style="width: 100%;" name="production_land_id">
                                    <option data-id="0" value="0">Без значения</option>
                                    <?php echo trim($siteData->globalDatas['view::land/list/list']); ?>
                                </select>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="row record-input2 record-tab">
                        <?php
                        $view = View::factory('cabinet/35/_addition/params/edit');
                        $view->siteData = $siteData;
                        $view->data = $data;
                        $view->className = '';
                        $view->fields = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_catalog_id.fields_params.shop_car', array());
                        echo Helpers_View::viewToStr($view);
                        ?>
                        <?php
                        $view = View::factory('cabinet/35/_addition/shop-table-params/edit');
                        $view->siteData = $siteData;
                        $view->data = $data;
                        $view->className = '';
                        $view->params = $data->getElementValue('shop_table_catalog_id', 'child_shop_table_catalog_ids.'.$siteData->languageID,
                            $data->getElementValue('shop_table_catalog_id', 'child_shop_table_catalog_ids', array()));
                        echo Helpers_View::viewToStr($view);
                        ?>
                    </div>
                    <div class="row record-input2 record-tab">
                        <?php if (((Func::isShopMenu('shopcar/price?type='.Request_RequestParams::getParamInt('type'), $siteData)))){  ?>
                            <div class="col-md-3 record-title">
                                <label>
                                    <?php echo SitePageData::setPathReplace('type.form_data.shop_car.fields_title.price', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <input name="price" type="text" class="form-control" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_car.fields_title.price', SitePageData::CASE_FIRST_LETTER_UPPER); ?>">
                            </div>
                        <?php } ?>
                        <?php if (((Func::isShopMenu('shopcar/price_old?type='.Request_RequestParams::getParamInt('type'), $siteData)))){  ?>
                            <div class="col-md-3 record-title">
                                <label>
                                    <?php echo SitePageData::setPathReplace('type.form_data.shop_car.fields_title.price_old', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <input name="price_old" type="text" class="form-control" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_car.fields_title.price_old', SitePageData::CASE_FIRST_LETTER_UPPER); ?>">
                            </div>
                        <?php } ?>
                        <?php if (((Func::isShopMenu('shopcar/currency?type='.Request_RequestParams::getParamInt('type'), $siteData)))){  ?>
                            <div class="col-md-3 record-title">
                                <label>
                                    Валюта
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <select id="currency_id" class="form-control select2" style="width: 100%;" name="currency_id">
                                    <option data-id="0" value="0">По умолчанию</option>
                                    <?php echo trim($siteData->globalDatas['view::currency/list/list']); ?>
                                </select>
                            </div>
                        <?php } ?>
                    </div>
                    <?php if (Func::isShopMenu('shopcar/hashtag?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
                        <div class="row record-input record-tab margin-top-10px">
                            <div class="col-md-3 record-title">
                                <label>
                                    <?php echo SitePageData::setPathReplace('type.form_data.shop_car.fields_title.hashtag', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <select data-shop="<?php echo $siteData->branchID; ?>" data-is-add="1" data-url="/cabinet/shoptablehashtag/find_list_json" data-type="<?php echo intval(Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_catalog_id.child_shop_table_catalog_ids.'.$siteData->languageID.'.hashtag.id', 0)); ?>" name="shop_table_hashtags[]" multiple="multiple" class="form-control select2" style="width: 100%;">
                                </select>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (Func::isShopMenu('shopcar/rubric?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
                        <div class="row record-input record-tab margin-top-10px">
                            <div class="col-md-3 record-title">
                                <label>
                                    <?php echo SitePageData::setPathReplace('type.form_data.shop_car.fields_title.rubric', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
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
                    <div class="margin-top-10px">
                        <?php
                        $view = View::factory('cabinet/35/_addition/options/edit');
                        $view->siteData = $siteData;
                        $view->data = $data;
                        $view->className = 'record-tab';
                        $view->fields = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_catalog_id.fields_options.shop_car', array());
                        echo Helpers_View::viewToStr($view);
                        ?>
                    </div>
                    <?php if ((Func::isShopMenu('shopcar/text?type='.Request_RequestParams::getParamInt('type'), $siteData))
                        || (Func::isShopMenu('shopcar/text-html?type='.Request_RequestParams::getParamInt('type'), $siteData))){ ?>
                        <div class="row record-input record-tab">
                            <div class="col-md-3 record-title">
                                <label>
                                    <?php echo SitePageData::setPathReplace('type.form_data.shop_car.fields_title.text', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                            <div class="col-md-9 record-textarea">
                                <textarea name="text" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_car.fields_title.text', SitePageData::CASE_FIRST_LETTER_UPPER); ?>" rows="11" class="form-control"></textarea>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <?php if (Func::isShopMenu('shopcar/filter?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
                    <div class="tab-pane" id="tab4">
                        <?php echo trim($siteData->globalDatas['view::_shop/_table/filter/list/list-edit']); ?>
                    </div>
                <?php } ?>
                <?php if (Func::isShopMenu('shopcar/remarketing?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
                    <div class="tab-pane" id="tab5">
                        <div class="row record-input record-tab">
                            <div class="col-md-3 record-title">
                                <label>
                                    Код ремаркетинга
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>

                            </div>
                            <div class="col-md-9">
                                <textarea name="remarketing" placeholder="Код ремаркетинга" rows="3" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php if (Func::isShopMenu('shopcar/seo?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
                    <div class="tab-pane" id="tab7">
                        <?php
                        $view = View::factory('cabinet/35/_addition/seo');
                        $view->siteData = $siteData;
                        $view->data = $data;
                        $view->seoPrefix = '';
                        $view->rootSEOName = 'shop_table_catalog_id.seo.shop_car';
                        $view->tableName = Model_Shop_Car::TABLE_NAME;
                        echo Helpers_View::viewToStr($view);
                        ?>
                    </div>
                <?php } ?>
                <?php if (Func::isShopMenu('shopcar/similar?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
                    <div class="tab-pane" id="tab6">
                        <?php echo $siteData->globalDatas['view::_shop/car/list/similar'];?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <?php if (Func::isShopMenu('shopcar/image?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
            <?php
            $view = View::factory('cabinet/35/_addition/files');
            $view->siteData = $siteData;
            $view->data = $data;
            $view->columnSize = 12;
            echo Helpers_View::viewToStr($view);
            ?>
        <?php } ?>
    </div>
</div>
<div class="row">
    <div hidden>
        <input name="data_language_id" value="<?php echo $siteData->dataLanguageID; ?>">
        <?php if($siteData->branchID > 0){ ?>
            <input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
        <?php } ?>
        <input name="type" value="<?php echo Request_RequestParams::getParamInt('type');?>">
        <?php if($siteData->superUserID > 0){ ?>
            <input name="shop_id" value="<?php echo $siteData->shopID; ?>">
        <?php } ?>
    </div>

    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>
<?php if (Func::isShopMenu('shopcar/text-html?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
    <script>
        CKEDITOR.replace('text');

        $(function () {
            $('#shop_mark_id').change(function () {
                var id = $(this).val();
                jQuery.ajax({
                    url: '/cabinet/shopmodel/select_options',
                    data: ({
                        'shop_mark_id': (id),
                    }),
                    type: "POST",
                    success: function (data) {
                        $('#shop_model_id').select2('destroy').empty().html(data).select2().val(-1);
                    },
                    error: function (data) {
                        console.log(data.responseText);
                    }
                });
            });
        });
    </script>
<?php } ?>
