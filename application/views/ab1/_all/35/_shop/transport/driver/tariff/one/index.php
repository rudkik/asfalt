<?php $isShow = Request_RequestParams::getParamBoolean('is_show'); ?>
<tr>
    <td>
        <input name="shop_transport_driver_tariffs[<?php echo $data->id; ?>][date_from]" type="datetime" date-type="date" class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus($data->values['date_from']);?>">
    </td>
    <td>
        <input name="shop_transport_driver_tariffs[<?php echo $data->id; ?>][date_to]" type="datetime" date-type="date" class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus($data->values['date_to']);?>">
    </td>
    <td>
        <input data-type="money" data-fractional-length="3" name="shop_transport_driver_tariffs[<?php echo $data->id; ?>][quantity]" type="phone" class="form-control" value="<?php echo $data->values['quantity'];?>">
    </td>
    <td>
        <ul class="list-inline tr-button delete">
            <li><a href="#" data-action="remove-tr" data-parent-count="4" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
        </ul>
    </td>
    <td>
        <a target="_blank" href="<?php echo Func::getFullURL($siteData, '/shoptransport/calc_coefficient', array('id'), array(), $data->values);?>" class="btn bg-green">Пересчитать</a>
    </td>
</tr>