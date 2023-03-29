<div id="find-promo" class="modal fade bs-example-modal-lg in" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="box box-success margin-b-5">
                <div class="box-header with-border">
                    <h3 class="box-title">Выберите товар</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-fw fa-close" style="font-size: 13px"></i></button>
                    </div>
                </div>
                <div id="find-goods-group-id" class="box-body no-padding padding-b-10">
                    <div class="col-md-12 padding-t-5">
                        <div class="row">
                            <?php if (Func::isShopMenu(str_replace('_', '', $objectName).'/rubric?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <span for="input-name"  class="control-label"><?php echo SitePageData::setPathReplace('type.form_data.'.$objectName.'.fields_title.rubric', SitePageData::CASE_FIRST_LETTER_UPPER); ?></span>
                                        <div class="input-group input-group-select">
                                            <select name="shop_table_rubric_id" class="form-control select2" style="width: 100%;">
                                                <option value="-1" data-id="-1"></option>
                                                <option value="0" data-id="0">Без рубрик</option>
                                                <?php echo $siteData->globalDatas['view::_shop/_table/rubric/list/list']; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <span for="input-name"  class="control-label"><?php echo SitePageData::setPathReplace('type.form_data.'.$objectName.'.fields_title.name', SitePageData::CASE_FIRST_LETTER_UPPER); ?></span>
                                    <div class="input-group">
                                        <input id="input-name" class="form-control" name="name" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.'.$objectName.'.fields_title.name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>" value="<?php echo Arr::path($siteData->urlParams, 'name', '');?>" type="text">
                                        <label class="input-group-btn">
                                            <button type="submit" class="btn btn-warning btn-flat"><i class="fa fa-fw fa-search"></i></button>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 margin-top-5px">
                        <div class="row filter-search">
                            <div class="col-md-7 filter-input filter-limit">
                                <div class="form-group">
                                    <span for="input-limit-page"  class="col-md-7 control-label">Кол-во записей</span>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <select id="input-limit-page" name="limit_page" class="form-control select2" style="width: 100%">
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                                <option value="200">200</option>
                                                <option value="500">500</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div hidden>
                                    <?php if($siteData->branchID > 0){ ?>
                                        <input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
                                    <?php } ?>
                                    <input name="type" value="<?php echo Request_RequestParams::getParamInt('type'); ?>">

                                    <?php if(Arr::path($siteData->urlParams, 'is_public', '') == 1){?>
                                        <input id="input-status" name="is_public" value="1">
                                    <?php }elseif(Arr::path($siteData->urlParams, 'is_not_public', '') == 1){?>
                                        <input id="input-status" name="is_not_public" value="1">
                                    <?php }elseif(Arr::path($siteData->urlParams, 'is_delete', '') == 1){?>
                                        <input id="input-status" name="is_delete" value="1">
                                    <?php }else{?>
                                        <input id="input-status" name="" value="1">
                                    <?php }?>
                                </div>

                                <button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-search"></i> Поиск</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <section id="result-goods" class="content padding-t-5">
                <table data-id="0" class="table table-hover table-db margin-b-5">
                    <tr>
                        <th class="tr-header-photo">Фото</th>
                        <th>
                            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                            <?php echo SitePageData::setPathReplace('type.form_data.'.$objectName.'.fields_title.name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </th>
                        <th class="tr-header-buttom-delete"></th>
                    </tr>
                </table>

                <div class="row">
                    <div class="col-sm-12 padding-b-10 text-center">
                        <div class="contacts-list-msg text-center margin-b-5">Записи не найдены</div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>