<?php $isShow = (Request_RequestParams::getParamBoolean('is_show')) && !$siteData->operation->getIsAdmin(); ?>
<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th>Параметр выработки</th>
        <?php if(!$isShow){ ?>
        <th class="width-90"></th>
        <?php } ?>
    </tr>
    <tbody id="to-works">
    <?php
    foreach ($data['view::_shop/transport/to/work/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>
    </tbody>
</table>
<?php if(!$isShow){ ?>
<div class="modal-footer">
    <button type="button" class="btn btn-danger pull-left" onclick="addElement('new-to-work', 'to-works', true);">Добавить строчку</button>
</div>
<div id="new-to-work" data-index="0">
    <!--
    <tr>
        <td>
            <select name="shop_transport_to_works[_#index#][shop_transport_work_id]" class="form-control select2" style="width: 100%">
                <option value="0" data-id="0">Выберите значение</option>
                <?php echo $siteData->globalDatas['view::_shop/transport/work/list/list'];?>
            </select>
        </td>
        <td>
            <ul class="list-inline tr-button delete">
                <li><a href="#" data-action="remove-tr" data-parent-count="4" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            </ul>
        </td>  
    </tr>
    -->
</div>
<?php } ?>