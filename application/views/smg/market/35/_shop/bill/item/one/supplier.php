<p>
    <b><?php echo $data->getElementValue('shop_supplier_id', 'name', $data->values['name']); ?></b>
    <?php foreach ($data->additionDatas['childs'] as $child) { ?>
        <?php
        if(key_exists('integrations', $child)){
            $integrations = $child['integrations'];
        }else{
            $integrations = $data->getElementValue('shop_product_id', 'integrations', '[]');
        }
        $integrations = json_decode($integrations, true);
        if(!is_array($integrations)){
            $integrations = [$integrations];
        }

        $integrations = array_shift($integrations);?>
        <br><?php if(!empty($integrations)){echo '[' . $integrations . ']';} ?> <?php echo $child['name']; ?> - <?php echo Func::getNumberStr($child['quantity'], true, true); ?> шт.
    <?php } ?>
</p>