<?php $index = Request_RequestParams::getParamInt('param_index'); ?>
<div class="row">
    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab1" data-toggle="tab">Общая информация</a></li>
                <?php if (Func::isShopMenu('shoptableparam'.$index.'/seo?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
                    <li class=""><a href="#tab7" data-toggle="tab">SEO-настройки <i class="fa fa-fw fa-info text-blue"></i></a></li>
                <?php } ?>
                <?php if (Func::isShopMenu('shoptableparam'.$index.'/remarketing?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
                    <li class=""><a href="#tab5" data-toggle="tab">Код ремаркетинга <i class="fa fa-fw fa-info text-blue"></i></a></li>
                <?php } ?>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="tab1">
                    <div class="row record-input2 record-tab">
                        <div class="col-md-3 record-title"></div>
                        <div class="col-md-3" style="max-width: 250px;">
                            <label class="span-checkbox">
                                <input name="is_public" <?php if ($data->values['is_public'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
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
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                <?php echo SitePageData::setPathReplace('type.form_data.shop_table_param'.$index.'.fields_title.name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input name="name" type="text" class="form-control" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_table_param'.$index.'.fields_title.name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>" value="<?php echo htmlspecialchars($data->values['name']);?>">
                        </div>
                    </div>
                    <?php if (Func::isShopMenu('shoptableparam'.$index.'/rubric?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
                        <div class="row record-input record-tab margin-top-10px">
                            <div class="col-md-3 record-title">
                                <label>
                                    <?php echo SitePageData::setPathReplace('type.form_data.shop_table_param'.$index.'.fields_title.rubric', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <select name="shop_table_rubric_id" class="form-control select2" style="width: 100%;">
                                    <option value="0" data-id="0">Выберите из списка</option>
                                    <?php echo trim($siteData->globalDatas['view::_shop/_table/rubric/list/list']); ?>
                                </select>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="margin-top-10px">
                        <?php
                        $view = View::factory('cabinet/35/_addition/options/edit');
                        $view->siteData = $siteData;
                        $view->data = $data;
                        $view->className = 'record-tab';
                        $view->fields = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_catalog_id.fields_options.shop_table_param'.$index, array());
                        echo Helpers_View::viewToStr($view);
                        ?>
                    </div>
                    <?php if ((Func::isShopMenu('shoptableparam'.$index.'/text?type='.$data->values['shop_table_catalog_id'], $siteData))
                    || (Func::isShopMenu('shoptableparam'.$index.'/text-html?type='.$data->values['shop_table_catalog_id'], $siteData))){ ?>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                <?php echo SitePageData::setPathReplace('type.form_data.shop_table_param'.$index.'.fields_title.text', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-9 record-textarea">
                            <textarea name="text" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_table_param'.$index.'.fields_title.text', SitePageData::CASE_FIRST_LETTER_UPPER); ?>" rows="11" class="form-control"><?php echo $data->values['text'];?></textarea>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <?php if (Func::isShopMenu('shoptableparam'.$index.'/seo?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
                    <div class="tab-pane" id="tab7">
                        <?php
                        $view = View::factory('cabinet/35/_addition/seo');
                        $view->siteData = $siteData;
                        $view->data = $data;
                        $view->seoPrefix = '';
                        $view->rootSEOName = 'shop_table_catalog_id.seo.shop_table_param'.$index;
                        $view->tableName = Model_Shop_Table_Hashtag::TABLE_NAME;
                        echo Helpers_View::viewToStr($view);
                        ?>
                    </div>
                <?php } ?>
                <?php if (Func::isShopMenu('shoptableparam'.$index.'/remarketing?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
                    <div class="tab-pane" id="tab5">
                        <div class="row record-input record-tab">
                            <div class="col-md-3 record-title">
                                <label>
                                    Код ремаркетинга
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <textarea name="remarketing" placeholder="Код ремаркетинга" rows="3" class="form-control"><?php echo $data->values['remarketing'];?></textarea>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <?php
        $view = View::factory('cabinet/35/_addition/files');
        $view->siteData = $siteData;
        $view->data = $data;
        $view->columnSize = 12;
        echo Helpers_View::viewToStr($view);
        ?>
    </div>
</div>
<div class="row">
    <div hidden>
        <input name="data_language_id" value="<?php echo $siteData->dataLanguageID; ?>">
        <input name="param_index" value="<?php echo Request_RequestParams::getParamInt('param_index');?>">
        <?php if($siteData->branchID > 0){ ?>
            <input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
        <?php } ?>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php }else{ ?>
            <input name="type" value="<?php echo $data->values['shop_table_catalog_id'];?>">
            <input name="table_id" value="<?php echo $data->values['table_id'];?>">
        <?php } ?>
        <?php if($siteData->superUserID > 0){ ?>
            <input name="shop_id" value="<?php echo $siteData->shopID; ?>">
        <?php } ?>
    </div>

    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>
<?php if (Func::isShopMenu('shoptableparam'.$index.'/text-html?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
    <script>
        CKEDITOR.replace('text');
    </script>
<?php } ?>
