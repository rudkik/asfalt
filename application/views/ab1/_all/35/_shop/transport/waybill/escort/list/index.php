<?php $isShow = (Request_RequestParams::getParamBoolean('is_show')) && !$siteData->operation->getIsAdmin(); ?>
<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th>Сопровождающее лицо</th>
        <?php if(!$isShow){ ?>
        <th class="width-90"></th>
        <?php } ?>
    </tr>
    <tbody id="escorts">
    <?php
    foreach ($data['view::_shop/transport/waybill/escort/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>
    </tbody>
</table>
<?php if(!$isShow){ ?>
<div class="modal-footer">
    <button type="button" class="btn btn-danger pull-left" onclick="addElement('new-escort', 'escorts', true);">Добавить строчку</button>
</div>
<div id="new-escort" data-index="0">
    <!--
    <tr>
        <td>
            <select name="shop_transport_waybill_escorts[_#index#][shop_worker_id]" class="form-control select2" style="width: 100%">
                <option value="0" data-id="0">Выберите значение</option>
                <?php echo $siteData->globalDatas['view::_shop/worker/list/list'];?>
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