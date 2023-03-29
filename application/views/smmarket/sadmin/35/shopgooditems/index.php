<div class="col-md-12">
    <label>Размеры в наличии</label>
</div>

<table id="body_panel_good_item" data-id="<?php echo count($data['view::shopgooditem/index']->childs); ?>" class="table table-hover table-db margin-bottom-5px">
    <tr>
        <th>Название</th>
        <th class="tr-header-date">Кол-во на складе</th>
        <th class="tr-header-buttom-delete"></th>
    </tr>
    <?php
    foreach ($data['view::shopgooditem/index']->childs as $value){
        echo $value->str;
    }
    ?>
</table>
<?php if (count($data['view::shopgooditem/index']->childs) == 0){ ?>
    <div id="div-not-options-items" class="contacts-list-msg text-center margin-bottom-5px">Размеры не заданы</div>
<?php }?>
<div class="text-right">
    <button type="button" class="btn btn-warning" onclick="actionAddTR('body_panel_good_item', 'tr_panel_good_item', 'div-not-options-items')"><i class="fa fa-fw fa-plus"></i> Добавить размер</button>
</div>

<div hidden="hidden" id="tr_panel_good_item">
    <!--
<tr>
    <td>
        <input name="good_item_names[]" type="text" class="form-control" value=""/>
    </td>
    <td>
        <input list="attribute_names" name="good_item_storage_counts[]" type="text" class="form-control" value=""  autocomplete="off">
    </td>
    <td>
        <input name="good_item_ids[]" hidden="hidden" value="0"/>
        <ul class="list-inline tr-button delete">
            <li class="tr-remove"><a delete="tr" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
        </ul>
    </td>
</tr>
 -->
</div>
