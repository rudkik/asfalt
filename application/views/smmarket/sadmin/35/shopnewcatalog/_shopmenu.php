<?php if(($isShowMenuAll || Func::isShopMenuVisible('shopnew/index?type='.$data->id, $siteData))
        || ($isShowMenuAll || Func::isShopMenuVisible('shopnewrubric/index?type='.$data->id, $siteData))){ ?>
    <div class="form-group margin-bottom-20px"></div>
    <?php if($isShowMenuAll || Func::isShopMenuVisible('shopnew/index?type='.$data->id, $siteData)){ ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shopnew/index?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopnew/index?type='.$data->id, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> <b><?php echo Func::mb_strtoupper($data->values['name']); ?></b>
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
    <?php } ?>
    <?php if($isShowMenuAll || Func::isShopMenuVisible('shopnew/select-type?type='.$data->id, $siteData)){ ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shopnew/select-type?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopnew/select-type?type='.$data->id, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Вид выделения в <?php echo Func::mb_strtoupper($data->values['name']); ?>
            </label>
        </div>
    <?php } ?>
    <?php if($isShowMenuAll || Func::isShopMenuVisible('shopnew/remarketing?type='.$data->id, $siteData)){ ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shopnew/remarketing?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopnew/remarketing?type='.$data->id, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Ремаркетинг <?php echo Func::mb_strtoupper($data->values['name']); ?>
            </label>
        </div>
    <?php } ?>
    <?php if($isShowMenuAll || Func::isShopMenuVisible('shopnew/hashtag?type='.$data->id, $siteData)){ ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shopnew/hashtag?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopnew/hashtag?type='.$data->id, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Хэштеги в <?php echo Func::mb_strtoupper($data->values['name']); ?>
            </label>
        </div>
    <?php } ?>
    <?php if($isShowMenuAll || Func::isShopMenuVisible('shopnew/similar?type='.$data->id, $siteData)){ ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shopnew/similar?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopnew/similar?type='.$data->id, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Подобные статьи / новости <?php echo Func::mb_strtoupper($data->values['name']); ?>
            </label>
        </div>
    <?php } ?>
    <?php if($isShowMenuAll || Func::isShopMenuVisible('shopnewrubric/index?type='.$data->id, $siteData)){ ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shopnewrubric/index?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopnewrubric/index?type='.$data->id, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Рубрики <?php echo Func::mb_strtoupper($data->values['name']); ?>
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
    <?php } ?>
    <?php if($isShowMenuAll || Func::isShopMenuVisible('shopnewrubric/index-root?type='.$data->id, $siteData)){ ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shopnewrubric/index-root?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopnewrubric/index-root?type='.$data->id, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Рубрики второго уровня <?php echo Func::mb_strtoupper($data->values['name']); ?>
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
    <?php } ?>
    <?php if($isShowMenuAll || Func::isShopMenuVisible('shopnewhashtag/index?type='.$data->id, $siteData)){ ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shopnewhashtag/index?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopnewhashtag/index?type='.$data->id, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Хэштеги <?php echo Func::mb_strtoupper($data->values['name']); ?>
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
    <?php } ?>
    <?php if($isShowMenuAll || Func::isShopMenuVisible('shopnewselecttype/index?type='.$data->id, $siteData)){ ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shopnewselecttype/index?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopnewselecttype/index?type='.$data->id, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Вид выделения <?php echo Func::mb_strtoupper($data->values['name']); ?>
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
    <?php } ?>

    <!-- <li class="divider" role="presentation"></li> -->
<?php } ?>
