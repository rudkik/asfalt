<div class="row">
    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab4" data-toggle="tab">Общая информация <i class="fa fa-fw fa-info text-blue"></i></a></li>
                <?php if (((Request_RequestParams::getParamInt('type') > 0) && (Func::isShopMenu('shopnew/remarketing?type='.Request_RequestParams::getParamInt('type'), array(), $siteData)))){ ?>
                    <li class=""><a href="#tab5" data-toggle="tab">Код ремаркетинга <i class="fa fa-fw fa-info text-blue"></i></a></li>
                <?php } ?>
                <?php if (((Request_RequestParams::getParamInt('type') > 0) && (Func::isShopMenu('shopnew/similar?type='.Request_RequestParams::getParamInt('type'), array(), $siteData)))){ ?>
                    <li class=""><a href="#tab6" data-toggle="tab">Подобные статьи / новости <i class="fa fa-fw fa-info text-blue"></i></a></li>
                <?php } ?>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="tab4">

                    <div class="row record-input record-tab">
                        <div class="col-md-3 record-title"></div>
                        <div class="col-md-5" style="max-width: 250px;">
                            <span class="span-checkbox">
                                <input name="is_public" value="1" checked type="checkbox" class="minimal">
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
                            <input name="name" type="text" class="form-control" placeholder="Название">
                        </div>
                    </div>
                    <?php if (((Request_RequestParams::getParamInt('type') > 0) && (Func::isShopMenu('shopnew/select-type?type='.Request_RequestParams::getParamInt('type'), array(), $siteData)))){ ?>
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
                        $view->className = 'record-list';
                        $view->fields = Arr::path($data->values, '$elements$.shop_new_catalog_id.options', array());
                        echo Helpers_View::viewToStr($view);
                        ?>
                    </div>
                    <?php if ((Func::isShopMenu('shopnewrubric/index-all', array(), $siteData))
                    || ((Request_RequestParams::getParamInt('type') > 0) && (Func::isShopMenu('shopnewrubric/index?type='.Request_RequestParams::getParamInt('type'), array(), $siteData)))){ ?>
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
                        <div id="options-rubric"></div>
                    <?php } ?>
                    <?php if ((Request_RequestParams::getParamInt('type') > 0) && (Func::isShopMenu('shopnew/hashtag?type='.Request_RequestParams::getParamInt('type'), array(), $siteData))){ ?>
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
                            <textarea name="text" placeholder="Описание..." rows="11" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <?php if (((Request_RequestParams::getParamInt('type') > 0) && (Func::isShopMenu('shopnew/remarketing?type='.Request_RequestParams::getParamInt('type'), array(), $siteData)))){ ?>
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

                <?php if (((Request_RequestParams::getParamInt('type') > 0) && (Func::isShopMenu('shopnew/similar?type='.Request_RequestParams::getParamInt('type'), array(), $siteData)))){ ?>
                    <div class="tab-pane" id="tab6">
                        <?php echo $siteData->globalDatas['view::shopnews/similar'];?>
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
        <input name="type" value="<?php echo Request_RequestParams::getParamInt('type');?>">
        <input name="data_language_id" value="<?php echo $siteData->dataLanguageID; ?>">
        <?php if($siteData->branchID > 0){ ?>
            <input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
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
