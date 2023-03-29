<?php $isShow = (Request_RequestParams::getParamBoolean('is_show')) && !$siteData->operation->getIsAdmin(); ?>
<tr data-id="trailer-<?php echo $data->id; ?>">
    <td>
        <select data-id="shop_transport_id" name="shop_transport_waybill_trailers[<?php echo $data->id; ?>][shop_transport_id]" class="form-control select2" style="width: 100%" <?php if($isShow){?>disabled<?php }?> required>
            <option value="0" data-id="0">Выберите значение</option>
            <?php
            $tmp = 'data-id="'.$data->values['shop_transport_id'].'"';
            echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/transport/list/trailer']));
            ?>
        </select>
    </td>
    <?php if(!$isShow){?>
        <td>
            <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
                <li><a href="#" data-action="remove-tr" data-parent-count="4" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            </ul>
        </td>
    <?php }?>
</tr>