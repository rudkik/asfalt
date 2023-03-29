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
                <li><a href="#tab7" data-toggle="tab">Подтовар</a></li>
                <li><a href="#tab8" data-toggle="tab">Хранилище (склады)</a></li>
                <li><a href="#tab9" data-toggle="tab">Ревизия (склада)</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="tab1">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1-1" data-toggle="tab">Товар</a></li>
                            <li><a href="#tab1-2" data-toggle="tab">Рубрика доп. параметры</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane" id="tab1-1">
                                <div class="row record-input record-tab">
                                    <div class="col-md-3 record-title"></div>
                                    <div class="col-md-5" style="max-width: 250px;">
                                        <span class="span-checkbox">
                                            <input name="is_public" value="1" checked type="checkbox" class="minimal">
                                            Показать вид товаров
                                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                        </span>
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
                                        <input name="name" type="text" class="form-control" placeholder="Название">
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
                                        $view->optionsChild = 'shop_good';
                                        echo Helpers_View::viewToStr($view);
                                        ?>
                                    </div>
                                </div>
                                <div class="row record-input record-list margin-t-15"">
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
                                            <td>Список товаров</td>
                                            <td><input name="form_data[shop_good][fields_title][name_list]" type="text" class="form-control" value="товары"></td>
                                        </tr>
                                        <tr>
                                            <td>Один товар</td>
                                            <td><input name="form_data[shop_good][fields_title][name_one]" type="text" class="form-control" value="товар"></td>
                                        </tr>
                                        <tr>
                                            <td>Название</td>
                                            <td><input name="form_data[shop_good][fields_title][name]" type="text" class="form-control" value="Название"></td>
                                        </tr>
                                        <tr>
                                            <td>Артикул</td>
                                            <td><input name="form_data[shop_good][fields_title][article]" type="text" class="form-control" value="Артикул"></td>
                                        </tr>
                                        <tr>
                                            <td>Кол-во на складе</td>
                                            <td><input name="form_data[shop_good][fields_title][storage_count]" type="text" class="form-control" value="Кол-во на складе"></td>
                                        </tr>
                                        <tr>
                                            <td>Цена</td>
                                            <td><input name="form_data[shop_good][fields_title][price]" type="text" class="form-control" value="Цена"></td>
                                        </tr>
                                        <tr>
                                            <td>Старая цена</td>
                                            <td><input name="form_data[shop_good][fields_title][price_old]" type="text" class="form-control" value="Старая цена"></td>
                                        </tr>
                                        <tr>
                                            <td>Дилерская цена</td>
                                            <td><input name="form_data[shop_good][fields_title][price_cost]" type="text" class="form-control" value="Дилерская цена"></td>
                                        </tr>
                                        <tr>
                                            <td>Единица измерения</td>
                                            <td><input name="form_data[shop_good][fields_title][unit]" type="text" class="form-control" value="Единица измерения"></td>
                                        </tr>
                                        <tr>
                                            <td>Тип выделения</td>
                                            <td><input name="form_data[shop_good][fields_title][select]" type="text" class="form-control" value="Тип выделения"></td>
                                        </tr>
                                        <tr>
                                            <td>Рубрика</td>
                                            <td><input name="form_data[shop_good][fields_title][rubric]" type="text" class="form-control" value="Рубрика"></td>
                                        </tr>
                                        <tr>
                                            <td>Рубрики</td>
                                            <td><input name="form_data[shop_good][fields_title][rubrics]" type="text" class="form-control" value="Рубрики"></td>
                                        </tr>
                                        <tr>
                                            <td>Хранилище</td>
                                            <td><input name="form_data[shop_good][fields_title][stock]" type="text" class="form-control" value="Хранилище"></td>
                                        </tr>
                                        <tr>
                                            <td>Рубрика хранилища</td>
                                            <td><input name="form_data[shop_good][fields_title][stock_rubric]" type="text" class="form-control" value="Склад"></td>
                                        </tr>
                                        <tr>
                                            <td>Штрихкод на складе</td>
                                            <td><input name="form_data[shop_good][fields_title][stock_name]" type="text" class="form-control" value="Штрихкод на складе"></td>
                                        </tr>
                                        <tr>
                                            <td>Бренд</td>
                                            <td><input name="form_data[shop_good][fields_title][brand]" type="text" class="form-control" value="Бренд"></td>
                                        </tr>
                                        <tr>
                                            <td>Хэштег</td>
                                            <td><input name="form_data[shop_good][fields_title][hashtag]" type="text" class="form-control" value="Хэштег"></td>
                                        </tr>
                                        <tr>
                                            <td>Описание</td>
                                            <td><input name="form_data[shop_good][fields_title][text]" type="text" class="form-control" value="Описание"></td>
                                        </tr>
                                        <tr>
                                            <td>Фильтры</td>
                                            <td><input name="form_data[shop_good][fields_title][filter]" type="text" class="form-control" value="Фильтры"></td>
                                        </tr>
                                        <tr>
                                            <td>Подобные товары / услуги</td>
                                            <td><input name="form_data[shop_good][fields_title][similar]" type="text" class="form-control" value="Подобные товары / услуги"></td>
                                        </tr>
                                        <tr>
                                            <td>Связанные товары</td>
                                            <td><input name="form_data[shop_good][fields_title][group_name]" type="text" class="form-control" value="Связанные товары"></td>
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
                                    <input name="form_data[shop_table_rubric][fields_title][title]" type="text" class="form-control" placeholder="Название" value="рубрики">
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
                                    $view->optionsChild = 'shop_table_rubric';
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
                                            <td>Список рубрик</td>
                                            <td><input name="form_data[shop_table_rubric][fields_title][name_list]" type="text" class="form-control" value="рубрики"></td>
                                        </tr>
                                        <tr>
                                            <td>Одна рубрика</td>
                                            <td><input name="form_data[shop_table_rubric][fields_title][name_one]" type="text" class="form-control" value="рубрика"></td>
                                        </tr>
                                        <tr>
                                            <td>Кнопка добавления</td>
                                            <td><input name="form_data[shop_table_rubric][fields_title][button_add]" type="text" class="form-control" value="добавить рубрику"></td>
                                        </tr>
                                        <tr>
                                            <td>Название</td>
                                            <td><input name="form_data[shop_table_rubric][fields_title][name]" type="text" class="form-control" value="Название"></td>
                                        </tr>
                                        <tr>
                                            <td>Родитель</td>
                                            <td><input name="form_data[shop_table_rubric][fields_title][root]" type="text" class="form-control" value="Родитель"></td>
                                        </tr>
                                        <tr>
                                            <td>Описание</td>
                                            <td><input name="form_data[shop_table_rubric][fields_title][text]" type="text" class="form-control" value="Описание"></td>
                                        </tr>
                                        <tr>
                                            <td>Бренд</td>
                                            <td><input name="form_data[shop_table_rubric][fields_title][brand]" type="text" class="form-control" value="Бренд"></td>
                                        </tr>
                                        <tr>
                                            <td>Единица измерения</td>
                                            <td><input name="form_data[shop_table_rubric][fields_title][unit]" type="text" class="form-control" value="Единица измерения"></td>
                                        </tr>
                                        <tr>
                                            <td>Тип выделения</td>
                                            <td><input name="form_data[shop_table_rubric][fields_title][select]" type="text" class="form-control" value="Тип выделения"></td>
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
                                        <label class="span-checkbox">
                                            <input name="child_shop_table_catalog_ids[brand][is_public]" value="0" type="checkbox" class="minimal">
                                            Создать бренд
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
                                        <input name="child_shop_table_catalog_ids[brand][name]" type="text" class="form-control" placeholder="Название" value="Бренд">
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
                                        $view->optionsChild = 'shop_table_brand';
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
                                                <td>Список брендов</td>
                                                <td><input name="form_data[shop_table_brand][fields_title][name_list]" type="text" class="form-control" value="бренды"></td>
                                            </tr>
                                            <tr>
                                                <td>Один бренд</td>
                                                <td><input name="form_data[shop_table_brand][fields_title][name_one]" type="text" class="form-control" value="бренд"></td>
                                            </tr>
                                            <tr>
                                                <td>Кнопка добавления</td>
                                                <td><input name="form_data[shop_table_brand][fields_title][button_add]" type="text" class="form-control" value="добавить бренд"></td>
                                            </tr>
                                            <tr>
                                                <td>Название</td>
                                                <td><input name="form_data[shop_table_brand][fields_title][name]" type="text" class="form-control" value="Название"></td>
                                            </tr>
                                            <tr>
                                                <td>Рубрика</td>
                                                <td><input name="form_data[shop_table_brand][fields_title][rubric]" type="text" class="form-control" value="Рубрика"></td>
                                            </tr>
                                            <tr>
                                                <td>Описание</td>
                                                <td><input name="form_data[shop_table_brand][fields_title][text]" type="text" class="form-control" value="Описание"></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="tab2-2">
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
                                        $view->optionsChild = 'shop_table_brand_rubric';
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
                                                <td>Список рубрик</td>
                                                <td><input name="form_data[shop_table_brand_rubric][fields_title][name_list]" type="text" class="form-control" value="рубрики брендов"></td>
                                            </tr>
                                            <tr>
                                                <td>Одна рубрика</td>
                                                <td><input name="form_data[shop_table_brand_rubric][fields_title][name_one]" type="text" class="form-control" value="рубрика брендов"></td>
                                            </tr>
                                            <tr>
                                                <td>Кнопка добавления</td>
                                                <td><input name="form_data[shop_table_brand_rubric][fields_title][button_add]" type="text" class="form-control" value="добавить рубрику"></td>
                                            </tr>
                                            <tr>
                                                <td>Название</td>
                                                <td><input name="form_data[shop_table_brand_rubric][fields_title][name]" type="text" class="form-control" value="Название"></td>
                                            </tr>
                                            <tr>
                                                <td>Родитель</td>
                                                <td><input name="form_data[shop_table_brand_rubric][fields_title][root]" type="text" class="form-control" value="Родитель "></td>
                                            </tr>
                                            <tr>
                                                <td>Описание</td>
                                                <td><input name="form_data[shop_table_brand_rubric][fields_title][text]" type="text" class="form-control" value="Описание"></td>
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
                                        <label class="span-checkbox">
                                            <input name="child_shop_table_catalog_ids[filter][is_public]" value="0" type="checkbox" class="minimal">
                                            Создать фильтр
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
                                        <input name="child_shop_table_catalog_ids[filter][name]" type="text" class="form-control" placeholder="Название" value="Фильтры">
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
                                        $view->optionsChild = 'shop_table_filter';
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
                                                <td>Список фильтров</td>
                                                <td><input name="form_data[shop_table_filter][fields_title][name_list]" type="text" class="form-control" value="фильтры"></td>
                                            </tr>
                                            <tr>
                                                <td>Один фильтр</td>
                                                <td><input name="form_data[shop_table_filter][fields_title][name_one]" type="text" class="form-control" value="фильтр"></td>
                                            </tr>
                                            <tr>
                                                <td>Кнопка добавления</td>
                                                <td><input name="form_data[shop_table_filter][fields_title][button_add]" type="text" class="form-control" value="добавить фильтр"></td>
                                            </tr>
                                            <tr>
                                                <td>Название</td>
                                                <td><input name="form_data[shop_table_filter][fields_title][name]" type="text" class="form-control" value="Название"></td>
                                            </tr>
                                            <tr>
                                                <td>Рубрика</td>
                                                <td><input name="form_data[shop_table_filter][fields_title][rubric]" type="text" class="form-control" value="Рубрика"></td>
                                            </tr>
                                            <tr>
                                                <td>Описание</td>
                                                <td><input name="form_data[shop_table_filter][fields_title][text]" type="text" class="form-control" value="Описание"></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab3-2">
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
                                        $view->optionsChild = 'shop_table_filter_rubric';
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
                                                <td>Список рубрик</td>
                                                <td><input name="form_data[shop_table_filter_rubric][fields_title][name_list]" type="text" class="form-control" value="рубрики фильтров"></td>
                                            </tr>
                                            <tr>
                                                <td>Одна рубрика</td>
                                                <td><input name="form_data[shop_table_filter_rubric][fields_title][name_one]" type="text" class="form-control" value="рубрика фильтров"></td>
                                            </tr>
                                            <tr>
                                                <td>Кнопка добавления</td>
                                                <td><input name="form_data[shop_table_filter_rubric][fields_title][button_add]" type="text" class="form-control" value="добавить рубрику"></td>
                                            </tr>
                                            <tr>
                                                <td>Название</td>
                                                <td><input name="form_data[shop_table_filter_rubric][fields_title][name]" type="text" class="form-control" value="Название"></td>
                                            </tr>
                                            <tr>
                                                <td>Родитель</td>
                                                <td><input name="form_data[shop_table_filter_rubric][fields_title][root]" type="text" class="form-control" value="Родитель"></td>
                                            </tr>
                                            <tr>
                                                <td>Описание</td>
                                                <td><input name="form_data[shop_table_filter_rubric][fields_title][text]" type="text" class="form-control" value="Описание"></td>
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
                                        <label class="span-checkbox">
                                            <input name="child_shop_table_catalog_ids[hashtag][is_public]" value="0" type="checkbox" class="minimal">
                                            Создать хэщтеги
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
                                        <input name="child_shop_table_catalog_ids[hashtag][name]" type="text" class="form-control" placeholder="Название" value="Хэштеги">
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
                                        $view->optionsChild = 'shop_table_hashtag';
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
                                                <td>Список хэштегов</td>
                                                <td><input name="form_data[shop_table_hashtag][fields_title][name_list]" type="text" class="form-control" value="хэштеги"></td>
                                            </tr>
                                            <tr>
                                                <td>Один хэштег</td>
                                                <td><input name="form_data[shop_table_hashtag][fields_title][name_one]" type="text" class="form-control" value="хэштег"></td>
                                            </tr>
                                            <tr>
                                                <td>Кнопка добавления</td>
                                                <td><input name="form_data[shop_table_hashtag][fields_title][button_add]" type="text" class="form-control" value="добавить хэштег"></td>
                                            </tr>
                                            <tr>
                                                <td>Название</td>
                                                <td><input name="form_data[shop_table_hashtag][fields_title][name]" type="text" class="form-control" value="Название"></td>
                                            </tr>
                                            <tr>
                                                <td>Рубрика</td>
                                                <td><input name="form_data[shop_table_hashtag][fields_title][rubric]" type="text" class="form-control" value="Рубрика"></td>
                                            </tr>
                                            <tr>
                                                <td>Описание</td>
                                                <td><input name="form_data[shop_table_hashtag][fields_title][text]" type="text" class="form-control" value="Описание"></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab4-2">
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
                                        $view->optionsChild = 'shop_table_hashtag_rubric';
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
                                                <td>Список рубрик</td>
                                                <td><input name="form_data[shop_table_hashtag_rubric][fields_title][name_list]" type="text" class="form-control" value="рубрики хэштегов"></td>
                                            </tr>
                                            <tr>
                                                <td>Одна рубрика</td>
                                                <td><input name="form_data[shop_table_hashtag_rubric][fields_title][name_one]" type="text" class="form-control" value="рубрика хэштегов"></td>
                                            </tr>
                                            <tr>
                                                <td>Кнопка добавления</td>
                                                <td><input name="form_data[shop_table_hashtag_rubric][fields_title][button_add]" type="text" class="form-control" value="добавить рубрику"></td>
                                            </tr>
                                            <tr>
                                                <td>Название</td>
                                                <td><input name="form_data[shop_table_hashtag_rubric][fields_title][name]" type="text" class="form-control" value="Название"></td>
                                            </tr>
                                            <tr>
                                                <td>Родитель</td>
                                                <td><input name="form_data[shop_table_hashtag_rubric][fields_title][root]" type="text" class="form-control" value="Родитель"></td>
                                            </tr>
                                            <tr>
                                                <td>Описание</td>
                                                <td><input name="form_data[shop_table_hashtag_rubric][fields_title][text]" type="text" class="form-control" value="Описание"></td>
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
                            <li class="active"><a href="#tab5-1" data-toggle="tab">Виды выделения доп. параметры</a></li>
                            <li><a href="#tab5-2" data-toggle="tab">Рубрика доп. параметры</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane" id="tab5-1">
                                <div class="row record-input record-tab">
                                    <div class="col-md-3 record-title"></div>
                                    <div class="col-md-5" style="max-width: 250px;">
                                        <label class="span-checkbox">
                                            <input name="child_shop_table_catalog_ids[hashtag][is_public]" value="0" type="checkbox" class="minimal">
                                            Создать виды выделения
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
                                        <input name="child_shop_table_catalog_ids[hashtag][name]" type="text" class="form-control" placeholder="Название" value="Виды выделения">
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
                                        $view->optionsChild = 'shop_table_hashtag';
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
                                                <td>Список видов выделения</td>
                                                <td><input name="form_data[shop_table_hashtag][fields_title][name_list]" type="text" class="form-control" value="виды выделения"></td>
                                            </tr>
                                            <tr>
                                                <td>Один вид выделения</td>
                                                <td><input name="form_data[shop_table_hashtag][fields_title][name_one]" type="text" class="form-control" value="вид выделения"></td>
                                            </tr>
                                            <tr>
                                                <td>Кнопка добавления</td>
                                                <td><input name="form_data[shop_table_hashtag][fields_title][button_add]" type="text" class="form-control" value="добавить вид выделения"></td>
                                            </tr>
                                            <tr>
                                                <td>Название</td>
                                                <td><input name="form_data[shop_table_hashtag][fields_title][name]" type="text" class="form-control" value="Название"></td>
                                            </tr>
                                            <tr>
                                                <td>Рубрика</td>
                                                <td><input name="form_data[shop_table_hashtag][fields_title][rubric]" type="text" class="form-control" value="Рубрика"></td>
                                            </tr>
                                            <tr>
                                                <td>Описание</td>
                                                <td><input name="form_data[shop_table_hashtag][fields_title][text]" type="text" class="form-control" value="Описание"></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab5-2">
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
                                        $view->optionsChild = 'shop_table_hashtag_rubric';
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
                                                <td>Список рубрик</td>
                                                <td><input name="form_data[shop_table_hashtag_rubric][fields_title][name_list]" type="text" class="form-control" value="рубрики видов выделения"></td>
                                            </tr>
                                            <tr>
                                                <td>Одна рубрика</td>
                                                <td><input name="form_data[shop_table_hashtag_rubric][fields_title][name_one]" type="text" class="form-control" value="рубрика видов выделения"></td>
                                            </tr>
                                            <tr>
                                                <td>Кнопка добавления</td>
                                                <td><input name="form_data[shop_table_hashtag_rubric][fields_title][button_add]" type="text" class="form-control" value="добавить рубрику"></td>
                                            </tr>
                                            <tr>
                                                <td>Название</td>
                                                <td><input name="form_data[shop_table_hashtag_rubric][fields_title][name]" type="text" class="form-control" value="Название"></td>
                                            </tr>
                                            <tr>
                                                <td>Родитель</td>
                                                <td><input name="form_data[shop_table_hashtag_rubric][fields_title][root]" type="text" class="form-control" value="Родитель"></td>
                                            </tr>
                                            <tr>
                                                <td>Описание</td>
                                                <td><input name="form_data[shop_table_hashtag_rubric][fields_title][text]" type="text" class="form-control" value="Описание"></td>
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
                                        <label class="span-checkbox">
                                            <input name="child_shop_table_catalog_ids[unit][is_public]" value="0" type="checkbox" class="minimal">
                                            Создать единицы измерения
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
                                        <input name="child_shop_table_catalog_ids[unit][name]" type="text" class="form-control" placeholder="Название" value="Единицы измерения">
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
                                        $view->optionsChild = 'shop_table_unit';
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
                                                <td>Список единиц измерения</td>
                                                <td><input name="form_data[shop_table_unit][fields_title][name_list]" type="text" class="form-control" value="единицы измерения"></td>
                                            </tr>
                                            <tr>
                                                <td>Одна единица измерения</td>
                                                <td><input name="form_data[shop_table_unit][fields_title][name_one]" type="text" class="form-control" value="единица измерения"></td>
                                            </tr>
                                            <tr>
                                                <td>Кнопка добавления</td>
                                                <td><input name="form_data[shop_table_unit][fields_title][button_add]" type="text" class="form-control" value="добавить единицу измерения"></td>
                                            </tr>
                                            <tr>
                                                <td>Название</td>
                                                <td><input name="form_data[shop_table_unit][fields_title][name]" type="text" class="form-control" value="Название"></td>
                                            </tr>
                                            <tr>
                                                <td>Рубрика</td>
                                                <td><input name="form_data[shop_table_unit][fields_title][rubric]" type="text" class="form-control" value="Рубрика"></td>
                                            </tr>
                                            <tr>
                                                <td>Описание</td>
                                                <td><input name="form_data[shop_table_unit][fields_title][text]" type="text" class="form-control" value="Описание"></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab6-2">
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
                                        $view->optionsChild = 'shop_table_unit_rubric';
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
                                                <td>Список рубрик</td>
                                                <td><input name="form_data[shop_table_unit_rubric][fields_title][name_list]" type="text" class="form-control" value="рубрики единиц измерения"></td>
                                            </tr>
                                            <tr>
                                                <td>Одна рубрика</td>
                                                <td><input name="form_data[shop_table_unit_rubric][fields_title][name_one]" type="text" class="form-control" value="рубрика единиц измерения"></td>
                                            </tr>
                                            <tr>
                                                <td>Кнопка добавления</td>
                                                <td><input name="form_data[shop_table_unit_rubric][fields_title][button_add]" type="text" class="form-control" value="добавить рубрику"></td>
                                            </tr>
                                            <tr>
                                                <td>Название</td>
                                                <td><input name="form_data[shop_table_unit_rubric][fields_title][name]" type="text" class="form-control" value="Название"></td>
                                            </tr>
                                            <tr>
                                                <td>Родитель</td>
                                                <td><input name="form_data[shop_table_unit_rubric][fields_title][root]" type="text" class="form-control" value="Родитель"></td>
                                            </tr>
                                            <tr>
                                                <td>Описание</td>
                                                <td><input name="form_data[shop_table_unit_rubric][fields_title][text]" type="text" class="form-control" value="Описание"></td>
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
                            <li class="active"><a href="#tab7-1" data-toggle="tab">Подтовары доп. параметры</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane" id="tab7-1">
                                <div class="row record-input record-tab">
                                    <div class="col-md-3 record-title"></div>
                                    <div class="col-md-5" style="max-width: 250px;">
                                        <label class="span-checkbox">
                                            <input name="child_shop_table_catalog_ids[hashtag][is_public]" value="0" type="checkbox" class="minimal">
                                            Создать подтовар
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
                                        <input name="child_shop_table_catalog_ids[hashtag][name]" type="text" class="form-control" placeholder="Название" value="Подтовары">
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
                                        $view->optionsChild = 'shop_table_hashtag';
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
                                                <td>Список подтоваров</td>
                                                <td><input name="form_data[shop_table_hashtag][fields_title][name_list]" type="text" class="form-control" value="подтовары"></td>
                                            </tr>
                                            <tr>
                                                <td>Один подтовар</td>
                                                <td><input name="form_data[shop_table_hashtag][fields_title][name_one]" type="text" class="form-control" value="подтовар"></td>
                                            </tr>
                                            <tr>
                                                <td>Кнопка добавления</td>
                                                <td><input name="form_data[shop_table_hashtag][fields_title][button_add]" type="text" class="form-control" value="добавить подтовар"></td>
                                            </tr>
                                            <tr>
                                                <td>Название</td>
                                                <td><input name="form_data[shop_table_hashtag][fields_title][name]" type="text" class="form-control" value="Название"></td>
                                            </tr>
                                            <tr>
                                                <td>Рубрика</td>
                                                <td><input name="form_data[shop_table_hashtag][fields_title][rubric]" type="text" class="form-control" value="Рубрика"></td>
                                            </tr>
                                            <tr>
                                                <td>Описание</td>
                                                <td><input name="form_data[shop_table_hashtag][fields_title][text]" type="text" class="form-control" value="Описание"></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab8">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab8-1" data-toggle="tab">Хранилище доп. параметры</a></li>
                        <li><a href="#tab8-2" data-toggle="tab">Рубрика доп. параметры</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="tab2-1">
                            <div class="row record-input record-tab">
                                <div class="col-md-3 record-title"></div>
                                <div class="col-md-5" style="max-width: 250px;">
                                    <label class="span-checkbox">
                                        <input name="child_shop_table_catalog_ids[stock][is_public]" value="0" type="checkbox" class="minimal">
                                        Создать хранилище
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
                                    <input name="child_shop_table_catalog_ids[stock][name]" type="text" class="form-control" placeholder="Название" value="Хранилища">
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
                                    $view->optionsChild = 'shop_table_stock';
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
                                            <td>Список хранилищ</td>
                                            <td><input name="form_data[shop_table_stock][fields_title][name_list]" type="text" class="form-control" value="хранилища"></td>
                                        </tr>
                                        <tr>
                                            <td>Одно хранилище</td>
                                            <td><input name="form_data[shop_table_stock][fields_title][name_one]" type="text" class="form-control" value="хранилище"></td>
                                        </tr>
                                        <tr>
                                            <td>Кнопка добавления</td>
                                            <td><input name="form_data[shop_table_stock][fields_title][button_add]" type="text" class="form-control" value="добавить бренд"></td>
                                        </tr>
                                        <tr>
                                            <td>Название</td>
                                            <td><input name="form_data[shop_table_stock][fields_title][name]" type="text" class="form-control" value="Название"></td>
                                        </tr>
                                        <tr>
                                            <td>Штрихкод</td>
                                            <td><input name="form_data[shop_table_stock][fields_title][barcode]" type="text" class="form-control" value="Штрихкод"></td>
                                        </tr>
                                        <tr>
                                            <td>Родитель</td>
                                            <td><input name="form_data[shop_table_stock][fields_title][root]" type="text" class="form-control" value="Родитель "></td>
                                        </tr>
                                        <tr>
                                            <td>Рубрика</td>
                                            <td><input name="form_data[shop_table_stock][fields_title][rubric]" type="text" class="form-control" value="Рубрика"></td>
                                        </tr>
                                        <tr>
                                            <td>Описание</td>
                                            <td><input name="form_data[shop_table_stock][fields_title][text]" type="text" class="form-control" value="Описание"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="tab8-2">
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
                                    $view->optionsChild = 'shop_table_stock_rubric';
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
                                            <td>Список рубрик</td>
                                            <td><input name="form_data[shop_table_stock_rubric][fields_title][name_list]" type="text" class="form-control" value="рубрики хранилищ"></td>
                                        </tr>
                                        <tr>
                                            <td>Одна рубрика</td>
                                            <td><input name="form_data[shop_table_stock_rubric][fields_title][name_one]" type="text" class="form-control" value="рубрика хранилищ"></td>
                                        </tr>
                                        <tr>
                                            <td>Кнопка добавления</td>
                                            <td><input name="form_data[shop_table_stock_rubric][fields_title][button_add]" type="text" class="form-control" value="добавить рубрику"></td>
                                        </tr>
                                        <tr>
                                            <td>Название</td>
                                            <td><input name="form_data[shop_table_stock_rubric][fields_title][name]" type="text" class="form-control" value="Название"></td>
                                        </tr>
                                        <tr>
                                            <td>Родитель</td>
                                            <td><input name="form_data[shop_table_stock_rubric][fields_title][root]" type="text" class="form-control" value="Родитель "></td>
                                        </tr>
                                        <tr>
                                            <td>Описание</td>
                                            <td><input name="form_data[shop_table_stock_rubric][fields_title][text]" type="text" class="form-control" value="Описание"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <div class="tab-pane" id="tab9">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab9-1" data-toggle="tab">Ревизия доп. параметры</a></li>
                            <li><a href="#tab9-2" data-toggle="tab">Рубрика доп. параметры</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane" id="tab2-1">
                                <div class="row record-input record-tab">
                                    <div class="col-md-3 record-title"></div>
                                    <div class="col-md-5" style="max-width: 250px;">
                                        <label class="span-checkbox">
                                            <input name="child_shop_table_catalog_ids[revision][is_public]" value="0" type="checkbox" class="minimal">
                                            Создать ревизию
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
                                        <input name="child_shop_table_catalog_ids[revision][name]" type="text" class="form-control" placeholder="Название" value="Ревизия">
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
                                        $view->optionsChild = 'shop_table_revision';
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
                                                <td>Список ревизий</td>
                                                <td><input name="form_data[shop_table_revision][fields_title][name_list]" type="text" class="form-control" value="ревизии"></td>
                                            </tr>
                                            <tr>
                                                <td>Одна ревизия</td>
                                                <td><input name="form_data[shop_table_revision][fields_title][name_one]" type="text" class="form-control" value="ревизия"></td>
                                            </tr>
                                            <tr>
                                                <td>Кнопка добавления</td>
                                                <td><input name="form_data[shop_table_revision][fields_title][button_add]" type="text" class="form-control" value="добавить ревизию"></td>
                                            </tr>
                                            <tr>
                                                <td>Название</td>
                                                <td><input name="form_data[shop_table_revision][fields_title][name]" type="text" class="form-control" value="Название"></td>
                                            </tr>
                                            <tr>
                                                <td>Место на складе</td>
                                                <td><input name="form_data[shop_table_revision][fields_title][shop_table_stock_id]" type="text" class="form-control" value="Место на складе"></td>
                                            </tr>
                                            <tr>
                                                <td>Родитель</td>
                                                <td><input name="form_data[shop_table_revision][fields_title][root]" type="text" class="form-control" value="Родитель "></td>
                                            </tr>
                                            <tr>
                                                <td>Рубрика</td>
                                                <td><input name="form_data[shop_table_revision][fields_title][rubric]" type="text" class="form-control" value="Рубрика"></td>
                                            </tr>
                                            <tr>
                                                <td>Описание</td>
                                                <td><input name="form_data[shop_table_revision][fields_title][text]" type="text" class="form-control" value="Описание"></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="tab8-2">
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
                                        $view->optionsChild = 'shop_table_revision_rubric';
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
                                                <td>Список рубрик</td>
                                                <td><input name="form_data[shop_table_revision_rubric][fields_title][name_list]" type="text" class="form-control" value="рубрики хранилищ"></td>
                                            </tr>
                                            <tr>
                                                <td>Одна рубрика</td>
                                                <td><input name="form_data[shop_table_revision_rubric][fields_title][name_one]" type="text" class="form-control" value="рубрика хранилищ"></td>
                                            </tr>
                                            <tr>
                                                <td>Кнопка добавления</td>
                                                <td><input name="form_data[shop_table_revision_rubric][fields_title][button_add]" type="text" class="form-control" value="добавить рубрику"></td>
                                            </tr>
                                            <tr>
                                                <td>Название</td>
                                                <td><input name="form_data[shop_table_revision_rubric][fields_title][name]" type="text" class="form-control" value="Название"></td>
                                            </tr>
                                            <tr>
                                                <td>Родитель</td>
                                                <td><input name="form_data[shop_table_revision_rubric][fields_title][root]" type="text" class="form-control" value="Родитель "></td>
                                            </tr>
                                            <tr>
                                                <td>Описание</td>
                                                <td><input name="form_data[shop_table_revision_rubric][fields_title][text]" type="text" class="form-control" value="Описание"></td>
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
        <input name="table_id" value="<?php echo Request_RequestParams::getParamInt('table_id'); ?>">
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