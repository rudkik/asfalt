<?php foreach ($data['view::_shop/client/one/list']->childs as $child) {?>
    <option value="<?php echo $child->values['id'];?>" data-id="<?php echo $child->values['id'];?>" data-amount="<?php echo Func::getPriceStr($siteData->currency, $child->values['balance'], TRUE, FALSE);?>" data-amount-int="<?php echo $child->values['balance'];?>"><?php echo $child->values['name']; if(!empty($child->values['bin'])){echo ' ('.$child->values['bin'].')';}?></option>
<?php }?>


