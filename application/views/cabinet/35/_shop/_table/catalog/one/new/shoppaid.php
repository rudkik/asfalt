<div class="row">
    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab1" data-toggle="tab">Общая информация</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="tab1">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1-1" data-toggle="tab">Оплата</a></li>
                            <li><a href="#tab1-2" data-toggle="tab">Рубрика доп. параметры</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane" id="tab1-1">
                                <div class="row record-input record-tab">
                                    <div class="col-md-3 record-title"></div>
                                    <div class="col-md-5" style="max-width: 250px;">
                                        <span class="span-checkbox">
                                            <input name="is_public" value="1" checked type="checkbox" class="minimal">
                                            Показать вид оплат
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
                                        $view->optionsChild = 'shop_paid';
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
                                            <td>Список оплат</td>
                                            <td><input name="form_data[shop_paid][fields_title][name_list]" type="text" class="form-control" value="оплаты"></td>
                                        </tr>
                                        <tr>
                                            <td>Одна оплата</td>
                                            <td><input name="form_data[shop_paid][fields_title][name_one]" type="text" class="form-control" value="оплата"></td>
                                        </tr>
                                        <tr>
                                            <td>ФИО кто оплатил</td>
                                            <td><input name="form_data[shop_paid][fields_title][name]" type="text" class="form-control" value="ФИО кто оплатил"></td>
                                        </tr>
                                        <tr>
                                            <td>Магазин сделавший оплату</td>
                                            <td><input name="form_data[shop_paid][fields_title][paid_shop_id]" type="text" class="form-control" value="Магазин сделавший оплату"></td>
                                        </tr>
                                        <tr>
                                            <td>Оператор принявший оплату</td>
                                            <td><input name="form_data[shop_paid][fields_title][shop_operation_id]" type="text" class="form-control" value="Оператор принявший оплату"></td>
                                        </tr>
                                        <tr>
                                            <td>Вид оплаты</td>
                                            <td><input name="form_data[shop_paid][fields_title][shop_paid_type_id]" type="text" class="form-control" value="Вид оплаты"></td>
                                        </tr>
                                        <tr>
                                            <td>Способ оплаты</td>
                                            <td><input name="form_data[shop_paid][fields_title][paid_type_id]" type="text" class="form-control" value="Способ оплаты"></td>
                                        </tr>
                                        <tr>
                                            <td>Примечание</td>
                                            <td><input name="form_data[shop_paid][fields_title][text]" type="text" class="form-control" value="Примечание"></td>
                                        </tr>
                                        <tr>
                                            <td>Рубрика</td>
                                            <td><input name="form_data[shop_paid][fields_title][rubric]" type="text" class="form-control" value="Рубрика"></td>
                                        </tr>
                                        <tr>
                                            <td>Дата создания</td>
                                            <td><input name="form_data[shop_paid][fields_title][created_at]" type="text" class="form-control" value="Дата создания"></td>
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