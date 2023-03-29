<?php echo trim($siteData->globalDatas['view::_shop/bill/item/list/index']); ?>
<div class="row">
    <div class="col-md-12">
        <h4 class="pull-right">Стоимость <label class="amount-title">без доставки</label>: <label><?php echo Func::getPriceStr($siteData->currency, $data->values['amount']);?></label> </h4>
    </div>
</div>
<div class="row">
    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab4" data-toggle="tab">Данные заказа <i class="fa fa-fw fa-info text-blue"></i></a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="tab4">
                    <?php if (((Func::isShopMenu('shopbill/name?type='.$data->values['shop_table_catalog_id'], $siteData)))){  ?>
                        <div class="row record-input record-tab">
                            <div class="col-md-3 record-title">
                                <label>
                                    <?php echo SitePageData::setPathReplace('type.form_data.shop_bill.fields_title.name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <input name="name" class="form-control" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_bill.fields_title.name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>" value="<?php echo $data->values['name']; ?>" type="text">
                            </div>
                        </div>
                    <?php } ?>
                    <div class="margin-t-15">
                        <?php
                        $view = View::factory('cabinet/35/_addition/options/edit');
                        $view->siteData = $siteData;
                        $view->data = $data;
                        $view->isAddNotField = TRUE;
                        $view->optionsName = 'options';
                        $view->className = 'record-tab';
                        $view->fields = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_catalog_id.fields_options.shop_bill', array());
                        echo Helpers_View::viewToStr($view);
                        ?>
                    </div>
                    <?php if (((Func::isShopMenu('shopbill/shop_root_id?type='.$data->values['shop_table_catalog_id'], $siteData)))){  ?>
                        <div class="row record-input record-tab">
                            <div class="col-md-3 record-title">
                                <label>
                                    <?php echo SitePageData::setPathReplace('type.form_data.shop_bill.fields_title.shop_root_id', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <select name="shop_root_id" class="form-control select2" style="width: 100%;">
                                    <?php echo trim($siteData->globalDatas['view::_shop/branch/list/list']); ?>
                                </select>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (((Func::isShopMenu('shopbill/shop_delivery_type_id?type='.$data->values['shop_table_catalog_id'], $siteData)))){  ?>
                        <div class="row record-input record-tab">
                            <div class="col-md-3 record-title">
                                <label>
                                    <?php echo SitePageData::setPathReplace('type.form_data.shop_bill.fields_title.shop_delivery_type_id', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <select name="shop_delivery_type_id" class="form-control select2" style="width: 100%;">
                                    <?php echo trim($siteData->globalDatas['view::_shop/deliverytype/list/list']); ?>
                                </select>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (((Func::isShopMenu('shopbill/shop_paid_type_id?type='.$data->values['shop_table_catalog_id'], $siteData)))){  ?>
                        <div class="row record-input record-tab">
                            <div class="col-md-3 record-title">
                                <label>
                                    <?php echo SitePageData::setPathReplace('type.form_data.shop_bill.fields_title.shop_paid_type_id', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <select name="shop_paid_type_id" class="form-control select2" style="width: 100%;">
                                    <?php echo trim($siteData->globalDatas['view::_shop/paidtype/list/list']); ?>
                                </select>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (((Func::isShopMenu('shopbill/shop_bill_status_id?type='.$data->values['shop_table_catalog_id'], $siteData)))){  ?>
                        <div class="row record-input record-tab">
                            <div class="col-md-3 record-title">
                                <label>
                                    <?php echo SitePageData::setPathReplace('type.form_data.shop_bill.fields_title.shop_bill_status_id', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <select name="shop_bill_status_id" class="form-control select2" style="width: 100%;">
                                    <?php echo trim($siteData->globalDatas['view::_shop/bill/status/list/list']); ?>
                                </select>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (((Func::isShopMenu('shopbill/country_id?type='.$data->values['shop_table_catalog_id'], $siteData)))){  ?>
                        <div class="row record-input record-tab">
                            <div class="col-md-3 record-title">
                                <label>
                                    <?php echo SitePageData::setPathReplace('type.form_data.shop_bill.fields_title.country_id', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <select name="country_id" class="form-control select2" style="width: 100%;">
                                    <?php echo trim($siteData->globalDatas['view::_shop/country/list/list']); ?>
                                </select>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (((Func::isShopMenu('shopbill/city_id?type='.$data->values['shop_table_catalog_id'], $siteData)))){  ?>
                        <div class="row record-input record-tab">
                            <div class="col-md-3 record-title">
                                <label>
                                    <?php echo SitePageData::setPathReplace('type.form_data.shop_bill.fields_title.city_id', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <select name="city_id" class="form-control select2" style="width: 100%;">
                                    <?php echo trim($siteData->globalDatas['view::_shop/city/list/list']); ?>
                                </select>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 text-center" id="edit_panel">
        <div style="display: none;">
            <?php if($siteData->branchID > 0){ ?>
                <input name="shop_branch_id" type="text" value="<?php echo $siteData->branchID; ?>">
            <?php } ?>
            <input name="is_branch" value="<?php echo Request_RequestParams::getParamBoolean('is_branch') === TRUE; ?>">
            <input name="shop_id" value="<?php echo $siteData->shopID;?>">
            <input name="id" value="<?php echo $data->id;?>">
        </div>
        <input type="submit" value="Сохранить" class="btn btn-primary" onclick="actionSaveObject('<?php echo $siteData->urlBasic.'/cabinet/shopbill/save'?>?', <?php echo $data->id;?>,'edit_panel', 'table_panel')">
    </div>
</div>