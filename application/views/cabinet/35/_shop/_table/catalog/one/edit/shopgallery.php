<div class="row">
    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab1" data-toggle="tab">Общая информация</a></li>
                <li><a href="#tab2" data-toggle="tab">Бренд</a></li>
                <li><a href="#tab3" data-toggle="tab">Фильтры</a></li>
                <li><a href="#tab4" data-toggle="tab">Хэштеги</a></li>
                <li><a href="#tab5" data-toggle="tab">Виды выделения</a></li>
                <li><a href="#tab6" data-toggle="tab">Единицы измерения</a></li>
                <li><a href="#tab7" data-toggle="tab">Подгалерея</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="tab1">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1-1" data-toggle="tab">Фотогалерея</a></li>
                            <li><a href="#tab1-2" data-toggle="tab">Рубрика доп. параметры</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane" id="tab1-1">
                                <div class="row record-input record-tab">
                                    <div class="col-md-3 record-title"></div>
                                    <div class="col-md-5" style="max-width: 250px;">
                                        <span class="span-checkbox">
                                            <input name="is_public" <?php if ($data->values['is_public'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
                                            Показать вид фотогалереи
                                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                        </span>
                                    </div>
                                </div>
                                <div class="row record-input record-list">
                                    <div class="col-md-3 record-title">
                                        <span>
                                            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                            Название
                                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                        </span>
                                    </div>
                                    <div class="col-md-9">
                                        <input name="name" type="text" class="form-control" placeholder="Название" value="<?php echo htmlspecialchars($data->values['name']);?>">
                                    </div>
                                </div>
                                <div class="row record-input record-list margin-t-15">
                                    <div class="col-md-3 record-title">
                                        <span>
                                            Доп. параметры
                                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                        </span>
                                    </div>
                                    <div class="col-md-9">
                                        <?php
                                        $view = View::factory('cabinet/35/_addition/options/fields');
                                        $view->siteData = $siteData;
                                        $view->data = $data;
                                        $view->optionsChild = 'shop_gallery';
                                        echo Helpers_View::viewToStr($view);
                                        ?>
                                    </div>
                                </div>
                                <div class="row record-input record-list margin-t-15"">
                                    <div class="col-md-3 record-title">
                                        <span>
                                            Название полей
                                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                        </span>
                                    </div>
                                    <div class="col-md-9">
                                        <table id="body_panel" class="table table-hover table-db margin-b-5">
                                            <tr>
                                                <th style="width: 200px;">
                                                    Название
                                                </th>
                                                <th>
                                                    Для клиента <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>Список фотогалерей</td>
                                                <td><input name="form_data[shop_gallery][fields_title][name_list]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_gallery.fields_title.name_list', 'фотогалереи '.$data->values['name']), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Одна фотогалерея</td>
                                                <td><input name="form_data[shop_gallery][fields_title][name_one]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_gallery.fields_title.name_one', 'фотогалерея '.$data->values['name']), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Название</td>
                                                <td><input name="form_data[shop_gallery][fields_title][name]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_gallery.fields_title.name', 'Название'), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Артикул</td>
                                                <td><input name="form_data[shop_gallery][fields_title][article]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_gallery.fields_title.article', 'Артикул'), ENT_QUOTES);?>"></td>
                                            </tr>

                                            <tr>
                                                <td>Единица измерения</td>
                                                <td><input name="form_data[shop_gallery][fields_title][unit]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_gallery.fields_title.unit', 'Единица измерения'), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Единица измерения</td>
                                                <td><input name="form_data[shop_gallery][fields_title][unit]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_gallery.fields_title.unit', 'Единица измерения'), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Тип выделения</td>
                                                <td><input name="form_data[shop_gallery][fields_title][select]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_gallery.fields_title.select', 'Тип выделения'), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Рубрика</td>
                                                <td><input name="form_data[shop_gallery][fields_title][rubric]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_gallery.fields_title.rubric', 'Рубрика'), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Бренд</td>
                                                <td><input name="form_data[shop_gallery][fields_title][brand]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_gallery.fields_title.brand', 'Бренд'), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Хэштег</td>
                                                <td><input name="form_data[shop_gallery][fields_title][hashtag]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_gallery.fields_title.hashtag', 'Хэштег'), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Описание</td>
                                                <td><input name="form_data[shop_gallery][fields_title][text]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_gallery.fields_title.text', 'Описание'), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Фильтры</td>
                                                <td><input name="form_data[shop_gallery][fields_title][filter]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_gallery.fields_title.filter', 'Фильтры'), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Подобные картинки</td>
                                                <td><input name="form_data[shop_gallery][fields_title][similar]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_gallery.fields_title.similar', 'Подобные картинки'), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Связанные картинки</td>
                                                <td><input name="form_data[shop_gallery][fields_title][group_name]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_gallery.fields_title.group_name', 'Связанные картинки'), ENT_QUOTES);?>"></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                        </div>
                        <div class="tab-pane" id="tab1-2">
                            <div class="row record-input record-list">
                                <div class="col-md-3 record-title">
                                    <span>
                                        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                        Название
                                        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                    </span>
                                </div>
                                <div class="col-md-9">
                                    <input name="form_data[shop_table_rubric][fields_title][title]" type="text" class="form-control" placeholder="Название" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_rubric.fields_title.title', 'рубрики '.$data->values['name']), ENT_QUOTES);?>">
                                </div>
                            </div>
                            <div class="row record-input record-list margin-t-15">
                                <div class="col-md-3 record-title">
                                                <span>
                                                    Доп. параметры
                                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                                </span>
                                </div>
                                <div class="col-md-9">
                                    <?php
                                    $view = View::factory('cabinet/35/_addition/options/fields');
                                    $view->siteData = $siteData;
                                    $view->data = $data;
                                    $view->optionsChild = 'shop_table_rubric';
                                    echo Helpers_View::viewToStr($view);
                                    ?>
                                </div>
                            </div>
                            <div class="row record-input record-list margin-t-15">
                                <div class="col-md-3 record-title">
                                                <span>
                                                    Название полей
                                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                                </span>
                                </div>
                                <div class="col-md-9">
                                    <table id="body_panel" class="table table-hover table-db margin-b-5">
                                        <tr>
                                            <th style="width: 200px;">
                                                Название
                                            </th>
                                            <th>
                                                Для клиента <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                            </th>
                                        </tr>
                                        <tr>
                                            <td>Список рубрик</td>
                                            <td><input name="form_data[shop_table_rubric][fields_title][name_list]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_gallery_rubric.fields_title.name_list', 'рубрики '.$data->values['name']), ENT_QUOTES);?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Одна рубрика</td>
                                            <td><input name="form_data[shop_table_rubric][fields_title][name_one]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_gallery_rubric.fields_title.name_one', 'рубрика '.$data->values['name']), ENT_QUOTES);?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Кнопка добавления</td>
                                            <td><input name="form_data[shop_table_rubric][fields_title][button_add]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_gallery_rubric.fields_title.button_add', 'добавить рубрику'), ENT_QUOTES);?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Название</td>
                                            <td><input name="form_data[shop_table_rubric][fields_title][name]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_gallery_rubric.fields_title.name', 'Название'), ENT_QUOTES);?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Родитель</td>
                                            <td><input name="form_data[shop_table_rubric][fields_title][root]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_gallery_rubric.fields_title.root', 'Родитель '), ENT_QUOTES);?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Описание</td>
                                            <td><input name="form_data[shop_table_rubric][fields_title][text]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_gallery_rubric.fields_title.text', 'Описание'), ENT_QUOTES);?>"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab2">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab2-1" data-toggle="tab">Бренд доп. параметры</a></li>
                            <li><a href="#tab2-2" data-toggle="tab">Рубрика доп. параметры</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane" id="tab2-1">
                                <div class="row record-input record-tab">
                                    <div class="col-md-3 record-title"></div>
                                    <div class="col-md-5" style="max-width: 250px;">
                                        <span class="span-checkbox">
                                            <input name="child_shop_table_catalog_ids[brand][is_public]" <?php if (Arr::path($data->values['child_shop_table_catalog_ids'], 'brand.is_public', 0) > 0) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
                                            Создать бренд
                                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                        </span>
                                    </div>
                                </div>
                                <div class="row record-input record-list">
                                    <div class="col-md-3 record-title">
                                        <span>
                                            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                            Название
                                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                        </span>
                                    </div>
                                    <div class="col-md-9">
                                        <input name="child_shop_table_catalog_ids[brand][name]" type="text" class="form-control" placeholder="Название" value="<?php echo htmlspecialchars(Arr::path($data->values['child_shop_table_catalog_ids'], 'brand.name', 'Бренд'));?>">
                                    </div>
                                </div>
                                <div class="row record-input record-list margin-t-15">
                                    <div class="col-md-3 record-title">
                                            <span>
                                                Доп. параметры
                                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                            </span>
                                    </div>
                                    <div class="col-md-9">
                                        <?php
                                        $view = View::factory('cabinet/35/_addition/options/fields');
                                        $view->siteData = $siteData;
                                        $view->data = $data;
                                        $view->optionsChild = 'shop_table_brand';
                                        echo Helpers_View::viewToStr($view);
                                        ?>
                                    </div>
                                </div>
                                <div class="row record-input record-list margin-t-15">
                                    <div class="col-md-3 record-title">
                                            <span>
                                                Название полей
                                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                            </span>
                                    </div>
                                    <div class="col-md-9">
                                        <table id="body_panel" class="table table-hover table-db margin-b-5">
                                            <tr>
                                                <th style="width: 200px;">
                                                    Название
                                                </th>
                                                <th>
                                                    Для клиента <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>Список брендов</td>
                                                <td><input name="form_data[shop_table_brand][fields_title][name_list]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_brand.fields_title.name_list', 'бренды '.$data->values['name']), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Один бренд</td>
                                                <td><input name="form_data[shop_table_brand][fields_title][name_one]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_brand.fields_title.name_one', 'бренд '.$data->values['name']), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Кнопка добавления</td>
                                                <td><input name="form_data[shop_table_brand][fields_title][button_add]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_brand.fields_title.button_add', 'добавить бренд'), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Название</td>
                                                <td><input name="form_data[shop_table_brand][fields_title][name]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_brand.fields_title.name', 'Название'), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Рубрика</td>
                                                <td><input name="form_data[shop_table_brand][fields_title][rubric]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_brand.fields_title.rubric', 'Рубрика '), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Описание</td>
                                                <td><input name="form_data[shop_table_brand][fields_title][text]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_brand.fields_title.text', 'Описание'), ENT_QUOTES);?>"></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab2-2">
                                <div class="row record-input record-list margin-t-15">
                                    <div class="col-md-3 record-title">
                                        <span>
                                            Доп. параметры
                                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                        </span>
                                    </div>
                                    <div class="col-md-9">
                                        <?php
                                        $view = View::factory('cabinet/35/_addition/options/fields');
                                        $view->siteData = $siteData;
                                        $view->data = $data;
                                        $view->optionsChild = 'shop_table_brand_rubric';
                                        echo Helpers_View::viewToStr($view);
                                        ?>
                                    </div>
                                </div>
                                <div class="row record-input record-list margin-t-15">
                                    <div class="col-md-3 record-title">
                                            <span>
                                                Название полей
                                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                            </span>
                                    </div>
                                    <div class="col-md-9">
                                        <table id="body_panel" class="table table-hover table-db margin-b-5">
                                            <tr>
                                                <th style="width: 200px;">
                                                    Название
                                                </th>
                                                <th>
                                                    Для клиента <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>Список рубрик</td>
                                                <td><input name="form_data[shop_table_brand_rubric][fields_title][name_list]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_brand_rubric.fields_title.name_list', 'рубрики брендов '.$data->values['name']), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Одна рубрика</td>
                                                <td><input name="form_data[shop_table_brand_rubric][fields_title][name_one]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_brand_rubric.fields_title.name_one', 'рубрика брендов '.$data->values['name']), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Кнопка добавления</td>
                                                <td><input name="form_data[shop_table_brand_rubric][fields_title][button_add]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_brand_rubric.fields_title.button_add', 'добавить рубрику'), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Название</td>
                                                <td><input name="form_data[shop_table_brand_rubric][fields_title][name]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_brand_rubric.fields_title.name', 'Название'), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Родитель</td>
                                                <td><input name="form_data[shop_table_brand_rubric][fields_title][root]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_brand_rubric.fields_title.root', 'Родитель '), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Описание</td>
                                                <td><input name="form_data[shop_table_brand_rubric][fields_title][text]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_brand_rubric.fields_title.text', 'Описание'), ENT_QUOTES);?>"></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab3">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab3-1" data-toggle="tab">Фильтры доп. параметры</a></li>
                            <li><a href="#tab3-2" data-toggle="tab">Рубрика доп. параметры</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane" id="tab3-1">
                                <div class="row record-input record-tab">
                                    <div class="col-md-3 record-title"></div>
                                    <div class="col-md-5" style="max-width: 250px;">
                                        <span class="span-checkbox">
                                            <input name="child_shop_table_catalog_ids[filter][is_public]" <?php if (Arr::path($data->values['child_shop_table_catalog_ids'], 'filter.is_public', 0) > 0) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
                                            Создать фильтры
                                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                        </span>
                                    </div>
                                </div>
                                <div class="row record-input record-list">
                                    <div class="col-md-3 record-title">
                                        <span>
                                            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                            Название
                                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                        </span>
                                    </div>
                                    <div class="col-md-9">
                                        <input name="child_shop_table_catalog_ids[filter][name]" type="text" class="form-control" placeholder="Название" value="<?php echo htmlspecialchars(Arr::path($data->values['child_shop_table_catalog_ids'], 'filter.name', 'Фильтры'));?>">
                                    </div>
                                </div>
                                <div class="row record-input record-list margin-t-15">
                                    <div class="col-md-3 record-title">
                                        <span>
                                            Доп. параметры
                                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                        </span>
                                    </div>
                                    <div class="col-md-9">
                                        <?php
                                        $view = View::factory('cabinet/35/_addition/options/fields');
                                        $view->siteData = $siteData;
                                        $view->data = $data;
                                        $view->optionsChild = 'shop_table_filter';
                                        echo Helpers_View::viewToStr($view);
                                        ?>
                                    </div>
                                </div>
                                <div class="row record-input record-list margin-t-15">
                                    <div class="col-md-3 record-title">
                                        <span>
                                            Название полей
                                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                        </span>
                                    </div>
                                    <div class="col-md-9">
                                        <table id="body_panel" class="table table-hover table-db margin-b-5">
                                            <tr>
                                                <th style="width: 200px;">
                                                    Название
                                                </th>
                                                <th>
                                                    Для клиента <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>Список фильтров</td>
                                                <td><input name="form_data[shop_table_filter][fields_title][name_list]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_filter.fields_title.name_list', 'фильтры '.$data->values['name']), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Один фильтр</td>
                                                <td><input name="form_data[shop_table_filter][fields_title][name_one]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_filter.fields_title.name_one', 'фильтр '.$data->values['name']), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Кнопка добавления</td>
                                                <td><input name="form_data[shop_table_filter][fields_title][button_add]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_filter.fields_title.button_add', 'добавить фильтр'), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Название</td>
                                                <td><input name="form_data[shop_table_filter][fields_title][name]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_filter.fields_title.name', 'Название'), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Рубрика</td>
                                                <td><input name="form_data[shop_table_filter][fields_title][rubric]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_filter.fields_title.rubric', 'Рубрика'), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Описание</td>
                                                <td><input name="form_data[shop_table_filter][fields_title][text]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_filter.fields_title.text', 'Описание'), ENT_QUOTES);?>"></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="tab3-2">
                                <div class="row record-input record-list margin-t-15">
                                    <div class="col-md-3 record-title">
                                                <span>
                                                    Доп. параметры
                                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                                </span>
                                    </div>
                                    <div class="col-md-9">
                                        <?php
                                        $view = View::factory('cabinet/35/_addition/options/fields');
                                        $view->siteData = $siteData;
                                        $view->data = $data;
                                        $view->optionsChild = 'shop_table_filter_rubric';
                                        echo Helpers_View::viewToStr($view);
                                        ?>
                                    </div>
                                </div>
                                <div class="row record-input record-list margin-t-15">
                                    <div class="col-md-3 record-title">
                                                <span>
                                                    Название полей
                                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                                </span>
                                    </div>
                                    <div class="col-md-9">
                                        <table id="body_panel" class="table table-hover table-db margin-b-5">
                                            <tr>
                                                <th style="width: 200px;">
                                                    Название
                                                </th>
                                                <th>
                                                    Для клиента <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>Список рубрик</td>
                                                <td><input name="form_data[shop_table_filter_rubric][fields_title][name_list]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_filter_rubric.fields_title.name_list', 'рубрики фильтров '.$data->values['name']), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Одна рубрика</td>
                                                <td><input name="form_data[shop_table_filter_rubric][fields_title][name_one]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_filter_rubric.fields_title.name_one', 'рубрика фильтров '.$data->values['name']), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Кнопка добавления</td>
                                                <td><input name="form_data[shop_table_filter_rubric][fields_title][button_add]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_filter_rubric.fields_title.button_add', 'добавить рубрику'), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Название</td>
                                                <td><input name="form_data[shop_table_filter_rubric][fields_title][name]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_filter_rubric.fields_title.name', 'Название'), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Родитель</td>
                                                <td><input name="form_data[shop_table_filter_rubric][fields_title][root]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_filter_rubric.fields_title.root', 'Родитель '), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Описание</td>
                                                <td><input name="form_data[shop_table_filter_rubric][fields_title][text]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_filter_rubric.fields_title.text', 'Описание'), ENT_QUOTES);?>"></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab4">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab4-1" data-toggle="tab">Хэштеги доп. параметры</a></li>
                        <li><a href="#tab4-2" data-toggle="tab">Рубрика доп. параметры</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="tab4-1">
                            <div class="row record-input record-tab">
                                <div class="col-md-3 record-title"></div>
                                <div class="col-md-5" style="max-width: 250px;">
                                        <span class="span-checkbox">
                                            <input name="child_shop_table_catalog_ids[hashtag][is_public]" <?php if (Arr::path($data->values['child_shop_table_catalog_ids'], 'hashtag.is_public', 0) > 0) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
                                            Создать хэщтеги
                                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                        </span>
                                </div>
                            </div>
                            <div class="row record-input record-list">
                                <div class="col-md-3 record-title">
                                        <span>
                                            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                            Название
                                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                        </span>
                                </div>
                                <div class="col-md-9">
                                    <input name="child_shop_table_catalog_ids[hashtag][name]" type="text" class="form-control" placeholder="Название" value="<?php echo htmlspecialchars(Arr::path($data->values['child_shop_table_catalog_ids'], 'hashtag.name', 'Хэштеги'));?>">
                                </div>
                            </div>
                            <div class="row record-input record-list margin-t-15">
                                <div class="col-md-3 record-title">
                                        <span>
                                            Доп. параметры
                                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                        </span>
                                </div>
                                <div class="col-md-9">
                                    <?php
                                    $view = View::factory('cabinet/35/_addition/options/fields');
                                    $view->siteData = $siteData;
                                    $view->data = $data;
                                    $view->optionsChild = 'shop_table_hashtag';
                                    echo Helpers_View::viewToStr($view);
                                    ?>
                                </div>
                            </div>
                            <div class="row record-input record-list margin-t-15">
                                <div class="col-md-3 record-title">
                                        <span>
                                            Название полей
                                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                        </span>
                                </div>
                                <div class="col-md-9">
                                    <table id="body_panel" class="table table-hover table-db margin-b-5">
                                        <tr>
                                            <th style="width: 200px;">
                                                Название
                                            </th>
                                            <th>
                                                Для клиента <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                            </th>
                                        </tr>
                                        <tr>
                                            <td>Список хэштегов</td>
                                            <td><input name="form_data[shop_table_hashtag][fields_title][name_list]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_hashtag.form_data.fields_title.name_list', 'хэштеги '.$data->values['name']), ENT_QUOTES);?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Один хэштег</td>
                                            <td><input name="form_data[shop_table_hashtag][fields_title][name_one]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_hashtag.form_data.fields_title.name_one', 'хэштег '.$data->values['name']), ENT_QUOTES);?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Кнопка добавления</td>
                                            <td><input name="form_data[shop_table_hashtag][fields_title][button_add]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_hashtag.form_data.fields_title.button_add', 'добавить хэштег'), ENT_QUOTES);?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Название</td>
                                            <td><input name="form_data[shop_table_hashtag][fields_title][name]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_hashtag.form_data.fields_title.name', 'Название'), ENT_QUOTES);?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Рубрика</td>
                                            <td><input name="form_data[shop_table_hashtag][fields_title][rubric]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_hashtag.form_data.fields_title.rubric', 'Рубрика'), ENT_QUOTES);?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Описание</td>
                                            <td><input name="form_data[shop_table_hashtag][fields_title][text]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_hashtag.form_data.fields_title.text', 'Описание'), ENT_QUOTES);?>"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="tab4-2">
                            <div class="row record-input record-list margin-t-15">
                                <div class="col-md-3 record-title">
                                                <span>
                                                    Доп. параметры
                                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                                </span>
                                </div>
                                <div class="col-md-9">
                                    <?php
                                    $view = View::factory('cabinet/35/_addition/options/fields');
                                    $view->siteData = $siteData;
                                    $view->data = $data;
                                    $view->optionsChild = 'shop_table_hashtag_rubric';
                                    echo Helpers_View::viewToStr($view);
                                    ?>
                                </div>
                            </div>
                            <div class="row record-input record-list margin-t-15">
                                <div class="col-md-3 record-title">
                                                <span>
                                                    Название полей
                                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                                </span>
                                </div>
                                <div class="col-md-9">
                                    <table id="body_panel" class="table table-hover table-db margin-b-5">
                                        <tr>
                                            <th style="width: 200px;">
                                                Название
                                            </th>
                                            <th>
                                                Для клиента <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                            </th>
                                        </tr>
                                        <tr>
                                            <td>Список рубрик</td>
                                            <td><input name="form_data[shop_table_hashtag_rubric][fields_title][name_list]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_hashtag_rubric.fields_title.name_list', 'рубрики хэштегов '.$data->values['name']), ENT_QUOTES);?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Одна рубрика</td>
                                            <td><input name="form_data[shop_table_hashtag_rubric][fields_title][name_one]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_hashtag_rubric.fields_title.name_one', 'рубрика хэштегов '.$data->values['name']), ENT_QUOTES);?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Кнопка добавления</td>
                                            <td><input name="form_data[shop_table_hashtag_rubric][fields_title][button_add]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_hashtag_rubric.fields_title.button_add', 'добавить рубрику'), ENT_QUOTES);?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Название</td>
                                            <td><input name="form_data[shop_table_hashtag_rubric][fields_title][name]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_hashtag_rubric.fields_title.name', 'Название'), ENT_QUOTES);?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Родитель</td>
                                            <td><input name="form_data[shop_table_hashtag_rubric][fields_title][root]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_hashtag_rubric.fields_title.root', 'Родитель '), ENT_QUOTES);?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Описание</td>
                                            <td><input name="form_data[shop_table_hashtag_rubric][fields_title][text]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_hashtag_rubric.fields_title.text', 'Описание'), ENT_QUOTES);?>"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <div class="tab-pane" id="tab5">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab5-1" data-toggle="tab">Вид выделения доп. параметры</a></li>
                        <li><a href="#tab5-2" data-toggle="tab">Рубрика доп. параметры</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="tab5-1">
                            <div class="row record-input record-tab">
                                <div class="col-md-3 record-title"></div>
                                <div class="col-md-5" style="max-width: 250px;">
                                        <span class="span-checkbox">
                                            <input name="child_shop_table_catalog_ids[select][is_public]" <?php if (Arr::path($data->values['child_shop_table_catalog_ids'], 'select.is_public', 0) > 0) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
                                            Создать выделения
                                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                        </span>
                                </div>
                            </div>
                            <div class="row record-input record-list">
                                <div class="col-md-3 record-title">
                                        <span>
                                            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                            Название
                                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                        </span>
                                </div>
                                <div class="col-md-9">
                                    <input name="child_shop_table_catalog_ids[select][name]" type="text" class="form-control" placeholder="Название" value="<?php echo htmlspecialchars(Arr::path($data->values['child_shop_table_catalog_ids'], 'select.name', 'Выделения'));?>">
                                </div>
                            </div>
                            <div class="row record-input record-list margin-t-15">
                                <div class="col-md-3 record-title">
                                        <span>
                                            Доп. параметры
                                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                        </span>
                                </div>
                                <div class="col-md-9">
                                    <?php
                                    $view = View::factory('cabinet/35/_addition/options/fields');
                                    $view->siteData = $siteData;
                                    $view->data = $data;
                                    $view->optionsChild = 'shop_table_select';
                                    echo Helpers_View::viewToStr($view);
                                    ?>
                                </div>
                            </div>
                            <div class="row record-input record-list margin-t-15">
                                <div class="col-md-3 record-title">
                                        <span>
                                            Название полей
                                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                        </span>
                                </div>
                                <div class="col-md-9">
                                    <table id="body_panel" class="table table-hover table-db margin-b-5">
                                        <tr>
                                            <th style="width: 200px;">
                                                Название
                                            </th>
                                            <th>
                                                Для клиента <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                            </th>
                                        </tr>
                                        <tr>
                                            <td>Список видов выделения</td>
                                            <td><input name="form_data[shop_table_select][fields_title][name_list]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_select.form_data.fields_title.name_list', 'виды выделения '.$data->values['name']), ENT_QUOTES);?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Один вид выделения</td>
                                            <td><input name="form_data[shop_table_select][fields_title][name_one]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_select.form_data.fields_title.name_one', 'вид выделение '.$data->values['name']), ENT_QUOTES);?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Кнопка добавления</td>
                                            <td><input name="form_data[shop_table_select][fields_title][button_add]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_select.form_data.fields_title.button_add', 'добавить вид выделения'), ENT_QUOTES);?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Название</td>
                                            <td><input name="form_data[shop_table_select][fields_title][name]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_select.form_data.fields_title.name', 'Название'), ENT_QUOTES);?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Рубрика</td>
                                            <td><input name="form_data[shop_table_select][fields_title][rubric]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_select.form_data.fields_title.rubric', 'Рубрика'), ENT_QUOTES);?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Описание</td>
                                            <td><input name="form_data[shop_table_select][fields_title][text]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_select.form_data.fields_title.text', 'Описание'), ENT_QUOTES);?>"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab5-2">
                            <div class="row record-input record-list margin-t-15">
                                <div class="col-md-3 record-title">
                                                <span>
                                                    Доп. параметры
                                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                                </span>
                                </div>
                                <div class="col-md-9">
                                    <?php
                                    $view = View::factory('cabinet/35/_addition/options/fields');
                                    $view->siteData = $siteData;
                                    $view->data = $data;
                                    $view->optionsChild = 'shop_table_select_rubric';
                                    echo Helpers_View::viewToStr($view);
                                    ?>
                                </div>
                            </div>
                            <div class="row record-input record-list margin-t-15">
                                <div class="col-md-3 record-title">
                                                <span>
                                                    Название полей
                                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                                </span>
                                </div>
                                <div class="col-md-9">
                                    <table id="body_panel" class="table table-hover table-db margin-b-5">
                                        <tr>
                                            <th style="width: 200px;">
                                                Название
                                            </th>
                                            <th>
                                                Для клиента <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                            </th>
                                        </tr>
                                        <tr>
                                            <td>Список рубрик</td>
                                            <td><input name="form_data[shop_table_select_rubric][fields_title][name_list]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_select_rubric.fields_title.name_list', 'рубрики видов выделения '.$data->values['name']), ENT_QUOTES);?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Одна рубрика</td>
                                            <td><input name="form_data[shop_table_select_rubric][fields_title][name_one]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_select_rubric.fields_title.name_one', 'рубрика видов выделения '.$data->values['name']), ENT_QUOTES);?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Кнопка добавления</td>
                                            <td><input name="form_data[shop_table_select_rubric][fields_title][button_add]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_select_rubric.fields_title.button_add', 'добавить рубрику'), ENT_QUOTES);?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Название</td>
                                            <td><input name="form_data[shop_table_select_rubric][fields_title][name]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_select_rubric.fields_title.name', 'Название'), ENT_QUOTES);?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Родитель</td>
                                            <td><input name="form_data[shop_table_select_rubric][fields_title][root]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_select_rubric.fields_title.root', 'Родитель '), ENT_QUOTES);?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Описание</td>
                                            <td><input name="form_data[shop_table_select_rubric][fields_title][text]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_select_rubric.fields_title.text', 'Описание'), ENT_QUOTES);?>"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <div class="tab-pane" id="tab6">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab6-1" data-toggle="tab">Единицы измерения доп. параметры</a></li>
                            <li><a href="#tab6-2" data-toggle="tab">Рубрика доп. параметры</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane" id="tab6-1">
                                <div class="row record-input record-tab">
                                    <div class="col-md-3 record-title"></div>
                                    <div class="col-md-5" style="max-width: 250px;">
                                            <span class="span-checkbox">
                                                <input name="child_shop_table_catalog_ids[unit][is_public]" <?php if (Arr::path($data->values['child_shop_table_catalog_ids'], 'unit.is_public', 0) > 0) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
                                                Создать единицы измерения
                                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                            </span>
                                    </div>
                                </div>
                                <div class="row record-input record-list">
                                    <div class="col-md-3 record-title">
                                            <span>
                                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                                Название
                                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                            </span>
                                    </div>
                                    <div class="col-md-9">
                                        <input name="child_shop_table_catalog_ids[unit][name]" type="text" class="form-control" placeholder="Название" value="<?php echo htmlspecialchars(Arr::path($data->values['child_shop_table_catalog_ids'], 'unit.name', 'Единицы измерения'));?>">
                                    </div>
                                </div>
                                <div class="row record-input record-list margin-t-15">
                                    <div class="col-md-3 record-title">
                                            <span>
                                                Доп. параметры
                                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                            </span>
                                    </div>
                                    <div class="col-md-9">
                                        <?php
                                        $view = View::factory('cabinet/35/_addition/options/fields');
                                        $view->siteData = $siteData;
                                        $view->data = $data;
                                        $view->optionsChild = 'shop_table_unit';
                                        echo Helpers_View::viewToStr($view);
                                        ?>
                                    </div>
                                </div>
                                <div class="row record-input record-list margin-t-15">
                                    <div class="col-md-3 record-title">
                                            <span>
                                                Название полей
                                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                            </span>
                                    </div>
                                    <div class="col-md-9">
                                        <table id="body_panel" class="table table-hover table-db margin-b-5">
                                            <tr>
                                                <th style="width: 200px;">
                                                    Название
                                                </th>
                                                <th>
                                                    Для клиента <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>Список единиц измерения</td>
                                                <td><input name="form_data[shop_table_unit][fields_title][name_list]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_unit.form_data.fields_title.name_list', 'единицы измерения '.$data->values['name']), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Одна единица измерения</td>
                                                <td><input name="form_data[shop_table_unit][fields_title][name_one]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_unit.form_data.fields_title.name_one', 'единица измерения '.$data->values['name']), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Кнопка добавления</td>
                                                <td><input name="form_data[shop_table_unit][fields_title][button_add]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_unit.form_data.fields_title.button_add', 'добавить единицу измерения'), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Название</td>
                                                <td><input name="form_data[shop_table_unit][fields_title][name]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_unit.form_data.fields_title.name', 'Название'), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Рубрика</td>
                                                <td><input name="form_data[shop_table_unit][fields_title][rubric]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_unit.form_data.fields_title.rubric', 'Рубрика'), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Описание</td>
                                                <td><input name="form_data[shop_table_unit][fields_title][text]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_unit.form_data.fields_title.text', 'Описание'), ENT_QUOTES);?>"></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab6-2">
                                <div class="row record-input record-list margin-t-15">
                                    <div class="col-md-3 record-title">
                                                    <span>
                                                        Доп. параметры
                                                        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                                    </span>
                                    </div>
                                    <div class="col-md-9">
                                        <?php
                                        $view = View::factory('cabinet/35/_addition/options/fields');
                                        $view->siteData = $siteData;
                                        $view->data = $data;
                                        $view->optionsChild = 'shop_table_unit_rubric';
                                        echo Helpers_View::viewToStr($view);
                                        ?>
                                    </div>
                                </div>
                                <div class="row record-input record-list margin-t-15">
                                    <div class="col-md-3 record-title">
                                                    <span>
                                                        Название полей
                                                        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                                    </span>
                                    </div>
                                    <div class="col-md-9">
                                        <table id="body_panel" class="table table-hover table-db margin-b-5">
                                            <tr>
                                                <th style="width: 200px;">
                                                    Название
                                                </th>
                                                <th>
                                                    Для клиента <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>Список рубрик</td>
                                                <td><input name="form_data[shop_table_unit_rubric][fields_title][name_list]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_unit_rubric.fields_title.name_list', 'рубрики единиц измерения '.$data->values['name']), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Одна рубрика</td>
                                                <td><input name="form_data[shop_table_unit_rubric][fields_title][name_one]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_unit_rubric.fields_title.name_one', 'рубрика единиц измерения '.$data->values['name']), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Кнопка добавления</td>
                                                <td><input name="form_data[shop_table_unit_rubric][fields_title][button_add]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_unit_rubric.fields_title.button_add', 'добавить рубрику'), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Название</td>
                                                <td><input name="form_data[shop_table_unit_rubric][fields_title][name]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_unit_rubric.fields_title.name', 'Название'), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Родитель</td>
                                                <td><input name="form_data[shop_table_unit_rubric][fields_title][root]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_unit_rubric.fields_title.root', 'Родитель '), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Описание</td>
                                                <td><input name="form_data[shop_table_unit_rubric][fields_title][text]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_unit_rubric.fields_title.text', 'Описание'), ENT_QUOTES);?>"></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab7">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab7-1" data-toggle="tab">Подгалерея доп. параметры</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane" id="tab7-1">
                                <div class="row record-input record-tab">
                                    <div class="col-md-3 record-title"></div>
                                    <div class="col-md-5" style="max-width: 250px;">
                                        <label class="span-checkbox">
                                            <input name="child_shop_table_catalog_ids[child][is_public]" <?php if (Arr::path($data->values['child_shop_table_catalog_ids'], 'child.is_public', 0) > 0) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
                                            Создать подгалерею
                                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                        </label>
                                    </div>
                                </div>
                                <div class="row record-input record-list">
                                    <div class="col-md-3 record-title">
                                        <label>
                                            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                            Название
                                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                        </label>
                                    </div>
                                    <div class="col-md-9">
                                        <input name="child_shop_table_catalog_ids[child][name]" type="text" class="form-control" placeholder="Название" value="<?php echo htmlspecialchars(Arr::path($data->values['child_shop_table_catalog_ids'], 'child.name', 'Подгалереи'));?>">
                                    </div>
                                </div>
                                <div class="row record-input record-list margin-t-15">
                                    <div class="col-md-3 record-title">
                                        <label>
                                            Доп. параметры
                                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                        </label>
                                    </div>
                                    <div class="col-md-9">
                                        <?php
                                        $view = View::factory('cabinet/35/_addition/options/fields');
                                        $view->siteData = $siteData;
                                        $view->data = $data;
                                        $view->optionsChild = 'shop_table_child';
                                        echo Helpers_View::viewToStr($view);
                                        ?>
                                    </div>
                                </div>
                                <div class="row record-input record-list margin-t-15">
                                    <div class="col-md-3 record-title">
                                        <label>
                                            Название полей
                                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                        </label>
                                    </div>
                                    <div class="col-md-9">
                                        <table id="body_panel" class="table table-hover table-db margin-b-5">
                                            <tr>
                                                <th style="width: 200px;">
                                                    Название
                                                </th>
                                                <th>
                                                    Для клиента <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>Список подгалерей</td>
                                                <td><input name="form_data[shop_table_child][fields_title][name_list]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_child.form_data.fields_title.name_list', 'подгалереи '.$data->values['name']), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Один подгалерея</td>
                                                <td><input name="form_data[shop_table_child][fields_title][name_one]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_child.form_data.fields_title.name_one', 'подгалерея '.$data->values['name']), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Кнопка добавления</td>
                                                <td><input name="form_data[shop_table_child][fields_title][button_add]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_child.form_data.fields_title.button_add', 'добавить подгалерею'), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Название</td>
                                                <td><input name="form_data[shop_table_child][fields_title][name]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_child.form_data.fields_title.name', 'Название'), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Рубрика</td>
                                                <td><input name="form_data[shop_table_child][fields_title][rubric]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_child.form_data.fields_title.rubric', 'Рубрика'), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Описание</td>
                                                <td><input name="form_data[shop_table_child][fields_title][text]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_table_child.form_data.fields_title.text', 'Описание'), ENT_QUOTES);?>"></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php } ?>
        <?php if($siteData->superUserID > 0){ ?>
            <input name="shop_id" value="<?php echo $siteData->shopID; ?>">
        <?php } ?>
    </div>

    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>