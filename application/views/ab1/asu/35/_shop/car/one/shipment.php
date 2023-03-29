<tr id="<?php echo $data->id; ?>"<?php if(Arr::path($data->values['options'], 'is_not_overload', '') == 1){ echo ' class="b-red"';}?>>
    <td><?php echo Arr::path($data->values, 'name', '');?></td>
    <td><?php echo $data->getElementValue('shop_client_id'); ?></td>
    <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_product_id.name', ''); ?></td>
    <td <?php if($data->values['is_test']){ ?>style="background: #e47365 !important;"<?php } ?>><?php echo Func::getNumberStr($data->values['quantity'], true, 3).' '.Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_product_id.unit', ''); ?></td>
    <td>
        <button name="apply" onclick="sendApply(<?php echo $data->id; ?>);" class="btn bg-navy btn-flat margin-b-5">Начать загрузку</button>
        <button name="turn" onclick="sendTurn(<?php echo $data->id; ?>, 4, <?php echo $data->values['type']; ?>);" class="btn bg-purple btn-flat margin-b-5" style="display: none;">Загрузка завершена</button>
        <div class="btn-group">
            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                <span>Перенаправить </span>
                <span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu" style="font-size: 24px; font-weight: 700">
                <?php
                $s = str_replace('#id#', $data->id, $siteData->replaceDatas['view::_shop/turn/place/list/transfer']);
                if ($data->values['type'] == Model_Ab1_Shop_Move_Car::TABLE_ID){
                    $s = str_replace('/shopcar/', '/shopmovecar/', $s);
                }elseif ($data->values['type'] == Model_Ab1_Shop_Defect_Car::TABLE_ID){
                    $s = str_replace('/shopcar/', '/shopdefectcar/', $s);
                }
                echo $s;
                ?>
            </ul>
        </div>
    </td>
</tr>
