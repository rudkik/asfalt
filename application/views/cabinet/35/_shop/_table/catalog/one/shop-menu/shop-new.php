<?php if((Func::isShopMenu('shopnew/index?type='.$data->id, $siteData))
        || (Func::isShopMenu('shopnewrubric/index?type='.$data->id, $siteData))){ ?>
    <div class="form-group margin-b-20"></div>
    <?php if(Func::isShopMenu('shopnew/index?type='.$data->id, $siteData)){ ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shopnew/index?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopnew/index?type='.$data->id, $data->additionDatas, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> <b><?php echo Func::mb_strtoupper($data->values['name']); ?></b>
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
    <?php } ?>
    <?php if(Func::isShopMenu('shopnew/text?type='.$data->id, $siteData)){ ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shopnew/text?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopnew/text?type='.$data->id, $data->additionDatas, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Описание
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
    <?php } ?>
    <?php if(Func::isShopMenu('shopnew/text-html?type='.$data->id, $siteData)){ ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shopnew/text-html?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopnew/text-html?type='.$data->id, $data->additionDatas, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Описание в виде HTML
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
    <?php } ?>
    <?php if(Func::isShopMenu('shopnew/image?type='.$data->id, $siteData)){ ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shopnew/image?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopnew/image?type='.$data->id, $data->additionDatas, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Изображение
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
    <?php } ?>
    <?php if(Func::isShopMenu('shopnew/rubric?type='.$data->id, $siteData)){ ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shopnew/rubric?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopnew/rubric?type='.$data->id, $data->additionDatas, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Рубрика
            </label>
        </div>
    <?php } ?>
    <?php if(Func::isShopMenu('shopnew/select-type?type='.$data->id, $siteData)){ ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shopnew/select-type?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopnew/select-type?type='.$data->id, $data->additionDatas, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Вид выделения
            </label>
        </div>
    <?php } ?>
    <?php if(Func::isShopMenu('shopnew/hashtag?type='.$data->id, $siteData)){ ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shopnew/hashtag?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopnew/hashtag?type='.$data->id, $data->additionDatas, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Хэштеги
            </label>
        </div>
    <?php } ?>
    <?php if(Func::isShopMenu('shopnew/remarketing?type='.$data->id, $siteData)){ ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shopnew/remarketing?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopnew/remarketing?type='.$data->id, $data->additionDatas, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Ремаркетинг
            </label>
        </div>
    <?php } ?>
    <?php if(Func::isShopMenu('shopnew/similar?type='.$data->id, $siteData)){ ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shopnew/similar?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopnew/similar?type='.$data->id, $data->additionDatas, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Подобные статьи / новости
            </label>
        </div>
    <?php } ?>
    <?php if(Func::isShopMenu('shopnew/child?type='.$data->id, $siteData)){ ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shopnew/child?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopnew/child?type='.$data->id, $data->additionDatas, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Подстатьи
            </label>
        </div>
    <?php } ?>
    <?php if(Func::isShopMenu('shopnewrubric/index?type='.$data->id, $siteData)){ ?>
        <div class="form-group">
            <label style="font-weight: 400;color: #00acd6;">
                <input name="shop_menu[shopnewrubric/index?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopnewrubric/index?type='.$data->id, $data->additionDatas, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Рубрики
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
    <?php } ?>
    <?php if(Func::isShopMenu('shopnewrubric/index-root?type='.$data->id, $siteData)){ ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shopnewrubric/index-root?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopnewrubric/index-root?type='.$data->id, $data->additionDatas, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Рубрики второго уровня
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
    <?php } ?>
    <?php if(Func::isShopMenu('shopnewrubric/index-params?type='.$data->id, $siteData)){ ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shopnewrubric/index-params?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopnewrubric-params/index?type='.$data->id, $data->additionDatas, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Доп. параметры рубрик
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
    <?php } ?>
    <?php if(Func::isShopMenu('shopnewhashtag/index?type='.$data->id, $siteData)){ ?>
        <div class="form-group">
            <label style="font-weight: 400;color: #00acd6;">
                <input name="shop_menu[shopnewhashtag/index?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopnewhashtag/index?type='.$data->id, $data->additionDatas, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Хэштеги
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
    <?php } ?>
    <?php if(Func::isShopMenu('shopnewselecttype/index?type='.$data->id, $siteData)){ ?>
        <div class="form-group">
            <label style="font-weight: 400;color: #00acd6;">
                <input name="shop_menu[shopnewselecttype/index?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopnewselecttype/index?type='.$data->id, $data->additionDatas, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Виды выделения
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
    <?php } ?>
<?php } ?>
