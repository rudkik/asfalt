<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="exampleInputEmail1">
                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                <?php echo SitePageData::setPathReplace('type.form_data.shop_branch.fields_title.name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
            <input name="name" type="text" class="form-control" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_branch.fields_title.name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>">
        </div>
    </div>
</div>
<?php if (((Func::isShopMenu('shopbranch/city?type='.Request_RequestParams::getParamInt('type'), $siteData)))){  ?>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    <?php echo SitePageData::setPathReplace('type.form_data.shop_branch.fields_title.city', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
                <select class="form-control select2" style="width: 100%;" name="city_id">
                    <option data-id="0" value="0">Без значения</option>
                    <?php echo trim($siteData->globalDatas['view::city/list/list']); ?>
                </select>
            </div>
        </div>
    </div>
<?php } ?>
<?php if (((Func::isShopMenu('shopbranch/official_name?type='.Request_RequestParams::getParamInt('type'), $siteData)))){  ?>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    <?php echo SitePageData::setPathReplace('type.form_data.shop_branch.fields_title.official_name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
                <input name="official_name" type="text" class="form-control" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_branch.fields_title.official_name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>">
            </div>
        </div>
    </div>
<?php } ?>
<?php if (((Func::isShopMenu('shopbranch/sub_domain?type='.Request_RequestParams::getParamInt('type'), $siteData)))){  ?>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">
                    <?php echo SitePageData::setPathReplace('type.form_data.shop_branch.fields_title.sub_domain', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
                <input name="sub_domain" type="text" class="form-control" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_branch.fields_title.sub_domain', SitePageData::CASE_FIRST_LETTER_UPPER); ?>">
            </div>
        </div>
    </div>
<?php } ?>
<?php if (((Func::isShopMenu('shopbranch/domain?type='.Request_RequestParams::getParamInt('type'), $siteData)))){  ?>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">
                    <?php echo SitePageData::setPathReplace('type.form_data.shop_branch.fields_title.domain', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
                <input name="domain" type="text" class="form-control" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_branch.fields_title.domain', SitePageData::CASE_FIRST_LETTER_UPPER); ?>">
            </div>
        </div>
    </div>
<?php } ?>
<?php if (((Func::isShopMenu('shopbranch/brand?type='.Request_RequestParams::getParamInt('type'), $siteData)))){  ?>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">
                    <?php echo SitePageData::setPathReplace('type.form_data.shop_branch.fields_title.brand', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
                <select class="form-control select2" style="width: 100%;" name="shop_table_brand_id">
                    <option data-id="0" value="0">Без значения</option>
                    <?php echo trim($siteData->globalDatas['view::_shop/_table/brand/list/list']); ?>
                </select>
            </div>
        </div>
    </div>
<?php } ?>
<?php if (((Func::isShopMenu('shopbranch/unit?type='.Request_RequestParams::getParamInt('type'), $siteData)))){  ?>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">
                    <?php echo SitePageData::setPathReplace('type.form_data.shop_branch.fields_title.unit', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
                <select class="form-control select2" style="width: 100%;" name="shop_table_unit_id">
                    <option data-id="0" value="0">Без значения</option>
                    <?php echo trim($siteData->globalDatas['view::_shop/_table/unit/list/list']); ?>
                </select>
            </div>
        </div>
    </div>
<?php } ?>
<?php if (((Func::isShopMenu('shopbranch/select?type='.Request_RequestParams::getParamInt('type'), $siteData)))){  ?>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">
                    <?php echo SitePageData::setPathReplace('type.form_data.shop_branch.fields_title.select', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
                <select class="form-control select2" style="width: 100%;" name="shop_table_select_id">
                    <option data-id="0" value="0">Без значения</option>
                    <?php echo trim($siteData->globalDatas['view::_shop/_table/select/list/list']); ?>
                </select>
            </div>
        </div>
    </div>
<?php } ?>
<?php if (Func::isShopMenu('shopbranch/hashtag?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">
                    <?php echo SitePageData::setPathReplace('type.form_data.shop_branch.fields_title.hashtag', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
                <select name="shop_table_hashtags[]" multiple="multiple" class="form-control select2" style="width: 100%;">
                    <?php echo trim($siteData->globalDatas['view::_shop/_table/hashtag/list/list']); ?>
                </select>
            </div>
        </div>
    </div>
<?php } ?>
<?php if (Func::isShopMenu('shopbranch/rubric?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">
                    <?php echo SitePageData::setPathReplace('type.form_data.shop_branch.fields_title.rubric', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
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
    $view->fields = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_catalog_id.fields_options.shop_branch', array());
    echo Helpers_View::viewToStr($view);
    ?>
</div>
<?php if ((Func::isShopMenu('shopbranch/text?type='.Request_RequestParams::getParamInt('type'), $siteData))
    || (Func::isShopMenu('shopbranch/text-html?type='.Request_RequestParams::getParamInt('type'), $siteData))){ ?>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">
                    <?php echo SitePageData::setPathReplace('type.form_data.shop_branch.fields_title.text', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
                <textarea name="text" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_branch.fields_title.text', SitePageData::CASE_FIRST_LETTER_UPPER); ?>" rows="11" class="form-control"></textarea>
            </div>
        </div>
    </div>
<?php } ?>
<?php if (Func::isShopMenu('shopbranch/image?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
    <div class="row">
        <div class="col-md-12">
            <?php
            $view = View::factory('sladushka/manager/35/_addition/files');
            $view->siteData = $siteData;
            $view->data = $data;
            $view->columnSize = 12;
            echo Helpers_View::viewToStr($view);
            ?>
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
    </div>

    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>
