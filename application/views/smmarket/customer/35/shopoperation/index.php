<tr>
    <td><?php echo $data->id; ?></td>
    <td><?php echo $data->values['name']; ?></td>
    <td><?php echo $data->values['email']; ?></td>
    <td><?php echo Arr::path($data->values, 'options.phone', ''); ?></td>
    <td>
        <a href="/customer/shopoperation/edit?id=<?php echo $data->id; ?>" class="link-blue text-sm"><i class="fa fa-edit margin-r-5"></i> Изменить</a>
        <a href="/customer/shopoperation/del?id=<?php echo $data->id; ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a>
    </td>
</tr>
