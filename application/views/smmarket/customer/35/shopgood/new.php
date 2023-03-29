<div class="row">
    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab1" data-toggle="tab">Общая информация</a></li>
                <?php if (((Request_RequestParams::getParamInt('type') > 0) && (Func::isShopMenu('shopattribute/index?type='.Request_RequestParams::getParamInt('type'), array(), $siteData)))
                    || (Func::isShopMenu('shopattribute/index-all', array(), $siteData))
                    || (Request_RequestParams::getParamInt('is_group') != 1)){ ?>
                    <li><a href="#tab4" data-toggle="tab">Атрибуты</a></li>
                <?php } ?>
                <?php if (Request_RequestParams::getParamInt('is_group') == 1){ ?>
                    <li><a href="#tab2" data-toggle="tab">Связанные товары <i class="fa fa-fw fa-info text-blue"></i></a></li>
                <?php } ?>
                <?php if ( ((Request_RequestParams::getParamInt('type') > 0) && (Func::isShopMenu('shopgood/similar?type='.Request_RequestParams::getParamInt('type'), array(), $siteData)))){ ?>
                    <li class=""><a href="#tab6" data-toggle="tab">Подобные товары / услуги <i class="fa fa-fw fa-info text-blue"></i></a></li>
                <?php } ?>
                <?php if ( ((Request_RequestParams::getParamInt('type') > 0) && (Func::isShopMenu('shopgood/seo?type='.Request_RequestParams::getParamInt('type'), array(), $siteData)))){ ?>
                    <li class=""><a href="#tab7" data-toggle="tab">SEO-настройки <i class="fa fa-fw fa-info text-blue"></i></a></li>
                <?php } ?>
                <?php if ( ((Request_RequestParams::getParamInt('type') > 0) && (Func::isShopMenu('shopgood/remarketing?type='.Request_RequestParams::getParamInt('type'), array(), $siteData)))){ ?>
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
                                Показать товар / услугу
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
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
                    <div class="row record-input2 record-tab">
                        <div class="col-md-3 record-title">
                            <label>
                                Артикул
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-3">
                            <input name="article" type="text" class="form-control" placeholder="Артикул">
                        </div>
                        <div class="col-md-3 record-title">
                            <label>
                                Кол-во на складе
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-3">
                            <input name="storage_count" type="text" class="form-control" placeholder="Кол-во на складе">
                        </div>
                    </div>
                    <div class="row record-input2 record-tab">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Цена
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-3">
                            <input name="price" type="text" class="form-control" id="sub_name" placeholder="Цена">
                        </div>
                        <div class="col-md-3 record-title">
                            <label>
                                Старая цена
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-3">
                            <input name="price_old" type="text" class="form-control" placeholder="Старая цена">
                        </div>
                    </div>
                    <?php if ( ((Request_RequestParams::getParamInt('type') > 0) && (Func::isShopMenu('shopgood/selecttype?type='.Request_RequestParams::getParamInt('type'), array(), $siteData)))){ ?>
                        <div class="row record-input record-tab">
                            <div class="col-md-3 record-title">
                                <label>
                                    Тип выделения
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <select class="form-control select2" style="width: 100%;" name="good_select_type_id">
                                    <option data-id="0" value="0"></option>
                                    <?php echo trim($siteData->globalDatas['view::shopgoodselecttypes/list']); ?>
                                </select>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="margin-top-10px">
                        <?php
                        $view = View::factory('cabinet/35/_addition/options-fields');
                        $view->siteData = $siteData;
                        $view->data = $data;
                        $view->className = 'record-tab';
                        $view->fields = Arr::path($data->values, '$elements$.shop_good_type.options', array());
                        echo Helpers_View::viewToStr($view);
                        ?>
                    </div>

                    <?php if (((Request_RequestParams::getParamInt('type') > 0) && (Func::isShopMenu('shopgoodcatalog/index?type='.Request_RequestParams::getParamInt('type'), array(), $siteData)))
                        || (Func::isShopMenu('shopgoodcatalog/index-all', array(), $siteData))){ ?>
                        <div class="row record-input record-tab margin-top-10px">
                            <div class="col-md-3 record-title">
                                <label>
                                    Рубрика
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <select name="shop_table_rubric_id" class="form-control select2" style="width: 100%;">
                                    <option value="0" data-id="0"></option>
                                    <?php echo trim($siteData->globalDatas['view::shopgoodcatalogs/list']); ?>
                                </select>
                            </div>
                        </div>

                        <div id="options-rubric" class="margin-top-10px">
                            <?php
                            $view = View::factory('cabinet/35/_addition/options-fields');
                            $view->siteData = $siteData;
                            $view->data = $data;
                            $view->className = 'record-tab';
                            $view->fields = Arr::path($data->values, '$elements$.shop_good_catalog.options', array());
                            echo Helpers_View::viewToStr($view);
                            ?>
                        </div>
                    <?php } ?>


                    <div class="row record-input record-tab">
                        <div class="col-md-3 record-title">
                            <label>
                                Описание
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-9 record-textarea">
                            <textarea name="info" placeholder="Описание..." rows="11" class="form-control"></textarea>
                        </div>
                    </div>
                </div>

                <?php if (Request_RequestParams::getParamInt('is_group') == 1){ ?>
                    <div class="tab-pane" id="tab2">
                        <input hidden="hidden" name="group_good_ids[]" value="0">
                        <?php echo $siteData->globalDatas['view::shopgoods/goodgroup'];?>
                    </div>
                <?php } ?>

                <?php if ( ((Request_RequestParams::getParamInt('type') > 0) && (Func::isShopMenu('shopgood/remarketing?type='.Request_RequestParams::getParamInt('type'), array(), $siteData)))){ ?>
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

                <?php if ( ((Request_RequestParams::getParamInt('type') > 0) && (Func::isShopMenu('shopgood/seo?type='.Request_RequestParams::getParamInt('type'), array(), $siteData)))){ ?>
                    <div class="tab-pane" id="tab7">
                        <?php
                        $view = View::factory('cabinet/35/_addition/seo');
                        $view->siteData = $siteData;
                        $view->data = $data;
                        $view->seoPrefix = '';
                        $view->rootSEOName = 'shop_good_type.seo.shop_good';
                        $view->tableName = Model_Shop_Good::TABLE_NAME;
                        echo Helpers_View::viewToStr($view);
                        ?>
                    </div>
                <?php } ?>

                <?php if ( ((Request_RequestParams::getParamInt('type') > 0) && (Func::isShopMenu('shopgood/similar?type='.Request_RequestParams::getParamInt('type'), array(), $siteData)))){ ?>
                    <div class="tab-pane" id="tab6">
                        <?php echo $siteData->globalDatas['view::shopgoods/similar'];?>
                    </div>
                <?php } ?>

                <div class="tab-pane" id="tab4">
                    <?php if (((Request_RequestParams::getParamInt('type') > 0) && (Func::isShopMenu('shopattribute/index?type='.Request_RequestParams::getParamInt('type'), array(), $siteData)))
                        || (Func::isShopMenu('shopattribute/index-all', array(), $siteData))){ ?>
                        <?php echo trim($siteData->globalDatas['view::shopgoodtoattributes/index']); ?>
                    <?php } ?>

                    <?php if (Request_RequestParams::getParamInt('is_group') != 1){ ?>
                        <div class="top20">
                            <?php echo trim($siteData->globalDatas['view::shopgooditems/index']); ?>
                        </div>
                    <?php } ?>
                </div>
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
<script>
    CKEDITOR.replace('info');
</script>