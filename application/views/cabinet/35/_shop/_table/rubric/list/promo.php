<table id="body_panel_catalog" data-id="<?php echo count($data['view::_shop/_table/rubric/one/promo']->childs); ?>" class="table table-hover table-db margin-b-5">
    <tr>
        <th>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Рубрика
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </th>
        <th class="tr-header-buttom-delete"></th>
    </tr>

    <?php
    foreach ($data['view::_shop/_table/rubric/one/promo']->childs as $value) {
        echo $value->str;
    }
    ?>
</table>
<?php if (count($data['view::_shop/_table/rubric/one/promo']->childs) == 0){ ?>
    <div id="div-not-options-rubric" class="contacts-list-msg text-center margin-b-5">Рубрики не заданы</div>
<?php }?>
<div class="text-right">
    <button type="button" class="btn btn-warning" onclick="actionAddTR('body_panel_catalog', 'tr_panel_catalog', 'div-not-options-rubric')"><i class="fa fa-fw fa-plus"></i> Добавить рубрику</button>
</div>
<div hidden="hidden" id="tr_panel_catalog">
    <!--
<tr>
    <td>
        <select name="shop_table_rubric_ids[]" class="form-control select2" style="width: 100%;">
            <option value="-1" data-id="-1"></option>
            <?php echo $siteData->globalDatas['view::_shop/_table/rubric/list/list']; ?>
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

