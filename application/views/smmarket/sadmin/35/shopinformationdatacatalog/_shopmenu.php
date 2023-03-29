<?php if($isShowMenuAll || Func::isShopMenuVisible('shopinformationdatarubric/index?type='.$data->id, $siteData)){ ?>
<div style="margin-bottom: 5px;" class="form-group">
    <label style="font-weight: 400;">
        <input name="shop_menu[shopinformationdatarubric/index?type=<?php echo $data->id; ?>]" class="flat-red" type="checkbox" <?php if(Func::isShopMenu('shopinformationdatarubric/index?type='.$data->id, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Категории
    </label>
</div>
<?php } ?>

