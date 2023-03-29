<h3>
    Договор №<b><?php echo $data->getElementValue('shop_client_contract_id', 'number');?></b>
    от <b><?php echo Helpers_DateTime::getDateFormatRus($data->getElementValue('shop_client_contract_id', 'from_at'));?>
        продукция <?php echo $data->getElementValue('shop_product_id');?></b>
    <?php if($data->values['discount'] != 0){?>
        скидка: <b><?php echo Func::getNumberStr($data->values['discount'], true, 2, false);?></b>
    <?php }else{?>
        цена: <b><?php echo Func::getNumberStr($data->values['price'], true, 2, false);?></b>
    <?php }?>
    тг
</h3>