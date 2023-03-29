<tr>
    <td data-id="index" class="text-right">$index$</td>
    <td><?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['created_at']); ?></td>
    <td class="text-right">
        <?php echo Func::getNumberStr($data->values['quantity'] * $data->additionDatas['operation'], TRUE, 3, FALSE); ?>
    </td>
    <td class="text-right">
        <?php
        if(key_exists('price', $data->values)) {
            echo Func::getNumberStr($data->values['price'], TRUE, 2, FALSE);
        }
        ?>
    </td>
    <td class="text-right">
        <?php
        if(key_exists('amount', $data->values)) {
            echo Func::getNumberStr($data->values['amount'], TRUE, 2, FALSE);
        }
        ?>
    </td>
    <td>
        <?php
        switch ($data->additionDatas['type']){
            case 'receive':
                echo '<a target="_black"  href="/accounting/shopreceive/edit?id='.$data->values['shop_receive_id'].'">Приход</a>';
                break;
            case 'realization':
                switch ($data->values['is_special']){
                    case 1:
                        $s = 'Спецпродукт';
                        break;
                    case 2:
                        $s = $data->getElementValue('shop_write_off_type_id');
                        break;
                    default:
                        $s = 'Реализация';
                }

                echo '<a target="_black"  href="/accounting/shoprealization/edit?id='.$data->values['shop_realization_id'].'">'.$s.'</a>';
                break;
            case 'move':
                echo '<a target="_black" href="/accounting/shopmove/edit?id='.$data->values['shop_move_id'].'&shop_branch_id='.$data->values['shop_id'].'">Перемещение</a>';
                break;
        }
        ?>
    </td>
    <td>
        <?php
        switch ($data->additionDatas['type']){
            case 'receive':
                echo $data->getElementValue('shop_supplier_id');
                break;
            case 'realization':
                echo $data->getElementValue('shop_worker_id', 'name', 'Наличные');
                break;
            case 'move':
                echo  $data->getElementValue('shop_id') . ' => ' . $data->getElementValue('branch_move_id');
                break;
        }
        ?>
    </td>
</tr>