<tr>
    <td><?php echo $data->values['name']; ?></td>
    <td><?php echo $data->values['code']; ?></td>
    <td><?php echo $data->values['report_number']; ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/interface/edit', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
        </ul>
    </td>
</tr>
