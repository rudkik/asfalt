<table id="body_panel" data-id="<?php echo count($data['view::_shop/_table/filter/one/list-edit']->childs); ?>" class="table table-hover table-db margin-b-5">
    <tr>
        <th class="tr-header-rubric">Название</th>
        <th>Значение</th>
        <th class="tr-header-buttom-delete"></th>
    </tr>
    <?php
    foreach ($data['view::_shop/_table/filter/one/list-edit']->childs as $value){
        echo $value->str;
    }
    ?>
</table>
<?php if (count($data['view::_shop/_table/filter/one/list-edit']->childs) == 0){ ?>
    <div id="div-not-options-attr" class="contacts-list-msg text-center margin-b-5">Фильтры не заданы</div>
<?php }?>
<div class="text-right">
    <button type="button" class="btn btn-warning" onclick="actionAddTR('body_panel', 'tr_panel', 'div-not-options-attr')"><i class="fa fa-fw fa-plus"></i> Добавить фильтр</button>
</div>

<div hidden="hidden" id="tr_panel">
<!--
<tr>
    <td>
        <select name="shop_table_filters[-#index#][rubric]" type="attribute_catalog_ids" class="form-control select2" style="width: 100%;">
            <option value="0" data-id="0"></option>
            <?php echo trim($siteData->globalDatas['view::filter#_shop/_table/rubric/list/list']); ?>
        </select>
    </td>
    <td>
        <input type="attribute_names" list="attribute_names" name="shop_table_filters[-#index#][name]" type="text" class="form-control" value="">
    </td>
    <td>
        <ul class="list-inline tr-button delete">
            <li class="tr-remove"><a delete="tr" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
        </ul>
    </td>
</tr>
 -->
</div>

<?php echo trim($siteData->globalDatas['view::_shop/_table/rubric/list/data-list']); ?>
