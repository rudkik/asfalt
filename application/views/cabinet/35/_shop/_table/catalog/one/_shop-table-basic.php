<?php
$object = Arr::path($data->values['child_shop_table_catalog_ids'], $objectName, array());

if ($isTable == TRUE){
    $objectName = 'table_'.$objectName;
}
$titles = Arr::path($data->values['form_data'], 'shop_'.$objectName.'.fields_title', array());


?>
<div class="box_data">
    <div class="row record-input record-tab">
        <div class="col-md-3 record-title"></div>
        <div class="col-md-5" style="max-width: 250px;">
            <label class="span-checkbox">
                <input name="child_shop_table_catalog_ids[<?php echo $objectName; ?>][is_public]" <?php if (Arr::path($object, '.is_public', 0) > 0) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
                Создать
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
            <input name="child_shop_table_catalog_ids[<?php echo $objectName; ?>][name]" type="text" class="form-control"
                   placeholder="Название" value="<?php echo htmlspecialchars(Arr::path($object, '.name', ''));?>">
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
            $view->optionsChild = 'shop_'.$objectName;
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
            $view->paramsChild = 'shop_'.$objectName;
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
                    <td><input name="form_data[shop_<?php echo $objectName; ?>][fields_title][name_list]" type="text"
                               class="form-control" value="<?php echo htmlspecialchars(Arr::path($titles, 'name_list', ''), ENT_QUOTES);?>"></td>
                </tr>
                <tr>
                    <td>Один</td>
                    <td><input name="form_data[shop_<?php echo $objectName; ?>][fields_title][name_one]" type="text"
                               class="form-control" value="<?php echo htmlspecialchars(Arr::path($titles, 'name_one', ''), ENT_QUOTES);?>"></td>
                </tr>
                <tr>
                    <td>Кнопка добавления</td>
                    <td><input name="form_data[shop_<?php echo $objectName; ?>][fields_title][button_add]" type="text"
                               class="form-control" value="<?php echo htmlspecialchars(Arr::path($titles, 'button_add', 'добавить'), ENT_QUOTES);?>"></td>></td>
                </tr>
                <tr>
                    <td>Название</td>
                    <td><input name="form_data[shop_<?php echo $objectName; ?>][fields_title][name]" type="text"
                               class="form-control" value="<?php echo htmlspecialchars(Arr::path($titles, 'name', 'Название'), ENT_QUOTES);?>"></td>></td>
                </tr>
                <tr>
                    <td>Рубрика</td>
                    <td><input name="form_data[shop_<?php echo $objectName; ?>][fields_title][rubric]" type="text"
                               class="form-control" value="<?php echo htmlspecialchars(Arr::path($titles, 'rubric', 'Рубрика'), ENT_QUOTES);?>"></td>></td>
                </tr>
                <tr>
                    <td>Описание</td>
                    <td><input name="form_data[shop_<?php echo $objectName; ?>][fields_title][text]" type="text"
                               class="form-control" value="<?php echo htmlspecialchars(Arr::path($titles, 'text', 'Описание'), ENT_QUOTES);?>"></td>></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<?php
$view = View::factory('cabinet/35/_shop/_table/catalog/one/_shop-table-rubric');
$view->siteData = $siteData;
$view->data = $data;
$view->field = 'shop_'.$objectName;
echo Helpers_View::viewToStr($view);
?>