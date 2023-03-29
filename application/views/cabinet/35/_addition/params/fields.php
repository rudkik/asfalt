<?php
if(empty($paramsName)){
    $paramsName = 'fields_params';
}
if(key_exists($paramsName, $data->values)) {
    $listParam = $data->values[$paramsName];
}else{
    $listParam = array();
}

if(!empty($paramsChild)) {
    if (key_exists($paramsChild, $listParam)) {
        $listParam = $listParam[$paramsChild];
    }else{
        $listParam = array();
    }
    $childName = '[' . $paramsChild . ']';
}else{
    $childName = '';
    $paramsChild = '';
}
?>
<input name="<?php echo $paramsName.$childName;?>[-5000]" style="display: none;">
<table id="body_panel_params-<?php echo $paramsChild;?>" data-id="<?php echo count($listParam); ?>" class="table table-hover table-db margin-b-5">
    <tr>
        <th>
            Заголовок
        </th>
        <th>
            Номер (1,2,3) <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </th>
        <th>
            Тип поля <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </th>
        <th class="tr-header-buttom-delete"></th>
    </tr>

    <?php
    foreach ($listParam as $index => $value):
        ?>
        <tr>
            <td><input name="<?php echo $paramsName.$childName;?>[<?php echo $index;?>][title]" type="text" class="form-control" value="<?php echo htmlspecialchars($value['title'], ENT_QUOTES);?>"></td>
            <td><input name="<?php echo $paramsName.$childName;?>[<?php echo $index;?>][name]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($value, 'field', Arr::path($value, 'name', '')), ENT_QUOTES);?>"></td>
            <td>
                <select name="<?php echo $paramsName.$childName;?>[<?php echo $index;?>][type]" class="form-control select2" style="width: 100%;">
                    <option <?php $type = intval(Arr::path($value, 'type', 0));  if(($type == Model_Shop_Table_Basic_Table::PARAM_TYPE_INT) || ($type == 0)){echo 'selected';} ?> value="<?php echo Model_Shop_Table_Basic_Table::PARAM_TYPE_INT;?>" data-id="<?php echo Model_Shop_Table_Basic_Table::PARAM_TYPE_INT;?>">Целочисленное значение</option>
                    <option <?php if($type == Model_Shop_Table_Basic_Table::PARAM_TYPE_FLOAT){echo 'selected';} ?> value="<?php echo Model_Shop_Table_Basic_Table::PARAM_TYPE_FLOAT;?>" data-id="<?php echo Model_Shop_Table_Basic_Table::PARAM_TYPE_FLOAT;?>">Вещественное значение</option>
                    <option <?php if($type == Model_Shop_Table_Basic_Table::PARAM_TYPE_STR){echo 'selected';} ?> value="<?php echo Model_Shop_Table_Basic_Table::PARAM_TYPE_STR;?>" data-id="<?php echo Model_Shop_Table_Basic_Table::PARAM_TYPE_STR;?>">Строковое значение</option>
                </select>
            </td>
            <td>
                <ul class="list-inline tr-button delete">
                    <li class="tr-remove"><a delete="tr" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                </ul>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<?php if (count($listParam) == 0){ ?>
    <div id="div-not-params-params-<?php echo $paramsChild;?>" class="contacts-list-msg text-center margin-b-5">Параметры не заданы</div>
<?php }?>
<div class="text-right">
    <button type="button" class="btn btn-warning" onclick="actionAddTR('body_panel_params-<?php echo $paramsChild;?>', 'tr_panel_params-<?php echo $paramsChild;?>', 'div-not-params-params-<?php echo $paramsChild;?>')"><i class="fa fa-fw fa-plus"></i> Добавить параметр</button>
</div>

<div hidden="hidden" id="tr_panel_params-<?php echo $paramsChild;?>">
    <!--
<tr>
    <td><input name="<?php echo $paramsName.$childName;?>[#index#][title]" type="text" class="form-control"></td>
    <td><input name="<?php echo $paramsName.$childName;?>[#index#][name]" type="text" class="form-control"></td>
    <td>
        <select name="<?php echo $paramsName.$childName;?>[#index#][type]" class="form-control select2" style="width: 100%;">
            <option selected value="<?php echo Model_Shop_Table_Basic_Table::PARAM_TYPE_INT;?>" data-id="<?php echo Model_Shop_Table_Basic_Table::PARAM_TYPE_INT;?>">Целочисленное значение</option>
            <option value="<?php echo Model_Shop_Table_Basic_Table::PARAM_TYPE_FLOAT;?>" data-id="<?php echo Model_Shop_Table_Basic_Table::PARAM_TYPE_FLOAT;?>">Вещественное значение</option>
            <option value="<?php echo Model_Shop_Table_Basic_Table::PARAM_TYPE_STR;?>" data-id="<?php echo Model_Shop_Table_Basic_Table::PARAM_TYPE_STR;?>">Строковое значение</option>
        </select>
    </td>
    <td>
        <ul class="list-inline tr-button delete">
            <li class="tr-remove"><a delete="tr" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
        </ul>
    </td>
</tr>
 -->
</div>
