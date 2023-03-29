<div class="row">
    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab1" data-toggle="tab">Общая информация</a></li>
                <?php if (Func::isShopMenu('shopcomment/filter?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
                    <li><a href="#tab4" data-toggle="tab"><?php echo SitePageData::setPathReplace('type.form_data.shop_comment.fields_title.filter', SitePageData::CASE_FIRST_LETTER_UPPER); ?></a></li>
                <?php } ?>
                <?php if (Func::isShopMenu('shopcomment/similar?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
                    <li class=""><a href="#tab6" data-toggle="tab"><?php echo SitePageData::setPathReplace('type.form_data.shop_comment.fields_title.similar', SitePageData::CASE_FIRST_LETTER_UPPER); ?> <i class="fa fa-fw fa-info text-blue"></i></a></li>
                <?php } ?>
                <?php if (Func::isShopMenu('shopcomment/seo?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
                    <li class=""><a href="#tab7" data-toggle="tab">SEO-настройки <i class="fa fa-fw fa-info text-blue"></i></a></li>
                <?php } ?>
                <?php if (Func::isShopMenu('shopcomment/remarketing?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
                    <li class=""><a href="#tab5" data-toggle="tab">Код ремаркетинга <i class="fa fa-fw fa-info text-blue"></i></a></li>
                <?php } ?>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="tab1">
                    <div class="row record-input record-tab">
                        <div class="col-md-3 record-title"></div>
                        <div class="col-md-5" style="max-width: 250px;">
                            <label class="span-checkbox">
                                <input name="is_public" value="1" checked type="checkbox" class="minimal">
                                Показать
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                    </div>
                    <div class="row record-input record-tab">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                <?php echo SitePageData::setPathReplace('type.form_data.shop_comment.fields_title.name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input name="name" type="text" class="form-control" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_comment.fields_title.name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>">
                        </div>
                    </div>
                    <div class="row record-input2 record-tab">
                        <?php if (((Func::isShopMenu('shopcomment/created_at?type='.Request_RequestParams::getParamInt('type'), $siteData)))){  ?>
                            <div class="col-md-3 record-title">
                                <label>
                                    <?php echo SitePageData::setPathReplace('type.form_data.shop_comment.fields_title.created_at', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <input name="created_at" type="datetime" class="form-control" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_comment.fields_title.created_at', SitePageData::CASE_FIRST_LETTER_UPPER); ?>">
                            </div>
                        <?php } ?>
                        <?php if (((Func::isShopMenu('shopcomment/brand?type='.Request_RequestParams::getParamInt('type'), $siteData)))){  ?>
                            <div class="col-md-3 record-title">
                                <label>
                                    <?php echo SitePageData::setPathReplace('type.form_data.shop_comment.fields_title.brand', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
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
                        <?php if (((Func::isShopMenu('shopcomment/unit?type='.Request_RequestParams::getParamInt('type'), $siteData)))){  ?>
                            <div class="col-md-3 record-title">
                                <label>
                                    <?php echo SitePageData::setPathReplace('type.form_data.shop_comment.fields_title.unit', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
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
                        <?php if (((Func::isShopMenu('shopcomment/select?type='.Request_RequestParams::getParamInt('type'), $siteData)))){  ?>
                            <div class="col-md-3 record-title">
                                <label>
                                    <?php echo SitePageData::setPathReplace('type.form_data.shop_comment.fields_title.select', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
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
                    <?php if (Func::isShopMenu('shopcomment/hashtag?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
                        <div class="row record-input record-tab margin-top-10px">
                            <div class="col-md-3 record-title">
                                <label>
                                    <?php echo SitePageData::setPathReplace('type.form_data.shop_comment.fields_title.hashtag', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
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
                    <?php if (Func::isShopMenu('shopcomment/rubric?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
                        <div class="row record-input record-tab margin-top-10px">
                            <div class="col-md-3 record-title">
                                <label>
                                    <?php echo SitePageData::setPathReplace('type.form_data.shop_comment.fields_title.rubric', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
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
                        $view->fields = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_catalog_id.fields_options.shop_comment', array());
                        echo Helpers_View::viewToStr($view);
                        ?>
                    </div>
                    <?php if ((Func::isShopMenu('shopcomment/text?type='.Request_RequestParams::getParamInt('type'), $siteData))
                        || (Func::isShopMenu('shopcomment/text-html?type='.Request_RequestParams::getParamInt('type'), $siteData))){ ?>
                        <div class="row record-input record-tab">
                            <div class="col-md-3 record-title">
                                <label>
                                    <?php echo SitePageData::setPathReplace('type.form_data.shop_comment.fields_title.text', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                            <div class="col-md-9 record-textarea">
                                <textarea name="text" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_comment.fields_title.text', SitePageData::CASE_FIRST_LETTER_UPPER); ?>" rows="11" class="form-control"></textarea>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <?php if (Func::isShopMenu('shopcomment/filter?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
                    <div class="tab-pane" id="tab4">
                        <?php echo trim($siteData->globalDatas['view::_shop/_table/filter/list/list-edit']); ?>
                    </div>
                <?php } ?>
                <?php if (Func::isShopMenu('shopcomment/remarketing?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
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
                <?php if (Func::isShopMenu('shopcomment/seo?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
                    <div class="tab-pane" id="tab7">
                        <?php
                        $view = View::factory('cabinet/35/_addition/seo');
                        $view->siteData = $siteData;
                        $view->data = $data;
                        $view->seoPrefix = '';
                        $view->rootSEOName = 'shop_table_catalog_id.seo.shop_comment';
                        $view->tableName = Model_Shop_Comment::TABLE_NAME;
                        echo Helpers_View::viewToStr($view);
                        ?>
                    </div>
                <?php } ?>
                <?php if (Func::isShopMenu('shopcomment/similar?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
                    <div class="tab-pane" id="tab6">
                        <?php echo $siteData->globalDatas['view::_shop/comment/list/similar'];?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <?php if (Func::isShopMenu('shopcomment/image?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
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
        <input name="is_group" value="<?php echo Request_RequestParams::getParamInt('is_group');?>">
        <?php if($siteData->superUserID > 0){ ?>
            <input name="shop_id" value="<?php echo $siteData->shopID; ?>">
        <?php } ?>
    </div>

    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>
<?php if (Func::isShopMenu('shopcomment/text-html?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
    <script>
        CKEDITOR.replace('text');
    </script>
<?php } ?>
