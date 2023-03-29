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
                            <li class="active"><a href="#tab1-1" data-toggle="tab">Вопрос</a></li>
                            <li><a href="#tab1-2" data-toggle="tab">Рубрика доп. параметры</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane" id="tab1-1">
                                <div class="row record-input record-tab">
                                    <div class="col-md-3 record-title"></div>
                                    <div class="col-md-5" style="max-width: 250px;">
                                        <span class="span-checkbox">
                                            <input name="is_public" <?php if ($data->values['is_public'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
                                            Показать вид оплаты
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
                                        $view->optionsChild = 'shop_paid';
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
                                                <td>Список оплат</td>
                                                <td><input name="form_data[shop_paid][fields_title][name_list]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_paid.fields_title.name_list', 'оплаты '.$data->values['name']), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Одна оплата</td>
                                                <td><input name="form_data[shop_paid][fields_title][name_one]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_paid.fields_title.name_one', 'оплата '.$data->values['name']), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>ФИО кто оплатил</td>
                                                <td><input name="form_data[shop_paid][fields_title][name]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_paid.fields_title.name', 'ФИО кто оплатил'), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Магазин сделавший оплату</td>
                                                <td><input name="form_data[shop_paid][fields_title][paid_shop_id]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_paid.fields_title.paid_shop_id', 'Магазин сделавший оплату'), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Оператор принявший оплату</td>
                                                <td><input name="form_data[shop_paid][fields_title][shop_operation_id]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_paid.fields_title.shop_operation_id', 'Оператор принявший оплату'), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Вид оплаты</td>
                                                <td><input name="form_data[shop_paid][fields_title][shop_paid_type_id]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_paid.fields_title.shop_paid_type_id', 'Вид оплаты'), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Способ оплаты</td>
                                                <td><input name="form_data[shop_paid][fields_title][paid_type_id]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_paid.fields_title.paid_type_id', 'Способ оплаты'), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Примечание</td>
                                                <td><input name="form_data[shop_paid][fields_title][text]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_paid.fields_title.text', 'Примечание'), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Рубрика</td>
                                                <td><input name="form_data[shop_paid][fields_title][rubric]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_paid.fields_title.rubric', 'Рубрика'), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Дата создания</td>
                                                <td><input name="form_data[shop_paid][fields_title][created_at]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_paid.fields_title.created_at', 'Дата создания'), ENT_QUOTES);?>"></td>
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
                                            <td><input name="form_data[shop_table_rubric][fields_title][name_list]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_paid_rubric.fields_title.name_list', 'рубрики '.$data->values['name']), ENT_QUOTES);?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Одна рубрика</td>
                                            <td><input name="form_data[shop_table_rubric][fields_title][name_one]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_paid_rubric.fields_title.name_one', 'рубрика '.$data->values['name']), ENT_QUOTES);?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Кнопка добавления</td>
                                            <td><input name="form_data[shop_table_rubric][fields_title][button_add]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_paid_rubric.fields_title.button_add', 'добавить рубрику'), ENT_QUOTES);?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Название</td>
                                            <td><input name="form_data[shop_table_rubric][fields_title][name]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_paid_rubric.fields_title.name', 'Название'), ENT_QUOTES);?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Родитель</td>
                                            <td><input name="form_data[shop_table_rubric][fields_title][root]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_paid_rubric.fields_title.root', 'Родитель '), ENT_QUOTES);?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Описание</td>
                                            <td><input name="form_data[shop_table_rubric][fields_title][text]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_paid_rubric.fields_title.text', 'Описание'), ENT_QUOTES);?>"></td>
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