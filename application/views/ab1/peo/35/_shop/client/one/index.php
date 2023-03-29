<tr>
    <td><?php echo $data->values['name']; ?></td>
    <td><?php echo $data->values['bin']; ?></td>
    <td><?php echo Func::getPriceStr($siteData->currency, $data->values['balance'], TRUE, FALSE); ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopclient/edit', array('id' => 'id'), array('is_show' => true), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Просмотр</a></li>
        </ul>
    </td>
</tr>
