<div class="form-group margin-bottom-20px"></div>
<?php if($isShowMenuAll || Func::isShopMenuVisible('shopbranch/index?type='.$data->id, $siteData)){ ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[shopbranch/index?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopbranch/index?type='.$data->id, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> <b><?php echo Func::mb_strtoupper($data->values['name']); ?></b>
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
<?php } ?>
<?php if($isShowMenuAll || Func::isShopMenuVisible('shopbranchcatalog/index?type='.$data->id, $siteData)){ ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[shopbranchcatalog/index?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopbranchcatalog/index?type='.$data->id, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Рубрики <?php echo Func::mb_strtoupper($data->values['name']); ?>
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
<?php } ?>
<?php if($isShowMenuAll || Func::isShopMenuVisible('shopbranchcatalog/index-params?type='.$data->id, $siteData)){ ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[shopbranchcatalog/index-params?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopbranchcatalog/index-params?type='.$data->id, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Доп. параметры рубрик <?php echo Func::mb_strtoupper($data->values['name']); ?>
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
<?php } ?>
<?php if($isShowMenuAll || Func::isShopMenuVisible('shopbranchcatalog/index-root?type='.$data->id, $siteData)){ ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[shopbranchcatalog/index-root?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopbranchcatalog/index-root?type='.$data->id, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Рубрики второго уровня <?php echo Func::mb_strtoupper($data->values['name']); ?>
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
<?php } ?>