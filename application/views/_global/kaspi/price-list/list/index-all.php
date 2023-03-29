<?xml version="1.0" encoding="utf-8"?>
<kaspi_catalog date="string" xmlns="kaspiShopping" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="kaspiShopping http://kaspi.kz/kaspishopping.xsd">
    <company><?php echo htmlspecialchars($data->additionDatas['company'], ENT_XML1); ?></company>
    <merchantid><?php echo htmlspecialchars($data->additionDatas['merchantid'], ENT_XML1); ?></merchantid>
    <offers>
        <?php foreach ($data->childs as $child) { ?>
        <offer sku="<?php echo htmlspecialchars($child->values['article'], ENT_XML1); ?>">
            <model><?php echo htmlspecialchars(mb_substr(trim($child->values['name']), 0, 119), ENT_XML1); ?></model>
            <brand><?php echo htmlspecialchars($child->getElementValue('shop_brand_id'), ENT_XML1); ?></brand>
            <availabilities>
                <availability available="<?php if($child->values['is_public'] == 1){ ?>yes<?php }else{ ?>no<?php } ?>" storeId="PP1"/>
            </availabilities>
            <price><?php echo Func::getNumberStr($child->values['price'], false, 0); ?></price>
        </offer>
        <?php } ?>
    </offers>
</kaspi_catalog>