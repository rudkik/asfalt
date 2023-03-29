<tr>
    <td class="text-right">#index#</td>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['date']); ?></td>
    <td><?php echo $data->values['id']; ?></td>
    <td><?php echo $data->values['daughter']; ?></td>
    <td><?php echo $data->values['transport_company']; ?></td>
    <td><?php echo $data->values['number']; ?></td>
    <td><?php echo $data->values['heap_daughter']; ?></td>
    <td><?php echo $data->values['heap_receiver']; ?></td>
    <td><?php echo $data->values['product']; ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['brutto'],  true, 3, false); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['netto'],  true, 3, false); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['tare'],  true, 3, false); ?></td>
    <td>
        <?php
        switch ($data->values['table_id']){
            case Model_Ab1_Shop_Car::TABLE_ID:
                $prefix = 'car';
                break;
            case Model_Ab1_Shop_Piece::TABLE_ID:
                $prefix = 'piece';
                break;
            case Model_Ab1_Shop_Car_To_Material::TABLE_ID:
                $prefix = 'cartomaterial';
                break;
            default:
                $prefix = '';
        }
        if (!empty($prefix)) {
            ?>
            <ul class="list-inline tr-button delete">
                <li><a href="<?php echo Func::getFullURL($siteData, '/shop'.$prefix.'/edit', array('id' => 'id'), array('is_show' => true), $data->values, false, false, true); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Просмотр</a></li>
            </ul>
        <?php }?>
    </td>
</tr>
