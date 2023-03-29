<offer sku="<?php echo htmlspecialchars($data->values['article'], ENT_XML1); ?>">
    <model><?php echo htmlspecialchars(mb_substr(trim($child->values['name']), 0, 119), ENT_XML1); ?></model>
    <brand><?php echo htmlspecialchars($data->getElementValue('shop_brand_id'), ENT_XML1); ?></brand>
    <availabilities>
        <availability available="<?php if($data->values['is_public'] == 1){ ?>yes<?php }else{ ?>no<?php } ?>" storeId="PP1"/>
    </availabilities>
    <price><?php echo Func::getNumberStr($data->values['price'], false, 0); ?></price>
</offer>