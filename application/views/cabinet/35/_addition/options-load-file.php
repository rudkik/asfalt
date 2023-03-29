<table id="body_panel" data-id="<?php echo count(Arr::path($data->values, 'options', array())); ?>" class="table table-hover table-db margin-b-5">
    <tr>
        <th>
            Название <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </th>
        <th>
            Колонка в Excel-файле <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </th>
        <th>
            Значение по умолчанию <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </th>
        <th>
            Формула (<b>#field#</b>*3/5) <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </th>
        <th>
            Обязательное <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </th>
        <th>
            Соединять <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </th>
        <th class="tr-header-buttom-delete"></th>
    </tr>

    <?php
    if(key_exists('options', $data->values)) {
        $tmp = $data->values['options'];
    }else{
        $tmp = array();
    }

    foreach ($tmp as $index => $value):
        ?>
        <tr>
            <td>
                <select name="options[<?php echo $index;?>][field]" class="form-control select2" style="width: 100%;">
                    <?php
                    $s = 'data-id="'.Arr::path($value, 'field', '').'"';
                    echo trim(str_replace($s, $s.' selected', $siteData->replaceDatas['view::_shop/load/data/list/field-list']));
                    ?>
                </select>
            </td>
            <td><input name="options[<?php echo $index;?>][column]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($value, 'column', ''), ENT_QUOTES);?>"></td>
            <td><input name="options[<?php echo $index;?>][default]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($value, 'default', ''), ENT_QUOTES);?>"></td>
            <td><input name="options[<?php echo $index;?>][formula]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($value, 'formula', ''), ENT_QUOTES);?>"></td>
            <td>
                <input name="options[<?php echo $index;?>][is_check]" <?php $tmp1 = Arr::path($value, 'is_check', 0); if($tmp1 == 1){ echo 'value="1" checked';}else{echo 'value="0"';}?> data-id="1" type="checkbox" class="minimal">
            </td>
            <td>
                <input name="options[<?php echo $index;?>][is_join]" <?php $tmp1 = Arr::path($value, 'is_join', 0); if($tmp1 == 1){ echo 'value="1" checked';}else{echo 'value="0"';}?> data-id="1" type="checkbox" class="minimal">
            </td>
            <td>
                <ul class="list-inline tr-button delete">
                    <li class="tr-remove"><a delete="tr" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                </ul>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<?php if (count(Arr::path($data->values, 'options', array())) == 0){ ?>
    <div id="div-not-options-options" class="contacts-list-msg text-center margin-b-5">Параметры не заданы</div>
<?php }?>
<div class="text-right">
    <button type="button" class="btn btn-warning" onclick="actionAddTR('body_panel', 'tr_panel', 'div-not-options-options')"><i class="fa fa-fw fa-plus"></i> Добавить параметр</button>
</div>

<div hidden="hidden" id="tr_panel">
    <!--
<tr>
    <td>
        <select name="options[#index#][field]" class="form-control select2" style="width: 100%;">
            <?php echo trim($siteData->globalDatas['view::_shop/load/data/list/field-list']); ?>
        </select>
    </td>
    <td><input name="options[#index#][column]" type="text" class="form-control"></td>
    <td><input name="options[#index#][default]" type="text" class="form-control"></td>
    <td><input name="options[#index#][formula]" type="text" class="form-control"></td>
    <td>
        <input name="options[#index#][is_check]" value="0" data-id="1" type="checkbox" class="minimal">
    </td>
    <td>
        <input name="options[#index#][is_join]" value="0" data-id="1" type="checkbox" class="minimal">
    </td>
    <td>
        <ul class="list-inline tr-button delete">
            <li class="tr-remove"><a delete="tr" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
        </ul>
    </td>
</tr>
 -->
</div>
