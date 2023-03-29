<tr>
    <td><a href="<?php
        $arr = array(
            'shop_product_rubric_id' => $data->values['id'],
            'is_all_branch' => Request_RequestParams::getParamBoolean('is_all_branch'),
            'year' => Request_RequestParams::getParamInt('year'),
        );

        $shopClientID = Request_RequestParams::getParamInt('shop_client_id');
        if($shopClientID !== NULL){
            $arr['shop_client_id'] = $shopClientID;
            $arr['shop_client_name'] = Request_RequestParams::getParamStr('shop_client_name');
        }
        $arr['shop_branch_id'] = $siteData->shopID;
        echo Func::getFullURL($siteData, '/shopproduct/statistics', array(), $arr);
        ?>"><?php echo $data->values['name']; ?></a></td>
    <?php for ($i = 1; $i < 13; $i++){ ?>
        <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['quantities'][$i], TRUE, 3, FALSE); ?></td>
    <?php } ?>
</tr>
