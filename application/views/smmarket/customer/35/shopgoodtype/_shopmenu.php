<div class="form-group margin-bottom-20px"></div>
<?php if($isShowMenuAll || Func::isShopMenuVisible('shopgood/index?type='.$data->id, $siteData)){ ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[shopgood/index?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopgood/index?type='.$data->id, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> <b><?php echo Func::mb_strtoupper($data->values['name']); ?></b>
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
<?php } ?>

<?php if($isShowMenuAll || Func::isShopMenuVisible('shopgood/remarketing?type='.$data->id, $siteData)){ ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[shopgood/remarketing?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopgood/remarketing?type='.$data->id, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Ремаркетинг <?php echo Func::mb_strtoupper($data->values['name']); ?>
        </label>
    </div>
<?php } ?>
<?php if($isShowMenuAll || Func::isShopMenuVisible('shopgoodcatalog/index?type='.$data->id, $siteData)){ ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[shopgoodcatalog/index?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopgoodcatalog/index?type='.$data->id, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Рубрики <?php echo Func::mb_strtoupper($data->values['name']); ?>
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
<?php } ?>
<?php if($isShowMenuAll || Func::isShopMenuVisible('shopgoodcatalog/index-root?type='.$data->id, $siteData)){ ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[shopgoodcatalog/index?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopgoodcatalog/index-root?type='.$data->id, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Рубрики второго уровня <?php echo Func::mb_strtoupper($data->values['name']); ?>
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
<?php } ?>
<?php if($isShowMenuAll || Func::isShopMenuVisible('shopgoodcatalog/index-params?type='.$data->id, $siteData)){ ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[shopgoodcatalog/index-params?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopgoodcatalog-params/index?type='.$data->id, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Доп. параметры рубрик <?php echo Func::mb_strtoupper($data->values['name']); ?>
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
<?php } ?>
<?php if($isShowMenuAll || Func::isShopMenuVisible('shopattribute/index?type='.$data->id, $siteData)){ ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[shopattribute/index?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopattribute/index?type='.$data->id, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Атрибуты <?php echo Func::mb_strtoupper($data->values['name']); ?>
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
<?php } ?>

<?php if($isShowMenuAll || Func::isShopMenuVisible('shopattributegroup/index?type='.$data->id, $siteData)){ ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[shopattributegroup/index?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopattributegroup/index?type='.$data->id, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Группы атрибутов <?php echo Func::mb_strtoupper($data->values['name']); ?>
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
<?php } ?>


<?php if($isShowMenuAll || Func::isShopMenuVisible('shopgood/group?type='.$data->id, $siteData)){ ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[shopgood/group?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopgood/group?type='.$data->id, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Группы товаров <?php echo Func::mb_strtoupper($data->values['name']); ?>
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
<?php } ?>

<?php if($isShowMenuAll || Func::isShopMenuVisible('shopattributecatalog/index?type='.$data->id, $siteData)){ ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[shopattributecatalog/index?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopattributecatalog/index?type='.$data->id, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Рубрики атрибутов <?php echo Func::mb_strtoupper($data->values['name']); ?>
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
<?php } ?>
