<?php echo trim($siteData->globalDatas['view::_shop/operation/stock/item/list/index']); ?>
<div class="row">
    <div class="col-md-12">
        <h4 class="pull-right">Стоимость: <label><?php echo Func::getPriceStr($siteData->currency, $data->values['amount']);?></label> </h4>
    </div>
</div>
<div class="row">
    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab4" data-toggle="tab">Данные склада оператора <i class="fa fa-fw fa-info text-blue"></i></a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="tab4">
                    <?php if (((Func::isShopMenu('shopoperationstock/name?type='.$data->values['shop_table_catalog_id'], $siteData)))){  ?>
                        <div class="row record-input record-tab">
                            <div class="col-md-3 record-title">
                                <label>
                                    <?php echo SitePageData::setPathReplace('type.form_data.shop_operation_stock.fields_title.name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <input name="name" class="form-control" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_operation_stock.fields_title.name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>" value="<?php echo $data->values['name']; ?>" type="text">
                            </div>
                        </div>
                    <?php } ?>
                    <div class="margin-t-15">
                        <?php
                        $view = View::factory('cabinet/35/_addition/options/edit');
                        $view->siteData = $siteData;
                        $view->data = $data;
                        $view->className = 'record-tab';
                        $view->fields = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_catalog_id.fields_options', array());
                        echo Helpers_View::viewToStr($view);
                        ?>
                    </div>
                    <div class="row record-input record-tab">
                        <div class="col-md-3 record-title">
                            <label>
                                <?php echo SitePageData::setPathReplace('type.form_data.shop_operation_stock.fields_title.shop_operation_id', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <select name="shop_operation_id" class="form-control select2" style="width: 100%;">
                                <?php echo trim($siteData->globalDatas['view::_shop/operation/list/list']); ?>
                            </select>
                        </div>
                    </div>
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
        <input type="submit" value="Сохранить" class="btn btn-primary" onclick="actionSaveObject('<?php echo $siteData->urlBasic.'/cabinet/shopoperationstock/save'?>?', <?php echo $data->id;?>,'edit_panel', 'table_panel')">
    </div>
</div>