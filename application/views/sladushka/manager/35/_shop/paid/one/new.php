<?php if (((Func::isShopMenu('shoppaid/name?type='.Request_RequestParams::getParamInt('type'), $siteData)))){  ?>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    <?php echo SitePageData::setPathReplace('type.form_data.shop_paid.fields_title.name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
                <input name="name" type="text" class="form-control" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_paid.fields_title.name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>">
            </div>
        </div>
    </div>
<?php } ?>
<?php if (((Request_RequestParams::getParamInt('paid_shop_id') < 1) && (Func::isShopMenu('shoppaid/paid_shop_id?type='.Request_RequestParams::getParamInt('type'), $siteData)))){  ?>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">
                    <?php echo SitePageData::setPathReplace('type.form_data.shop_paid.fields_title.paid_shop_id', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
                <select class="form-control select2" style="width: 100%;" name="paid_shop_id">
                    <option data-id="0" value="0">Без значения</option>
                    <?php echo trim($siteData->globalDatas['view::_shop/branch/list/list']); ?>
                </select>
            </div>
        </div>
    </div>
<?php } ?>
<?php if (( (Func::isShopMenu('shoppaid/shop_paid_type_id?type='.Request_RequestParams::getParamInt('type'), $siteData)))){  ?>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">
                    <?php echo SitePageData::setPathReplace('type.form_data.shop_paid.fields_title.shop_paid_type_id', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
                <select class="form-control select2" style="width: 100%;" name="shop_paid_type_id">
                    <option data-id="0" value="0">Без значения</option>
                    <?php echo trim($siteData->globalDatas['view::_shop/paidtype/list/list']); ?>
                </select>
            </div>
        </div>
    </div>
<?php } ?>
<?php if (Func::isShopMenu('shoppaid/rubric?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">
                    <?php echo SitePageData::setPathReplace('type.form_data.shop_paid.fields_title.rubric', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
                <select name="shop_table_rubric_id" class="form-control select2" style="width: 100%;">
                    <option value="0" data-id="0">Без значения</option>
                    <?php echo trim($siteData->globalDatas['view::_shop/_table/rubric/list/list']); ?>
                </select>
            </div>
        </div>
    </div>
    <div id="options-rubric" class="margin-top-10px">
        <?php
        $view = View::factory('sladushka/manager/35/_addition/options');
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
    $view = View::factory('sladushka/manager/35/_addition/options');
    $view->siteData = $siteData;
    $view->data = $data;
    $view->className = 'record-tab';
    $view->fields = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_catalog_id.fields_options.shop_paid', array());
    echo Helpers_View::viewToStr($view);
    ?>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="exampleInputEmail1">
                Сумма
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
            <input name="amount" type="text" class="form-control" placeholder="Сумма">
        </div>
    </div>
</div>
<?php if ((Func::isShopMenu('shoppaid/text?type='.Request_RequestParams::getParamInt('type'), $siteData))
    || (Func::isShopMenu('shoppaid/text-html?type='.Request_RequestParams::getParamInt('type'), $siteData))){ ?>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">
                    <?php echo SitePageData::setPathReplace('type.form_data.shop_paid.fields_title.text', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
                <textarea name="text" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_paid.fields_title.text', SitePageData::CASE_FIRST_LETTER_UPPER); ?>" rows="11" class="form-control"></textarea>
            </div>
        </div>
    </div>
<?php } ?>
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
        <input name="paid_shop_id" value="<?php echo Request_RequestParams::getParamInt('paid_shop_id'); ?>">
        <input name="shop_operation_id" value="<?php echo $siteData->operationID; ?>">
    </div>

    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>