<tr>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['created_at']); ?></td>
    <td><?php echo $data->values['number']; ?></td>
    <td><?php echo Func::getPriceStr($siteData->currency, $data->values['amount'], TRUE, FALSE); ?></td>
    <td>
        <ul class="list-inline tr-button">
            <li><a href="javascript:selectPayment(<?php echo $data->values['id']; ?>, '<?php echo $data->values['number']; ?>', '<?php echo Func::getFullURL($siteData, '/shoppayment/edit', array('id' => 'id'), array(), $data->values); ?>')" class="link-blue text-sm"><i class="fa fa-edit margin-r-5"></i> Выбрать</a></li>
        </ul>
    </td>
</tr>
