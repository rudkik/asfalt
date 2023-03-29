<table id="body_panel" data-id="<?php echo count(Arr::path($data->values, 'options', array())); ?>" class="table table-hover table-db margin-bottom-5px">
    <tr>
        <th>
            Заголовок
        </th>
        <th>
            Название <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </th>
        <th class="tr-header-buttom-delete"></th>
    </tr>

    <?php
    if(key_exists('options', $data->values)) {
        $tmp = $data->values['options'];
    }else{
        $tmp = array();
    }
    foreach ($tmp as $index => $value):?>
        <tr>
            <td><input name="options[<?php echo $index;?>][title]" type="text" class="form-control" value="<?php echo $value['title'];?>"></td>
            <td><input name="options[<?php echo $index;?>][name]" type="text" class="form-control" value="<?php echo $value['field'];?>"></td>
            <td>
                <ul class="list-inline tr-button delete">
                    <li class="tr-remove"><a delete="tr" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                </ul>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<?php if (count(Arr::path($data->values, 'options', array())) == 0){ ?>
    <div id="div-not-options-options" class="contacts-list-msg text-center margin-bottom-5px">Параметры не заданы</div>
<?php }?>
<div class="text-right">
    <button type="button" class="btn btn-warning" onclick="actionAddTR('body_panel', 'tr_panel', 'div-not-options-options')"><i class="fa fa-fw fa-plus"></i> Добавить параметр</button>
</div>

<div hidden="hidden" id="tr_panel">
    <!--
<tr>
    <td><input name="options[#index#][title]" type="text" class="form-control"></td>
    <td><input name="options[#index#][name]" type="text" class="form-control"></td>
    <td>
        <ul class="list-inline tr-button delete">
            <li class="tr-remove"><a delete="tr" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
        </ul>
    </td>
</tr>
 -->
</div>
