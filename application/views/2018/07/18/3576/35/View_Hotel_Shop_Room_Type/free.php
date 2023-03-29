<tr>
    <td>
        <select data-name="shop_room_type_id" disabled data-select="<?php echo $data->id; ?>" data-name="shop_room_type_id" data-action="free-room-type" name="room_types[#index#][shop_room_type_id]" class="form-control select2" style="width: 100%;">
            <?php
            $s = 'data-id="'.$data->id.'"';
            echo str_replace($s, $s.' selected', $siteData->replaceDatas['view::View_Hotel_Shop_Room_Types\list']);
            ?>
        </select>
    <td data-id="human"><?php echo $data->values['human']; ?></td>
    <td>
        <select disabled data-name="adults" data-action="free-room-type" name="room_types[#index#][adults]" class="form-control select2" style="width: 100%;" <?php if($data->values['human_extra'] == 0){?>disabled<?php } ?>>
            <?php
            $select = $data->additionDatas['human_extra'];
            for ($i=0; $i <= $data->values['human_extra']; $i++){
                if ($i == $select){
                    echo '<option selected="selected">' . $i . '</option>';
                }else {
                    echo '<option>' . $i . '</option>';
                }
            }
            ?>
        </select>
    </td>
    <td>
        <select disabled data-name="childs" data-action="free-room-type" name="room_types[#index#][childs]" class="form-control select2" style="width: 100%;" <?php if($data->values['human_extra'] == 0){?>disabled<?php } ?>>
            <?php
            $select = $data->additionDatas['child_extra'];
            for ($i=0; $i <= $data->values['human_extra']; $i++){
                if ($i == $select){
                    echo '<option selected="selected">' . $i . '</option>';
                }else {
                    echo '<option>' . $i . '</option>';
                }
            }
            ?>
        </select>
    </td>
    <td data-id="amount" data-amount="<?php echo $data->additionDatas['amount']; ?>">
        <?php
        $diffDays = Helpers_DateTime::diffDays($data->additionDatas['date_to'], $data->additionDatas['date_from']) + 1;
        $amount = $data->additionDatas['amount'];
        echo '<b>'.Func::getPriceStr($siteData->currency, $amount). '</b> за '.Func::getCountElementStrRus($diffDays, 'дней','день', 'дня');
        ?>
    </td>
    <td>
        <button style="display: none" type="button" class="close" aria-label="Close" data-action="tr-delete-free">
            <span aria-hidden="true" class="fa fa-close"></span> удалить
        </button>
    </td>
</tr>