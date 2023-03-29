<div class="row">
    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab4" data-toggle="tab">Описание <i class="fa fa-fw fa-info text-blue"></i></a></li>
                <?php if ( (($data->values['shop_new_catalog_id'] > 0) && (Func::isShopMenu('shopnew/similar?type='.$data->values['shop_new_catalog_id'], array(), $siteData)))){ ?>
                    <li class=""><a href="#tab6" data-toggle="tab">Подобные статьи / новости <i class="fa fa-fw fa-info text-blue"></i></a></li>
                <?php } ?>
                <?php if ( (($data->values['shop_new_catalog_id'] > 0) && (Func::isShopMenu('shopnew/seo?type='.$data->values['shop_new_catalog_id'], array(), $siteData)))){ ?>
                    <li class=""><a href="#tab7" data-toggle="tab">SEO-настройки <i class="fa fa-fw fa-info text-blue"></i></a></li>
                <?php } ?>
                <?php if ( (($data->values['shop_new_catalog_id'] > 0) && (Func::isShopMenu('shopnew/remarketing?type='.$data->values['shop_new_catalog_id'], array(), $siteData)))){ ?>
                    <li class=""><a href="#tab5" data-toggle="tab">Код ремаркетинга <i class="fa fa-fw fa-info text-blue"></i></a></li>
                <?php } ?>
                <?php if ( (($data->values['shop_new_catalog_id'] > 0) && (Func::isShopMenu('shopnew/newchild?type='.$data->values['shop_new_catalog_id'], array(), $siteData)))){ ?>
                    <?php echo trim($siteData->globalDatas['view::shopnewchildcatalogs/menu-top']); ?>
                <?php } ?>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="tab4">
                    <div class="row record-input record-tab">
                        <div class="col-md-3 record-title"></div>
                        <div class="col-md-5" style="max-width: 250px;">
                            <span class="span-checkbox">
                                <input name="is_public" <?php if ($data->values['is_public'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
                                Показать статью
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </span>
                        </div>
                    </div>
                    <div class="row record-input record-tab">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Название
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input name="name" type="text" class="form-control" placeholder="Название" value="<?php echo htmlspecialchars($data->values['name']);?>">
                        </div>
                    </div>
                    <?php if ((($data->values['shop_new_catalog_id'] > 0) && (Func::isShopMenu('shopnew/select-type?type='.Request_RequestParams::getParamInt('type'), array(), $siteData)))){ ?>
                        <div class="row record-input record-tab margin-top-15px">
                            <div class="col-md-3 record-title">
                                <label>
                                    Вид выделения
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <select name="shop_new_select_type_id" class="form-control select2" style="width: 100%;">
                                    <option value="0" data-id="0"></option>
                                    <?php echo trim($siteData->globalDatas['view::shopnewselecttypes/list']); ?>
                                </select>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="margin-top-15px">
                        <?php
                        $view = View::factory('cabinet/35/_addition/options-fields');
                        $view->siteData = $siteData;
                        $view->data = $data;
                        $view->className = 'record-tab';
                        $view->fields = Arr::path($data->values, '$elements$.shop_new_catalog_id.options', array());
                        echo Helpers_View::viewToStr($view);
                        ?>
                    </div>
                    <?php if ((Func::isShopMenu('shopnewrubric/index-all', array(), $siteData))
                        || (($data->values['shop_new_catalog_id'] > 0) && (Func::isShopMenu('shopnewrubric/index?type='.$data->values['shop_new_catalog_id'], array(), $siteData)))){ ?>
                        <div class="row record-input record-tab margin-top-15px">
                            <div class="col-md-3 record-title">
                                <label>
                                    Рубрика
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <select name="shop_new_rubric_id" class="form-control select2" style="width: 100%;">
                                    <option value="0" data-id="0"></option>
                                    <?php echo trim($siteData->globalDatas['view::shopnewrubrics/list']); ?>
                                </select>
                            </div>
                        </div>

                        <div id="options-rubric">
                            <?php
                            $view = View::factory('cabinet/35/_addition/options-fields');
                            $view->siteData = $siteData;
                            $view->data = $data;
                            $view->className = 'record-tab';
                            $view->fields = Arr::path($data->values, '$elements$.shop_new_rubric.options', array());
                            echo Helpers_View::viewToStr($view);
                            ?>
                        </div>
                    <?php } ?>

                    <?php if (((Request_RequestParams::getParamInt('type') > 0) && (Func::isShopMenu('shopnew/hashtag?type='.Request_RequestParams::getParamInt('type'), array(), $siteData)))){ ?>
                        <div class="row record-input record-tab margin-top-15px">
                            <div class="col-md-3 record-title">
                                <label>
                                    Хэштеги
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <select name="shop_new_hashtag_ids[]" class="form-control select2" multiple="multiple" data-placeholder="Выберите хэштеги" style="width: 100%;">
                                    <?php echo trim($siteData->globalDatas['view::shopnewhashtags/list']); ?>
                                </select>
                            </div>
                        </div>
                        <div id="options-rubric"></div>
                    <?php } ?>
                    <div class="row record-input record-tab">
                        <div class="col-md-3 record-title">
                            <label>
                                Описание
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-9 record-textarea">
                            <textarea name="text" placeholder="Описание..." rows="11" class="form-control"><?php echo $data->values['text'];?></textarea>
                        </div>
                    </div>
                </div>
                <?php if ( (($data->values['shop_new_catalog_id'] > 0) && (Func::isShopMenu('shopnew/remarketing?type='.$data->values['shop_new_catalog_id'], array(), $siteData)))){ ?>
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

                <?php if ( (($data->values['shop_new_catalog_id'] > 0) && (Func::isShopMenu('shopnew/similar?type='.$data->values['shop_new_catalog_id'], array(), $siteData)))){ ?>
                    <div class="tab-pane" id="tab6">
                        <?php echo $siteData->globalDatas['view::shopnews/similar'];?>
                    </div>
                <?php } ?>

                <?php if ( (($data->values['shop_new_catalog_id'] > 0) && (Func::isShopMenu('shopnew/seo?type='.$data->values['shop_new_catalog_id'], array(), $siteData)))){ ?>
                    <div class="tab-pane" id="tab7">
                        <?php
                        $view = View::factory('cabinet/35/_addition/seo');
                        $view->siteData = $siteData;
                        $view->data = $data;
                        $view->seoPrefix = '';
                        $view->rootSEOName = 'shop_new_catalog_id.seo.shop_new';
                        $view->tableName = Model_Shop_New::TABLE_NAME;
                        echo Helpers_View::viewToStr($view);
                        ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <?php
        $view = View::factory('smmarket/sadmin/35/_addition/files');
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
        <?php if($siteData->branchID > 0){ ?>
            <input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
        <?php } ?>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php }else{ ?>
            <input name="type" value="<?php echo $data->values['shop_new_catalog_id'];?>">
        <?php } ?>
        <?php if($siteData->superUserID > 0){ ?>
            <input name="shop_id" value="<?php echo $siteData->shopID; ?>">
        <?php } ?>
    </div>

    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>
<script>
    CKEDITOR.replace('text');
</script>