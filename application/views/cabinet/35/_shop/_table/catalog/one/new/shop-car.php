<?php
$titles = Arr::path($data->values['form_data'], 'shop_car.fields_title', array());
?>
<div class="row">
    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab1" data-toggle="tab">Общая информация</a></li>
                <li><a href="#tab2" data-toggle="tab">Дополнительные параметры</a></li>
                <li><a href="#tab5" data-toggle="tab">Марки</a></li>
                <li><a href="#tab6" data-toggle="tab">Модели</a></li>
                <li><a href="#tab3" data-toggle="tab">Фильтры</a></li>
                <li><a href="#tab4" data-toggle="tab">Хэштеги</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="tab1">
                    <div class="box_data">
                        <div class="row record-input record-tab">
                            <div class="col-md-3 record-title"></div>
                            <div class="col-md-5" style="max-width: 250px;">
                                <label class="span-checkbox">
                                    <input name="is_public" value="1" checked type="checkbox" class="minimal">
                                    Показать вид машин
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
                                <input name="name" type="text" class="form-control" placeholder="Название"
                                       value="<?php echo htmlspecialchars(Arr::path($data->values, 'name', ''), ENT_QUOTES);?>">
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
                                $view->optionsChild = 'shop_car';
                                echo Helpers_View::viewToStr($view);
                                ?>
                            </div>
                        </div>
                        <div class="row record-input record-list margin-t-15">
                            <div class="col-md-3 record-title">
                                <label>
                                    Доп. параметры учавствующие в поиске
                                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <?php
                                $view = View::factory('cabinet/35/_addition/params/fields');
                                $view->siteData = $siteData;
                                $view->data = $data;
                                $view->paramsChild = 'shop_car';
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
                                        <td>Список машин</td>
                                        <td><input name="form_data[shop_car][fields_title][name_list]" type="text" class="form-control"
                                                   value="<?php echo htmlspecialchars(Arr::path($titles, 'name_list', 'машины'), ENT_QUOTES);?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Одна машина</td>
                                        <td><input name="form_data[shop_car][fields_title][name_one]" type="text" class="form-control"
                                            value="<?php echo htmlspecialchars(Arr::path($titles, 'name_one', 'машина'), ENT_QUOTES);?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Название</td>
                                        <td><input name="form_data[shop_car][fields_title][name]" type="text" class="form-control"
                                                   value="<?php echo htmlspecialchars(Arr::path($titles, 'name', 'Название'), ENT_QUOTES);?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Цена</td>
                                        <td><input name="form_data[shop_car][fields_title][price]" type="text" class="form-control"
                                                   value="<?php echo htmlspecialchars(Arr::path($titles, 'price', 'Цена'), ENT_QUOTES);?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Старая цена</td>
                                        <td><input name="form_data[shop_car][fields_title][price_old]" type="text" class="form-control"
                                                   value="<?php echo htmlspecialchars(Arr::path($titles, 'price_old', 'Старая цена'), ENT_QUOTES);?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Рубрика</td>
                                        <td><input name="form_data[shop_car][fields_title][rubric]" type="text" class="form-control"
                                                   value="<?php echo htmlspecialchars(Arr::path($titles, 'rubric', 'Рубрика'), ENT_QUOTES);?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Хэштеги</td>
                                        <td><input name="form_data[shop_car][fields_title][hashtag]" type="text" class="form-control"
                                                   value="<?php echo htmlspecialchars(Arr::path($titles, 'hashtag', 'Хэштеги'), ENT_QUOTES);?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Описание</td>
                                        <td><input name="form_data[shop_car][fields_title][text]" type="text" class="form-control"
                                                   value="<?php echo htmlspecialchars(Arr::path($titles, 'text', 'Описание'), ENT_QUOTES);?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Фильтры</td>
                                        <td><input name="form_data[shop_car][fields_title][filter]" type="text" class="form-control"
                                                   value="<?php echo htmlspecialchars(Arr::path($titles, 'filter', 'Фильтры'), ENT_QUOTES);?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Марка</td>
                                        <td><input name="form_data[shop_car][fields_title][mark]" type="text" class="form-control"
                                                   value="<?php echo htmlspecialchars(Arr::path($titles, 'mark', 'Марка'), ENT_QUOTES);?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Модель</td>
                                        <td><input name="form_data[shop_car][fields_title][model]" type="text" class="form-control"
                                                   value="<?php echo htmlspecialchars(Arr::path($titles, 'model', 'Модель'), ENT_QUOTES);?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Страна производства</td>
                                        <td><input name="form_data[shop_car][fields_title][production_land]" type="text" class="form-control"
                                                   value="<?php echo htmlspecialchars(Arr::path($titles, 'production_land', 'Страна производства'), ENT_QUOTES);?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Страна нахождения</td>
                                        <td><input name="form_data[shop_car][fields_title][location_land]" type="text" class="form-control"
                                                   value="<?php echo htmlspecialchars(Arr::path($titles, 'location_land', 'Страна нахождения'), ENT_QUOTES);?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Город нахождения</td>
                                        <td><input name="form_data[shop_car][fields_title][location_city]" type="text" class="form-control"
                                                   value="<?php echo htmlspecialchars(Arr::path($titles, 'location_city', 'Город нахождения'), ENT_QUOTES);?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Кнопка добавления</td>
                                        <td><input name="form_data[shop_car][fields_title][button_add]" type="text"
                                                   class="form-control" value="<?php echo htmlspecialchars(Arr::path($titles, 'button_add', 'добавить'), ENT_QUOTES);?>"></td>></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php
                    $view = View::factory('cabinet/35/_shop/_table/catalog/one/_shop-table-rubric');
                    $view->siteData = $siteData;
                    $view->data = $data;
                    $view->field = 'shop_table';
                    echo Helpers_View::viewToStr($view);
                    ?>
                </div>
                <div class="tab-pane" id="tab2">
                    <?php
                    $view = View::factory('cabinet/35/_addition/shop-table-params/fields');
                    $view->siteData = $siteData;
                    $view->data = $data;
                    echo Helpers_View::viewToStr($view);
                    ?>
                </div>
                <div class="tab-pane" id="tab5">
                    <?php
                    $view = View::factory('cabinet/35/_shop/_table/catalog/one/_shop-table-basic');
                    $view->siteData = $siteData;
                    $view->data = $data;
                    $view->objectName = 'mark';
                    $view->isTable = FALSE;
                    echo Helpers_View::viewToStr($view);
                    ?>
                </div>
                <div class="tab-pane" id="tab6">
                    <?php
                    $view = View::factory('cabinet/35/_shop/_table/catalog/one/_shop-table-basic');
                    $view->siteData = $siteData;
                    $view->data = $data;
                    $view->objectName = 'model';
                    $view->isTable = FALSE;
                    echo Helpers_View::viewToStr($view);
                    ?>
                </div>
                <div class="tab-pane" id="tab3">
                    <?php
                    $view = View::factory('cabinet/35/_shop/_table/catalog/one/_shop-table-basic');
                    $view->siteData = $siteData;
                    $view->data = $data;
                    $view->objectName = 'filter';
                    $view->isTable = TRUE;
                    echo Helpers_View::viewToStr($view);
                    ?>
                </div>
                <div class="tab-pane" id="tab4">
                    <?php
                    $view = View::factory('cabinet/35/_shop/_table/catalog/one/_shop-table-basic');
                    $view->siteData = $siteData;
                    $view->data = $data;
                    $view->objectName = 'hashtag';
                    $view->isTable = TRUE;
                    echo Helpers_View::viewToStr($view);
                    ?>
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