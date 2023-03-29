
<tr>
    <td data-id="shop_attribute_rubric_id" >
    </td>
    <td>
        <select data-type="select2" data-action="attribute_type" name="shop_product_attributes[<?php echo $data->id; ?>][shop_attribute_type_id]" class="form-control select2" required style="width: 100%;" >
            <option value="0" data-id="0" data-rubric="">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/attribute/type/list/list']; ?>
        </select>
    </td>
    <td>
        <select data-type="select2"  name="shop_product_attributes[<?php echo $data->id; ?>][shop_attribute_id]" class="form-control select2" required style="width: 100%;" >
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/attribute/list/list']; ?>
        </select>
    </td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li class="tr-remove"><a href="" data-action="remove-tr" data-parent-count="4"  class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
        </ul>
    </td>
</tr>