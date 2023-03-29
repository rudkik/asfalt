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
                            <li class="active"><a href="#tab1-1" data-toggle="tab">Возврат</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane" id="tab1-1">
                                <div class="row record-input record-tab">
                                    <div class="col-md-3 record-title"></div>
                                    <div class="col-md-5" style="max-width: 250px;">
                                        <span class="span-checkbox">
                                            <input name="is_public" <?php if ($data->values['is_public'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
                                            Показать вид возвратов
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
                                        $view->optionsChild = 'shop_return';
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
                                                <td>Список возвратов</td>
                                                <td><input name="form_data[shop_return][fields_title][name_list]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_return.fields_title.name_list', 'возвраты '.$data->values['name']), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Один возврат</td>
                                                <td><input name="form_data[shop_return][fields_title][name_one]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_return.fields_title.name_one', 'возврат '.$data->values['name']), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>ФИО</td>
                                                <td><input name="form_data[shop_return][fields_title][name]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_return.fields_title.name', 'ФИО'), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Магазин</td>
                                                <td><input name="form_data[shop_return][fields_title][shop_root_id]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_return.fields_title.shop_root_id', 'Магазин'), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Страна</td>
                                                <td><input name="form_data[shop_return][fields_title][country_id]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_return.fields_title.country_id', 'Страна'), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Город</td>
                                                <td><input name="form_data[shop_return][fields_title][city_id]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_return.fields_title.city_id', 'Город'), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Дата создания</td>
                                                <td><input name="form_data[shop_return][fields_title][created_at]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_return.fields_title.created_at', 'Дата создания'), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Кто создал</td>
                                                <td><input name="form_data[shop_return][fields_title][create_user_id]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_return.fields_title.create_user_id', 'Кто создал'), ENT_QUOTES);?>"></td>
                                            </tr>
                                            <tr>
                                            <tr>
                                                <td>Стоимость</td>
                                                <td><input name="form_data[shop_return][fields_title][amount]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values['form_data'], 'shop_return.fields_title.amount', 'Стоимость'), ENT_QUOTES);?>"></td>
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