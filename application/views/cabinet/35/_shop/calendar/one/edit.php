<div class="row">
    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab1" data-toggle="tab">Общая информация</a></li>
                <?php if (Func::isShopMenu('shopcalendar/filter?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
                    <li><a href="#tab4" data-toggle="tab"><?php echo SitePageData::setPathReplace('type.form_data.shop_calendar.fields_title.filter', SitePageData::CASE_FIRST_LETTER_UPPER); ?></a></li>
                <?php } ?>
                <?php if ($data->values['is_group'] == 1){ ?>
                    <li><a href="#tab2" data-toggle="tab"><?php echo SitePageData::setPathReplace('type.form_data.shop_calendar.fields_title.group_name', SitePageData::CASE_FIRST_LETTER_UPPER); ?> <i class="fa fa-fw fa-info text-blue"></i></a></li>
                <?php } ?>
                <?php if (Func::isShopMenu('shopcalendar/similar?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
                    <li class=""><a href="#tab6" data-toggle="tab"><?php echo SitePageData::setPathReplace('type.form_data.shop_calendar.fields_title.similar', SitePageData::CASE_FIRST_LETTER_UPPER); ?> <i class="fa fa-fw fa-info text-blue"></i></a></li>
                <?php } ?>
                <?php if (Func::isShopMenu('shopcalendar/seo?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
                    <li class=""><a href="#tab7" data-toggle="tab">SEO-настройки <i class="fa fa-fw fa-info text-blue"></i></a></li>
                <?php } ?>
                <?php if (Func::isShopMenu('shopcalendar/remarketing?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
                    <li class=""><a href="#tab5" data-toggle="tab">Код ремаркетинга <i class="fa fa-fw fa-info text-blue"></i></a></li>
                <?php } ?>
                <?php if (Func::isShopMenu('shopcalendar/child?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
                    <li <?php if (Arr::path($data->additionDatas, 'select', 0) == $data->id){echo 'class="active"';} ?>>
                        <a href="<?php echo Func::getFullURL($siteData, '/shoptablechild/index', array('shop_root_table_object_id' => 'id', 'shop_root_table_catalog_id' => 'shop_table_catalog_id', 'is_group' => 'is_group'), array('is_public_ignore' => 1, 'root_table_id' => Model_Shop_Good::TABLE_ID, 'type' => intval(Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_catalog_id.child_shop_table_catalog_ids.child.id', 0)), $data->values); ?>"><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_catalog_id.child_shop_table_catalog_ids.child.name', ''); ?> <i class="fa fa-fw fa-info text-blue"></i></a>
                    </li>
                <?php } ?>
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
                    <div class="row record-input record-tab">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                <?php echo SitePageData::setPathReplace('type.form_data.shop_calendar.fields_title.name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input name="name" type="text" class="form-control" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_calendar.fields_title.name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>" value="<?php echo htmlspecialchars($data->values['name']);?>">
                        </div>
                    </div>
                    <div class="row record-input record-tab">
                        <div class="col-md-3 record-title">
                            <label>
                                Повтор события
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <select class="form-control select2" style="width: 100%;" name="calendar_event_type_id">
                                <?php echo trim($siteData->globalDatas['view::calendareventtype/list/list']); ?>
                            </select>
                        </div>
                    </div>
                    <div class="row record-input record-tab margin-top-10px">
                        <div class="col-md-3 record-title">
                            <label>
                                Дни недели для повторения
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <select name="time_options[week_days][]" multiple="multiple" class="form-control select2" style="width: 100%;">
                                <?php
                                $weekDays = Arr::path($data->values['time_options'], 'week_days', array());
                                if(!is_array($weekDays)) {
                                    $weekDays = array();
                                }
                                ?>
                                <option data-id="1" value="1"<?php if(array_search(1, $weekDays) !== FALSE){echo ' selected';}?>>Понедельник</option>
                                <option data-id="2" value="2"<?php if(array_search(2, $weekDays) !== FALSE){echo ' selected';}?>>Вторник</option>
                                <option data-id="3" value="3"<?php if(array_search(3, $weekDays) !== FALSE){echo ' selected';}?>>Среда</option>
                                <option data-id="4" value="4"<?php if(array_search(4, $weekDays) !== FALSE){echo ' selected';}?>>Четверг</option>
                                <option data-id="5" value="5"<?php if(array_search(5, $weekDays) !== FALSE){echo ' selected';}?>>Пятница</option>
                                <option data-id="6" value="6"<?php if(array_search(6, $weekDays) !== FALSE){echo ' selected';}?>>Суббота</option>
                                <option data-id="7" value="7"<?php if(array_search(7, $weekDays) !== FALSE){echo ' selected';}?>>Воскресенье</option>
                            </select>
                        </div>
                    </div>
                    <div class="row record-input record-tab margin-top-10px">
                        <div class="col-md-3 record-title">
                            <label>
                                Дни месяца для повторения
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <select name="time_options[week_days][]" multiple="multiple" class="form-control select2" style="width: 100%;">
                                <?php
                                $monthDays = Arr::path($data->values['time_options'], 'month_days', array());
                                if(!is_array($monthDays)) {
                                    $monthDays = array();
                                }
                                ?>
                                <?php for ($i=1; $i<32; $i++){ ?>
                                <option data-id="<?php echo $i;?>" value="<?php echo $i;?>"<?php if(array_search($i, $weekDays) !== FALSE){echo ' selected';}?>><?php echo $i;?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row record-input2 record-tab">
                        <?php if (((Func::isShopMenu('shopcalendar/date_from?type='.$data->values['shop_table_catalog_id'], $siteData)))){  ?>
                            <div class="col-md-3 record-title">
                                <label>
                                    <?php echo SitePageData::setPathReplace('type.form_data.shop_calendar.fields_title.date_from', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <input name="date_from" type="local-date" class="form-control" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_calendar.fields_title.date_from', SitePageData::CASE_FIRST_LETTER_UPPER); ?>" value="<?php echo Helpers_DateTime::getDateFormatRus($data->values['date_from']); ?>">
                            </div>
                        <?php } ?>
                        <?php if (((Func::isShopMenu('shopcalendar/date_to?type='.$data->values['shop_table_catalog_id'], $siteData)))){  ?>
                            <div class="col-md-3 record-title">
                                <label>
                                    <?php echo SitePageData::setPathReplace('type.form_data.shop_calendar.fields_title.date_to', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <input name="date_to" type="local-date" class="form-control" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_calendar.fields_title.date_to', SitePageData::CASE_FIRST_LETTER_UPPER); ?>" value="<?php echo Helpers_DateTime::getDateFormatRus($data->values['date_to']); ?>">
                            </div>
                        <?php } ?>
                        <?php if (((Func::isShopMenu('shopcalendar/time_from?type='.$data->values['shop_table_catalog_id'], $siteData)))){  ?>
                            <div class="col-md-3 record-title">
                                <label>
                                    <?php echo SitePageData::setPathReplace('type.form_data.shop_calendar.fields_title.time_from', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <input name="time_from" type="time" class="form-control" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_calendar.fields_title.time_from', SitePageData::CASE_FIRST_LETTER_UPPER); ?>" value="<?php echo Helpers_DateTime::getTimeByDate($data->values['time_from']); ?>">
                            </div>
                        <?php } ?>
                        <?php if (((Func::isShopMenu('shopcalendar/time_to?type='.$data->values['shop_table_catalog_id'], $siteData)))){  ?>
                            <div class="col-md-3 record-title">
                                <label>
                                    <?php echo SitePageData::setPathReplace('type.form_data.shop_calendar.fields_title.time_to', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <input name="time_to" type="time" class="form-control" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_calendar.fields_title.time_to', SitePageData::CASE_FIRST_LETTER_UPPER); ?>" value="<?php echo Helpers_DateTime::getTimeByDate($data->values['time_to']); ?>">
                            </div>
                        <?php } ?>
                        <?php if (((Func::isShopMenu('shopcalendar/brand?type='.$data->values['shop_table_catalog_id'], $siteData)))){  ?>
                            <div class="col-md-3 record-title">
                                <label>
                                    <?php echo SitePageData::setPathReplace('type.form_data.shop_calendar.fields_title.brand', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
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
                        <?php if (((Func::isShopMenu('shopcalendar/article?type='.$data->values['shop_table_catalog_id'], $siteData)))){  ?>
                            <div class="col-md-3 record-title">
                                <label>
                                    <?php echo SitePageData::setPathReplace('type.form_data.shop_calendar.fields_title.article', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <input name="article" type="text" class="form-control" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_calendar.fields_title.article', SitePageData::CASE_FIRST_LETTER_UPPER); ?>" value="<?php echo htmlspecialchars($data->values['article']); ?>">
                            </div>
                        <?php } ?>
                        <?php if (((Func::isShopMenu('shopcalendar/unit?type='.$data->values['shop_table_catalog_id'], $siteData)))){  ?>
                            <div class="col-md-3 record-title">
                                <label>
                                    <?php echo SitePageData::setPathReplace('type.form_data.shop_calendar.fields_title.unit', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
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
                        <?php if (((Func::isShopMenu('shopcalendar/select?type='.$data->values['shop_table_catalog_id'], $siteData)))){  ?>
                            <div class="col-md-3 record-title">
                                <label>
                                    <?php echo SitePageData::setPathReplace('type.form_data.shop_calendar.fields_title.select', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
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
                    <?php if (Func::isShopMenu('shopcalendar/hashtag?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
                        <div class="row record-input record-tab margin-top-10px">
                            <div class="col-md-3 record-title">
                                <label>
                                    <?php echo SitePageData::setPathReplace('type.form_data.shop_calendar.fields_title.hashtag', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
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
                    <?php if (Func::isShopMenu('shopcalendar/rubric?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
                        <div class="row record-input record-tab margin-top-10px">
                            <div class="col-md-3 record-title">
                                <label>
                                    <?php echo SitePageData::setPathReplace('type.form_data.shop_calendar.fields_title.rubric', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
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
                        $view->fields = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_catalog_id.fields_options.shop_calendar', array());
                        echo Helpers_View::viewToStr($view);
                        ?>
                    </div>
                    <?php if ((Func::isShopMenu('shopcalendar/text?type='.$data->values['shop_table_catalog_id'], $siteData))
                    || (Func::isShopMenu('shopcalendar/text-html?type='.$data->values['shop_table_catalog_id'], $siteData))){ ?>
                        <div class="row record-input record-tab">
                            <div class="col-md-3 record-title">
                                <label>
                                    <?php echo SitePageData::setPathReplace('type.form_data.shop_calendar.fields_title.text', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                            <div class="col-md-9 record-textarea">
                                <textarea name="text" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_calendar.fields_title.text', SitePageData::CASE_FIRST_LETTER_UPPER); ?>" rows="11" class="form-control"><?php echo $data->values['text'];?></textarea>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <?php if (Func::isShopMenu('shopcalendar/filter?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
                    <div class="tab-pane" id="tab4">
                        <?php echo trim($siteData->globalDatas['view::_shop/_table/filter/list/list-edit']); ?>
                    </div>
                <?php } ?>
                <?php if ($data->values['is_group'] == 1){ ?>
                    <div class="tab-pane" id="tab2">
                        <input hidden="hidden" name="group_ids[]" value="0">
                        <?php echo $siteData->globalDatas['view::_shop/calendar/list/group'];?>
                    </div>
                <?php } ?>
                <?php if (Func::isShopMenu('shopcalendar/remarketing?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
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
                <?php if (Func::isShopMenu('shopcalendar/seo?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
                    <div class="tab-pane" id="tab7">
                        <?php
                        $view = View::factory('cabinet/35/_addition/seo');
                        $view->siteData = $siteData;
                        $view->data = $data;
                        $view->seoPrefix = '';
                        $view->rootSEOName = 'shop_table_catalog_id.seo.shop_calendar';
                        $view->tableName = Model_Shop_Good::TABLE_NAME;
                        echo Helpers_View::viewToStr($view);
                        ?>
                    </div>
                <?php } ?>
                <?php if (Func::isShopMenu('shopcalendar/similar?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
                    <div class="tab-pane" id="tab6">
                        <?php echo $siteData->globalDatas['view::_shop/calendar/list/similar'];?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <?php if (Func::isShopMenu('shopcalendar/image?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
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
<?php if (Func::isShopMenu('shopcalendar/text-html?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
<script>
    CKEDITOR.replace('text');
</script>
<?php } ?>
