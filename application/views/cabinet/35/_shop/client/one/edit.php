<div class="row">
    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab1" data-toggle="tab">Общая информация</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="tab1">
                    <div class="row record-input record-tab">
                        <div class="col-md-3 record-title"></div>
                        <div class="col-md-5" style="max-width: 250px;">
                            <label class="span-checkbox">
                                <input name="is_public" <?php if ($data->values['is_public'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
                                Показать
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                    </div>
                    <div class="row record-input2 record-tab">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                <?php echo SitePageData::setPathReplace('type.form_data.shop_client.fields_title.name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-3">
                            <input name="name" type="text" class="form-control" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_client.fields_title.name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>" value="<?php echo htmlspecialchars($data->values['name']);?>">
                        </div>
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                <?php echo SitePageData::setPathReplace('type.form_data.shop_client.fields_title.last_name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-3">
                            <input name="last_name" type="text" class="form-control" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_client.fields_title.last_name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>" value="<?php echo htmlspecialchars($data->values['last_name']);?>">
                        </div>
                    </div>
                    <div class="row record-input2 record-tab">
                        <?php if (((Func::isShopMenu('shopclient/email?type='.$data->values['shop_table_catalog_id'], $siteData)))){  ?>
                            <div class="col-md-3 record-title">
                                <label>
                                    <?php echo SitePageData::setPathReplace('type.form_data.shop_client.fields_title.email', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <input name="email" type="email" class="form-control" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_client.fields_title.email', SitePageData::CASE_FIRST_LETTER_UPPER); ?>" value="<?php echo htmlspecialchars($data->values['email']);?>">
                            </div>
                        <?php } ?>
                        <?php if (((Func::isShopMenu('shopclient/brand?type='.$data->values['shop_table_catalog_id'], $siteData)))){  ?>
                            <div class="col-md-3 record-title">
                                <label>
                                    <?php echo SitePageData::setPathReplace('type.form_data.shop_client.fields_title.brand', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control select2" style="width: 100%;" name="shop_table_brand_id">
                                    <option data-id="0" value="0">Без значения</option>
                                    <?php echo trim($siteData->globalDatas['view::_shop/_table/brand/list/list']); ?>
                                </select>
                            </div>
                        <?php } ?>
                        <?php if (((Func::isShopMenu('shopclient/unit?type='.$data->values['shop_table_catalog_id'], $siteData)))){  ?>
                            <div class="col-md-3 record-title">
                                <label>
                                    <?php echo SitePageData::setPathReplace('type.form_data.shop_client.fields_title.unit', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control select2" style="width: 100%;" name="shop_table_unit_id">
                                    <option data-id="0" value="0">Без значения</option>
                                    <?php echo trim($siteData->globalDatas['view::_shop/_table/unit/list/list']); ?>
                                </select>
                            </div>
                        <?php } ?>
                        <?php if (((Func::isShopMenu('shopclient/select?type='.$data->values['shop_table_catalog_id'], $siteData)))){  ?>
                            <div class="col-md-3 record-title">
                                <label>
                                    <?php echo SitePageData::setPathReplace('type.form_data.shop_client.fields_title.select', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control select2" style="width: 100%;" name="shop_table_select_id">
                                    <option data-id="0" value="0">Без значения</option>
                                    <?php echo trim($siteData->globalDatas['view::_shop/_table/select/list/list']); ?>
                                </select>
                            </div>
                        <?php } ?>
                    </div>
                    <?php if (Func::isShopMenu('shopclient/hashtag?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
                        <div class="row record-input record-tab margin-top-10px">
                            <div class="col-md-3 record-title">
                                <label>
                                    <?php echo SitePageData::setPathReplace('type.form_data.shop_client.fields_title.hashtag', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <select name="shop_table_hashtags[]" multiple="multiple" class="form-control select2" style="width: 100%;">
                                    <?php echo trim($siteData->globalDatas['view::_shop/_table/hashtag/list/list']); ?>
                                </select>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (Func::isShopMenu('shopclient/rubric?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
                        <div class="row record-input record-tab margin-top-10px">
                            <div class="col-md-3 record-title">
                                <label>
                                    <?php echo SitePageData::setPathReplace('type.form_data.shop_client.fields_title.rubric', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
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
                        $view->fields = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_catalog_id.fields_options.shop_client', array());
                        echo Helpers_View::viewToStr($view);
                        ?>
                    </div>
                    <?php if ((Func::isShopMenu('shopclient/text?type='.$data->values['shop_table_catalog_id'], $siteData))
                    || (Func::isShopMenu('shopclient/text-html?type='.$data->values['shop_table_catalog_id'], $siteData))){ ?>
                        <div class="row record-input record-tab">
                            <div class="col-md-3 record-title">
                                <label>
                                    <?php echo SitePageData::setPathReplace('type.form_data.shop_client.fields_title.text', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                            <div class="col-md-9 record-textarea">
                                <textarea name="text" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_client.fields_title.text', SitePageData::CASE_FIRST_LETTER_UPPER); ?>" rows="11" class="form-control"><?php echo $data->values['text'];?></textarea>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <?php if (Func::isShopMenu('shopclient/image?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
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
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php }else{ ?>
            <input name="type" value="<?php echo $data->values['shop_table_catalog_id'];?>">
        <?php } ?>
        <?php if($siteData->superUserID > 0){ ?>
            <input name="shop_id" value="<?php echo $siteData->shopID; ?>">
        <?php } ?>
    </div>

    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>
<?php if (Func::isShopMenu('shopclient/text-html?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
<script>
    CKEDITOR.replace('text');
</script>
<?php } ?>
