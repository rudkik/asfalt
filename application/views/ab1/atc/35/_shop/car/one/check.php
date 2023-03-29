<tr>
    <td><?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['created_at']); ?></td>
    <td><?php echo $data->values['name']; ?></td>
    <td><?php echo $data->getElementValue('shop_transport_id'); ?></td>
    <td><?php
        switch ($data->additionDatas['table_id']){
            case Model_Ab1_Shop_Car::TABLE_ID:
                echo 'Реализация';
                break;
            case Model_Ab1_Shop_Piece::TABLE_ID:
                echo 'ЖБИ и БС';
                break;
            case Model_Ab1_Shop_Move_Car::TABLE_ID:
                echo 'Перемещение';
                break;
            case Model_Ab1_Shop_Defect_Car::TABLE_ID:
                echo 'Брак';
                break;
            case Model_Ab1_Shop_Move_Other::TABLE_ID:
                echo 'Прочие перемещение';
                break;
            case Model_Ab1_Shop_Lessee_Car::TABLE_ID:
                echo 'Ответ.хранение';
                break;
            case Model_Ab1_Shop_Car_To_Material::TABLE_ID:
                echo 'Завоз материалов';
                break;
            case Model_Ab1_Shop_Ballast::TABLE_ID:
                echo 'Балласт';
                break;
            case Model_Ab1_Shop_Transportation::TABLE_ID:
                echo 'Перевозка в карьере';
                break;
            default:
                echo $data->additionDatas['table_id'];
        }
        ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a target="_blank" href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybill/index', array('shop_transport_id' => 'shop_transport_id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-list margin-r-5"></i> Путевые листы</a></li>
        </ul>
    </td>
</tr>
