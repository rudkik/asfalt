<tr>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['created_at']); ?></td>
    <td>
        <?php
        echo $data->getElementValue(
            'shop_branch_daughter_id',
            'name',
            $data->getElementValue(
                'shop_daughter_id',
                'name'
            )
        );
        ?>
        <?php echo $data->getElementValue('shop_subdivision_daughter_id', 'name'); ?>
        <?php echo $data->getElementValue('shop_heap_daughter_id', 'name'); ?>
    </td>
    <td>
        <?php
        echo $data->getElementValue(
            'shop_branch_receiver_id',
            'name',
            $data->getElementValue(
                'shop_client_material_id',
                'name'
            )
        );
        ?>
        <?php echo $data->getElementValue('shop_subdivision_receiver_id', 'name'); ?>
        <?php echo $data->getElementValue('shop_heap_receiver_id', 'name'); ?>
    </td>
    <td><?php echo $data->getElementValue('shop_material_id', 'name'); ?></td>
    <td class="text-right">
        <?php echo Func::getNumberStr($data->values['quantity'], false, 3, false); ?>
    </td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopcartomaterial/edit', array('id' => 'id'), array(), $data->values); ?>" class="link-blue text-sm"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
        </ul>
    </td>
</tr>
