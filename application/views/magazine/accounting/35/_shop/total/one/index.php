<?php $dateTo = $siteData->urlParams['date_to']; ?>
<tr>
    <td>
        <a target="_blank" href="/accounting/shopproduct/history?shop_product_id=<?php echo $data->values['id']; ?>&created_at_from_equally=<?php echo $siteData->urlParams['date_from']; ?>&created_at_to_day=<?php echo $dateTo; ?>">
            <?php echo $data->values['name']; ?>
        </a><br>
        <?php echo $data->values['barcode']; ?>
    </td>
    <?php $tmp = Arr::path($data->additionDatas, 'stock_from', 0); ?>
    <td class="text-right <?php if($tmp < -0.0001){ echo 'text-red'; }?>">
        <?php if(empty($tmp)){ ?>
            <?php echo Func::getNumberStr($tmp, TRUE, 3, FALSE); ?>
        <?php }else{ ?>
            <a <?php if($tmp < -0.0001){ echo 'class="text-red"'; }?> target="_blank" href="/accounting/shopproduct/history?shop_product_id=<?php echo $data->values['id']; ?>&created_at_to=<?php echo $siteData->urlParams['date_from']; ?>">
                <?php echo Func::getNumberStr($tmp, TRUE, 3, FALSE); ?>
            </a>
        <?php } ?>
    </td>
    <?php $tmp = Arr::path($data->additionDatas, 'receive', 0); ?>
    <td class="text-right <?php if($tmp < -0.0001){ echo 'text-red'; }?>">
        <?php if(empty($tmp)){ ?>
            <?php echo Func::getNumberStr($tmp, TRUE, 3, FALSE); ?>
        <?php }else{ ?>
            <a <?php if($tmp < -0.0001){ echo 'class="text-red"'; }?> target="_blank" href="/accounting/shopproduct/history?shop_product_id=<?php echo $data->values['id']; ?>&created_at_from_equally=<?php echo $siteData->urlParams['date_from']; ?>&created_at_to_day=<?php echo $dateTo; ?>&operation[]=receive">
                <?php echo Func::getNumberStr($tmp, TRUE, 3, FALSE); ?>
            </a>
        <?php } ?>
    </td>
    <?php $tmp = Arr::path($data->additionDatas, 'move_receive', 0); ?>
    <td class="text-right <?php if($tmp < -0.0001){ echo 'text-red'; }?>">
        <?php if(empty($tmp)){ ?>
            <?php echo Func::getNumberStr($tmp, TRUE, 3, FALSE); ?>
        <?php }else{ ?>
            <a <?php if($tmp < -0.0001){ echo 'class="text-red"'; }?> target="_blank" href="/accounting/shopproduct/history?shop_product_id=<?php echo $data->values['id']; ?>&created_at_from_equally=<?php echo $siteData->urlParams['date_from']; ?>&created_at_to_day=<?php echo $dateTo; ?>&operation[]=receive">
                <?php echo Func::getNumberStr($tmp, TRUE, 3, FALSE); ?>
            </a>
        <?php } ?>
    </td>
    <?php $tmp = Arr::path($data->additionDatas, 'realization_return', 0); ?>
    <td class="text-right <?php if($tmp < -0.0001){ echo 'text-red'; }?>">
        <?php if(empty($tmp)){ ?>
            <?php echo Func::getNumberStr($tmp, TRUE, 3, FALSE); ?>
        <?php }else{ ?>
            <a <?php if($tmp < -0.0001){ echo 'class="text-red"'; }?> target="_blank" href="/accounting/shopproduct/history?shop_product_id=<?php echo $data->values['id']; ?>&created_at_from_equally=<?php echo $siteData->urlParams['date_from']; ?>&created_at_to_day=<?php echo $dateTo; ?>&operation[]=realization_return">
                <?php echo Func::getNumberStr($tmp, TRUE, 3, FALSE); ?>
            </a>
        <?php } ?>
    </td>
    <?php $tmp = Arr::path($data->additionDatas, 'realization', 0); ?>
    <td class="text-right <?php if($tmp < -0.0001){ echo 'text-red'; }?>">
        <?php if(empty($tmp)){ ?>
            <?php echo Func::getNumberStr($tmp, TRUE, 3, FALSE); ?>
        <?php }else{ ?>
            <a <?php if($tmp < -0.0001){ echo 'class="text-red"'; }?> target="_blank" href="/accounting/shopproduct/history?shop_product_id=<?php echo $data->values['id']; ?>&created_at_from_equally=<?php echo $siteData->urlParams['date_from']; ?>&created_at_to_day=<?php echo $dateTo; ?>&operation[]=realization">
                <?php echo Func::getNumberStr($tmp, TRUE, 3, FALSE); ?>
            </a>
        <?php } ?>
    </td>
    <?php $tmp = Arr::path($data->additionDatas, 'return', 0); ?>
    <td class="text-right <?php if($tmp < -0.0001){ echo 'text-red'; }?>">
        <?php if(empty($tmp)){ ?>
            <?php echo Func::getNumberStr($tmp, TRUE, 3, FALSE); ?>
        <?php }else{ ?>
            <a <?php if($tmp < -0.0001){ echo 'class="text-red"'; }?> target="_blank" href="/accounting/shopproduct/history?shop_product_id=<?php echo $data->values['id']; ?>&created_at_from_equally=<?php echo $siteData->urlParams['date_from']; ?>&created_at_to_day=<?php echo $dateTo; ?>&operation[]=return">
                <?php echo Func::getNumberStr($tmp, TRUE, 3, FALSE); ?>
            </a>
        <?php } ?>
    </td>
    <?php $tmp = Arr::path($data->additionDatas, 'move_expense', 0); ?>
    <td class="text-right <?php if($tmp < -0.0001){ echo 'text-red'; }?>">
        <?php if(empty($tmp)){ ?>
            <?php echo Func::getNumberStr($tmp, TRUE, 3, FALSE); ?>
        <?php }else{ ?>
            <a <?php if($tmp < -0.0001){ echo 'class="text-red"'; }?> target="_blank" href="/accounting/shopproduct/history?shop_product_id=<?php echo $data->values['id']; ?>&created_at_from_equally=<?php echo $siteData->urlParams['date_from']; ?>&created_at_to_day=<?php echo $dateTo; ?>&operation[]=move_expense">
                <?php echo Func::getNumberStr($tmp, TRUE, 3, FALSE); ?>
            </a>
        <?php } ?>
    </td>
    <?php $tmp = Arr::path($data->additionDatas, 'write_off', 0); ?>
    <td class="text-right <?php if($tmp < -0.0001){ echo 'text-red'; }?>">
        <?php if(empty($tmp)){ ?>
            <?php echo Func::getNumberStr($tmp, TRUE, 3, FALSE); ?>
        <?php }else{ ?>
            <a <?php if($tmp < -0.0001){ echo 'class="text-red"'; }?> target="_blank" href="/accounting/shopproduct/history?shop_product_id=<?php echo $data->values['id']; ?>&created_at_from_equally=<?php echo $siteData->urlParams['date_from']; ?>&created_at_to_day=<?php echo $dateTo; ?>&operation[]=write_off">
                <?php echo Func::getNumberStr($tmp, TRUE, 3, FALSE); ?>
            </a>
        <?php } ?>
    </td>
    <?php $tmp = Arr::path($data->additionDatas, 'adjustment', 0); ?>
    <td class="text-right <?php if($tmp < -0.0001){ echo 'text-red'; }?>">
        <?php if(empty($tmp)){ ?>
            <?php echo Func::getNumberStr($tmp, TRUE, 3, FALSE); ?>
        <?php }else{ ?>
            <a <?php if($tmp < -0.0001){ echo 'class="text-red"'; }?> target="_blank" href="/accounting/shopproduct/history?shop_product_id=<?php echo $data->values['id']; ?>&created_at_from_equally=<?php echo $siteData->urlParams['date_from']; ?>&created_at_to_day=<?php echo $dateTo; ?>&operation[]=adjustment">
                <?php echo Func::getNumberStr($tmp, TRUE, 3, FALSE); ?>
            </a>
        <?php } ?>
    </td>
    <?php $tmp = Arr::path($data->additionDatas, 'stock_to', 0); ?>
    <td class="text-right <?php if($tmp < -0.0001){ echo 'text-red'; }?>">
        <?php if(empty($tmp)){ ?>
            <?php echo Func::getNumberStr($tmp, TRUE, 3, FALSE); ?>
        <?php }else{ ?>
            <a <?php if($tmp < -0.0001){ echo 'class="text-red"'; }?> target="_blank" href="/accounting/shopproduct/history?shop_product_id=<?php echo $data->values['id']; ?>&created_at_to_day=<?php echo $dateTo; ?>">
                <?php echo Func::getNumberStr($tmp, TRUE, 3, FALSE); ?>
            </a>
        <?php } ?>
    </td>
</tr>