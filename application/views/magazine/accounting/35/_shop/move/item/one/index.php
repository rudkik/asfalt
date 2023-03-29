<tr>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['created_at']); ?></td>
    <td>
        <span data-id="shop_product_name"><?php echo $data->getElementValue('shop_production_id'); ?></span>
        <input data-id="shop_production_id" name="shop_move_items[<?php echo $data->id; ?>][shop_production_id]" value="<?php echo $data->values['shop_production_id']; ?>" hidden>
    </td>
    <td>
        <div class="input-group">
            <div class="input-group-btn">
                <button data-action="count-plus" data-value="-1" data-count="count" data-parent-count="2" type="button" class="btn bg-green btn-flat">-</button>
            </div>
            <input data-id="count" name="shop_move_items[<?php echo $data->id; ?>][quantity]" type="tel" class="form-control text-center" placeholder="Кол-во" required value="<?php echo $data->values['quantity']; ?>">
            <div class="input-group-btn">
                <button data-action="count-plus"data-count="count" data-parent-count="2" type="button" class="btn bg-green btn-flat">+</button>
            </div>
        </div>
    </td>
    <td class="text-center">
        <ul class="list-inline tr-button delete">
            <li class="tr-remove"><a data-action="remove-tr" data-parent-count="4" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
        </ul>
    </td>
</tr>