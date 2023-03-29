<?php $isShow = Request_RequestParams::getParamBoolean('is_show'); ?>
<tr data="trailer-<?php echo $data->id; ?>">
    <td data-id="name">
        <?php echo $data->values['name']; ?>
    </td>
    <td class="text-right" data-id="milage">
        <?php echo Arr::path($data->additionDatas, 'name', 'milage'); ?>
    </td>
</tr>