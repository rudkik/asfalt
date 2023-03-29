<div class="text-center">
    <button type="button" class="btn btn-warning" onclick="actionAddPanel('body_panel_shop_table_params', 'tr_panel_shop_table_params', 'div-not-shop_table_params-options')"><i class="fa fa-fw fa-plus"></i> Добавить параметры</button>
</div>
<?php
$maxIndex = 0;
$childs = $data->values['form_data'];
foreach ($childs as $name => $child){
    if (strpos($name, 'shop_table_param') === FALSE){
        continue;
    }
    $index = intval(str_replace('shop_table_param', '', $name));
    if ($maxIndex < $index){
        $maxIndex = $index;
    }
}?>
<div id="body_panel_shop_table_params" data-id="<?php echo $maxIndex; ?>">
<?php
foreach ($childs as $name => $child){
    if (strpos($name, 'shop_table_param') === FALSE){
        continue;
    }
    $index = intval(str_replace('shop_table_param', '', $name));
    $titles = Arr::path($child, 'fields_title', array());
    ?>
    <div class="box box-info" style="margin-top: 10px;">
        <div class="box-header with-border">
            <span>Параметр №<?php echo $index;?></span>
            <div class="box-title" style="width: calc(100% - 135px);margin-left: 10px;">
                <input name="child_shop_table_catalog_ids[param<?php echo $index;?>][name]" type="text" class="form-control" placeholder="Название" value="<?php echo htmlspecialchars(Arr::path($data->values['child_shop_table_catalog_ids'], 'param'.$index.'.name', ''));?>">
            </div>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
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
                    $view->optionsChild = 'shop_table_param'.$index;
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
                    $view->paramsChild = 'shop_table_param'.$index;
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
                            <td>Список</td>
                            <td><input name="form_data[shop_table_param<?php echo $index;?>][fields_title][name_list]" type="text"
                                       class="form-control" value="<?php echo htmlspecialchars(Arr::path($titles, 'name_list', ''), ENT_QUOTES);?>"></td>
                        </tr>
                        <tr>
                            <td>Один</td>
                            <td><input name="form_data[shop_table_param<?php echo $index;?>][fields_title][name_one]" type="text"
                                       class="form-control"  value="<?php echo htmlspecialchars(Arr::path($titles, 'name_list', ''), ENT_QUOTES);?>"></td>
                        </tr>
                        <tr>
                            <td>Кнопка добавления</td>
                            <td><input name="form_data[shop_table_param<?php echo $index;?>][fields_title][button_add]" type="text"
                                       class="form-control"  value="<?php echo htmlspecialchars(Arr::path($titles, 'button_add', 'добавить'), ENT_QUOTES);?>"></td>
                        </tr>
                        <tr>
                            <td>Название</td>
                            <td><input name="form_data[shop_table_param<?php echo $index;?>][fields_title][name]" type="text"
                                       class="form-control"  value="<?php echo htmlspecialchars(Arr::path($titles, 'name', 'Название'), ENT_QUOTES);?>"></td>
                        </tr>
                        <tr>
                            <td>Рубрика</td>
                            <td><input name="form_data[shop_table_param<?php echo $index;?>][fields_title][rubric]" type="text"
                                       class="form-control"  value="<?php echo htmlspecialchars(Arr::path($titles, 'rubric', 'Рубрика'), ENT_QUOTES);?>"></td>
                        </tr>
                        <tr>
                            <td>Описание</td>
                            <td><input name="form_data[shop_table_param<?php echo $index;?>][fields_title][text]" type="text"
                                       class="form-control"  value="<?php echo htmlspecialchars(Arr::path($titles, 'text', 'Описание'), ENT_QUOTES);?>"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</div>


<div hidden="hidden" id="tr_panel_shop_table_params">
<script>/*
    <div class="box box-info" style="margin-top: 10px;">
        <div class="box-header with-border">
            <span>Параметр №#number#</span>
            <div class="box-title" style="width: calc(100% - 135px);margin-left: 10px;">
                <input name="child_shop_table_catalog_ids[param#number#][name]" type="text" class="form-control" placeholder="Название">
            </div>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
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
                    $view->optionsChild = 'shop_table_param#number#';
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
                            <td>Список</td>
                            <td><input name="form_data[shop_table_param#number#][fields_title][name_list]" type="text"
                                       class="form-control" ></td>
                        </tr>
                        <tr>
                            <td>Один</td>
                            <td><input name="form_data[shop_table_param#number#][fields_title][name_one]" type="text"
                                       class="form-control" ></td>
                        </tr>
                        <tr>
                            <td>Кнопка добавления</td>
                            <td><input name="form_data[shop_table_param#number#][fields_title][button_add]" type="text"
                                       class="form-control" value="добавить"></td>
                        </tr>
                        <tr>
                            <td>Название</td>
                            <td><input name="form_data[shop_table_param#number#][fields_title][name]" type="text"
                                       class="form-control" value="Название"></td>
                        </tr>
                        <tr>
                            <td>Рубрика</td>
                            <td><input name="form_data[shop_table_param#number#][fields_title][rubric]" type="text"
                                       class="form-control" value="Рубрика"></td>
                        </tr>
                        <tr>
                            <td>Описание</td>
                            <td><input name="form_data[shop_table_param#number#][fields_title][text]" type="text"
                                       class="form-control" value="Описание"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
*/</script>
</div>
