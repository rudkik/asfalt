<div class="row">
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить все</button>
    </div>
</div>
<div id="list-horde">
<?php for($postfix = 0; $postfix < 2; $postfix++) {?>
    <div class="box box-warning">
        <div class="box-header with-border">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <label data-name="horde-title"></label>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool link-red" data-widget="remove"><i class="fa fa-remove"></i></button>
            </div>
        </div>
        <div class="box-body block-mini">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group record-input" style="padding-top: 28px; padding-bottom: 6px;">
                        <span class="span-checkbox">
                            <input name="news[<?php echo $postfix; ?>][is_public]" value="1" checked type="checkbox" class="minimal">
                            Показать статью
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>
                            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                            Название
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                        <input data-name="horde-name" name="news[<?php echo $postfix; ?>][name]" type="text" class="form-control" placeholder="Название">
                    </div>
                </div>
                <?php
                $view = View::factory('cabinet/35/_addition/options-fields-horde');
                $view->siteData = $siteData;
                $view->data = $data;
                $view->className = 'record-list';
                $view->prefix = 'news['.$postfix.']';
                $view->fields = Arr::path($data->values, '$elements$.shop_new_catalog_id.options', array());
                echo Helpers_View::viewToStr($view);
                ?>
                <?php if ((Func::isShopMenu('shopnewrubric/index-all', array(), $siteData))
                    || ((Request_RequestParams::getParamInt('type') > 0) && (Func::isShopMenu('shopnewrubric/index?type='.Request_RequestParams::getParamInt('type'), array(), $siteData)))){ ?>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>
                                Рубрика
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                            <select name="news[<?php echo $postfix; ?>][shop_new_rubric_id]" class="form-control select2" style="width: 100%;">
                                <option value="0" data-id="0"></option>
                                <?php echo trim($siteData->globalDatas['view::shopnewrubrics/list']); ?>
                            </select>
                        </div>
                    </div>
                <?php } ?>
                <?php if (((Request_RequestParams::getParamInt('type') > 0) && (Func::isShopMenu('shopnew/select-type?type='.Request_RequestParams::getParamInt('type'), array(), $siteData)))){ ?>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>
                                Вид выделения
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                            <select name="news[<?php echo $postfix; ?>][shop_new_select_type_id]" class="form-control select2" style="width: 100%;">
                                <option value="0" data-id="0"></option>
                                <?php echo trim($siteData->globalDatas['view::shopnewselecttypes/list']); ?>
                            </select>
                        </div>
                    </div>
                <?php } ?>
                <?php if ((Request_RequestParams::getParamInt('type') > 0) && (Func::isShopMenu('shopnew/hashtag?type='.Request_RequestParams::getParamInt('type'), array(), $siteData))){ ?>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>
                                Хэштеги
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                            <select name="news[<?php echo $postfix; ?>][shop_new_hashtag_ids][]" class="form-control select2" multiple="multiple" data-placeholder="Выберите хэштеги" style="width: 100%;">
                                <?php echo trim($siteData->globalDatas['view::shopnewhashtags/list']); ?>
                            </select>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>
                            Описание
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                        <textarea name="news[<?php echo $postfix; ?>][text]" placeholder="Описание..." rows="4" class="form-control"></textarea>
                    </div>
                </div>
                <?php if (((Request_RequestParams::getParamInt('type') > 0) && (Func::isShopMenu('shopnew/remarketing?type='.Request_RequestParams::getParamInt('type'), array(), $siteData)))){ ?>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>
                                Код ремаркетинга
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                            <textarea name="news[<?php echo $postfix; ?>][remarketing]" placeholder="Код ремаркетинга" rows="4" class="form-control"></textarea>
                        </div>
                    </div>
                <?php } ?>

                <?php if (((Request_RequestParams::getParamInt('type') > 0) && (Func::isShopMenu('shopnew/similar?type='.Request_RequestParams::getParamInt('type'), array(), $siteData)))){ ?>
                    <div class="col-md-6">
                        <?php echo str_replace('_input-name_', 'news['.$postfix.'][shop_new_similar_ids][]', str_replace('_postfix_', $postfix, str_replace('name="shop_new_similar_ids[]"', 'name="news['.$postfix.'][shop_new_similar_ids][]"', $siteData->replaceDatas['view::shopnews/similar'])));?>
                    </div>
                <?php } ?>

                <div class="col-md-6">
                    <?php
                    $view = View::factory('smmarket/sadmin/35/_addition/files');
                    $view->siteData = $siteData;
                    $view->data = $data;
                    $view->columnSize = 4;
                    $view->postfix = $postfix;
                    $view->prefix = 'news['.$postfix.']';
                    echo Helpers_View::viewToStr($view);
                    ?>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <div hidden>
                <input data-name="horde-id" name="news[<?php echo $postfix; ?>][id]" value="0">
                <input name="news[<?php echo $postfix; ?>][type]" value="<?php echo Request_RequestParams::getParamInt('type');?>">
                <input name="data_language_id" value="<?php echo $siteData->dataLanguageID; ?>">
                <?php if($siteData->branchID > 0){ ?>
                    <input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
                <?php } ?>
                <?php if($siteData->superUserID > 0){ ?>
                    <input name="shop_id" value="<?php echo $siteData->shopID; ?>">
                <?php } ?>
            </div>

            <div class="pull-left">
                <button href="<?php $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopnew/savehorde" data-index="<?php echo $postfix; ?>" data-name="horde-save" type="button" class="btn btn-primary">Сохранить</button>
            </div>
            <div class="pull-right">
                <button type="button" class="btn btn-warning" data-name="horde-clone">Дублировать</button>
                <button type="button" class="btn btn-success" data-name="horde-insert">Добавить</button>
            </div>
        </div>
    </div>
<?php } ?>
</div>
<div class="row">
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить все</button>
    </div>
</div>