<tr data-price="<?php echo $data->values['price']; ?>">
    <td data-id="shop_room_id">
        <?php echo $data->values['name']; ?> (<?php echo $data->values['human']; ?> + <?php echo $data->values['human_extra']; ?>)
        <?php if($data->values['bedroom']){ ?>
            <img src="<?php echo $siteData->urlBasic; ?>/css/pyramid/img/bedroom/<?php echo $data->values['bedroom']; ?>.png">
        <?php } ?>
        <?php if($data->values['two_bedroom']){ ?>
            <img src="<?php echo $siteData->urlBasic; ?>/css/pyramid/img/two-bedroom/<?php echo $data->values['two_bedroom']; ?>.png">
        <?php } ?>
        <?php if($data->values['sofa']){ ?>
            <img src="<?php echo $siteData->urlBasic; ?>/css/pyramid/img/sofa/<?php echo $data->values['sofa']; ?>.png">
        <?php } ?>
    </td>
    <?php foreach ($data->additionDatas['date'] as $key => $val){ ?>
        <td <?php if($val['price'] == $data->values['price_feast']){ ?>style="background-color: #fffae3"<?php }if($val['is_holiday']){?>style="background-color: #E3F7FF"<?php }?> data-action="select"
            data-bill-id="<?php echo $val['bill_id']; ?>"
            data-date="<?php echo $key; ?>"
            data-id="<?php echo $data->values['id']; ?>"
            data-human="<?php echo Func::getNumberStr($data->values['human'], FALSE); ?>"
            data-human_extra="<?php echo Func::getNumberStr($data->values['human_extra'], FALSE); ?>"
            data-price="<?php echo Func::getNumberStr($val['price'], FALSE); ?>"
            data-price_extra="<?php echo Func::getNumberStr($data->values['price_extra'], FALSE); ?>"
            data-price_child="<?php echo Func::getNumberStr($data->values['price_child'], FALSE); ?>"
            <?php if($val['bill_id'] > 0){?>
                <?php if(Request_RequestParams::getParamInt('bill_id') == $val['bill_id']){?>
                    class="free active"
                <?php }else{?>
                    class="not-free"
                <?php }?>
            <?php }else{?>
                class="free"
            <?php }?>>
            <?php if($val['bill_id'] > 0){ echo '<b>'.$val['bill_id'] .'</b><br>'.'<b>'.$val['shop_client_name'] .'</b><br>';}?>
            <?php echo Func::getPriceStr($siteData->currency, $val['price']); ?>
        </td>
    <?php } ?>
</tr>