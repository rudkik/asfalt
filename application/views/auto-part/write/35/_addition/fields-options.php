<?php
if(empty($optionsName)){
    $optionsName = 'fields_options';
}
if(key_exists($optionsName, $data->values)) {
    $listOption = $data->values[$optionsName];
}else{
    $listOption = array();
}

if(!empty($optionsChild)) {
    if (key_exists($optionsChild, $listOption)) {
        $listOption = $listOption[$optionsChild];
    }else{
        $listOption = array();
    }
    $childName = '[' . $optionsChild . ']';
}else{
    $childName = '';
    $optionsChild = '';
}
?>

<table id="body_panel-<?php echo $optionsChild;?>" data-id="<?php echo count($listOption); ?>" class="table table-hover table-db margin-b-5">
    <tr>
        <th>
            Заголовок
        </th>
        <th>
            Название <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </th>
        <th>
            Тип поля <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </th>
        <th class="tr-header-buttom-delete"></th>
    </tr>

    <?php
    foreach ($listOption as $index => $value):
        ?>
        <tr>
            <td><input name="<?php echo $optionsName.$childName;?>[<?php echo $index;?>][title]" type="text" class="form-control" value="<?php echo htmlspecialchars($value['title'], ENT_QUOTES);?>"></td>
            <td><input name="<?php echo $optionsName.$childName;?>[<?php echo $index;?>][name]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($value, 'field', Arr::path($value, 'name', '')), ENT_QUOTES);?>"></td>
            <td>
                <select name="<?php echo $optionsName.$childName;?>[<?php echo $index;?>][type]" class="form-control select2" style="width: 100%;">
                    <option <?php $type = intval(Arr::path($value, 'type', 0));  if(($type == Model_Shop_Basic_Options::OPTIONS_TYPE_INPUT) || ($type == 0)){echo 'selected';} ?> value="<?php echo Model_Shop_Basic_Options::OPTIONS_TYPE_INPUT;?>" data-id="<?php echo Model_Shop_Basic_Options::OPTIONS_TYPE_INPUT;?>">Текстовое поле</option>
                    <option <?php if($type == Model_Shop_Basic_Options::OPTIONS_TYPE_TEXTAREA){echo 'selected';} ?> value="<?php echo Model_Shop_Basic_Options::OPTIONS_TYPE_TEXTAREA;?>" data-id="<?php echo Model_Shop_Basic_Options::OPTIONS_TYPE_TEXTAREA;?>">Многострочное поле</option>
                    <option <?php if($type == Model_Shop_Basic_Options::OPTIONS_TYPE_TEXTAREA_HTML){echo 'selected';} ?> value="<?php echo Model_Shop_Basic_Options::OPTIONS_TYPE_TEXTAREA_HTML;?>" data-id="<?php echo Model_Shop_Basic_Options::OPTIONS_TYPE_TEXTAREA_HTML;?>">HTML поле</option>
                    <option <?php if($type == Model_Shop_Basic_Options::OPTIONS_TYPE_CHECKBOX){echo 'selected';} ?> value="<?php echo Model_Shop_Basic_Options::OPTIONS_TYPE_CHECKBOX;?>" data-id="<?php echo Model_Shop_Basic_Options::OPTIONS_TYPE_CHECKBOX;?>">Чекбокс</option>
                    <option <?php if($type == Model_Shop_Basic_Options::OPTIONS_TYPE_MAP_YANDEX){echo 'selected';} ?> value="<?php echo Model_Shop_Basic_Options::OPTIONS_TYPE_MAP_YANDEX;?>" data-id="<?php echo Model_Shop_Basic_Options::OPTIONS_TYPE_MAP_YANDEX;?>">Карта Яндекса</option>
                    <option <?php if($type == Model_Shop_Basic_Options::OPTIONS_TYPE_FILE){echo 'selected';} ?> value="<?php echo Model_Shop_Basic_Options::OPTIONS_TYPE_FILE;?>" data-id="<?php echo Model_Shop_Basic_Options::OPTIONS_TYPE_FILE;?>">Файл</option>
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
<?php if (count($listOption) == 0){ ?>
    <div id="div-not-options-options-<?php echo $optionsChild;?>" class="contacts-list-msg text-center margin-b-5">Параметры не заданы</div>
<?php }?>
<div class="text-right">
    <button type="button" class="btn btn-warning" onclick="actionAddTR('body_panel-<?php echo $optionsChild;?>', 'tr_panel-<?php echo $optionsChild;?>', 'div-not-options-options-<?php echo $optionsChild;?>')"><i class="fa fa-fw fa-plus"></i> Добавить параметр</button>
</div>

<div hidden="hidden" id="tr_panel-<?php echo $optionsChild;?>">
    <!--
<tr>
    <td><input name="<?php echo $optionsName.$childName;?>[#index#][title]" type="text" class="form-control"></td>
    <td><input name="<?php echo $optionsName.$childName;?>[#index#][name]" type="text" class="form-control"></td>
    <td>
        <select name="<?php echo $optionsName.$childName;?>[#index#][type]" class="form-control select2" style="width: 100%;">
            <option selected value="<?php echo Model_Shop_Basic_Options::OPTIONS_TYPE_INPUT;?>" data-id="<?php echo Model_Shop_Basic_Options::OPTIONS_TYPE_INPUT;?>">Текстовое поле</option>
            <option value="<?php echo Model_Shop_Basic_Options::OPTIONS_TYPE_TEXTAREA;?>" data-id="<?php echo Model_Shop_Basic_Options::OPTIONS_TYPE_TEXTAREA;?>">Многострочное поле</option>
            <option value="<?php echo Model_Shop_Basic_Options::OPTIONS_TYPE_TEXTAREA_HTML;?>" data-id="<?php echo Model_Shop_Basic_Options::OPTIONS_TYPE_TEXTAREA_HTML;?>">HTML поле</option>
            <option value="<?php echo Model_Shop_Basic_Options::OPTIONS_TYPE_CHECKBOX;?>" data-id="<?php echo Model_Shop_Basic_Options::OPTIONS_TYPE_CHECKBOX;?>">Чекбокс</option>
            <option value="<?php echo Model_Shop_Basic_Options::OPTIONS_TYPE_MAP_YANDEX;?>" data-id="<?php echo Model_Shop_Basic_Options::OPTIONS_TYPE_MAP_YANDEX;?>">Карта Яндекса</option>
            <option value="<?php echo Model_Shop_Basic_Options::OPTIONS_TYPE_FILE;?>" data-id="<?php echo Model_Shop_Basic_Options::OPTIONS_TYPE_FILE;?>">Файл</option>
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
