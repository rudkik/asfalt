<?php $key = 'shoptablerubric/index?type='.$data->id; ?>
<div class="form-group margin-t-15">
    <h4 style="color: #00acd6;">
        <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
        Рубрика
        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
    </h4>
</div>
<div class="access-fields">
    <?php $name = 'shoptablerubric'; ?>
    <?php $key = $name.'/root?type='.$data->id;?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
            Родитель
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
    <?php $key = $name.'/text?type='.$data->id; ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
            Описание
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
    <?php $key = $name.'/text-html?type='.$data->id; ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
            Описание HTML
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
    <?php $key = $name.'/image?type='.$data->id; ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
            Картинка
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
    <?php $key = $name.'/brand?type='.$data->id; ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
            Бренд
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
    <?php $key = $name.'/unit?type='.$data->id; ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
            Единица измерения
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
    <?php $key = $name.'/select?type='.$data->id; ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
            Тип выделения
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
    <?php $key = $name.'/seo?type='.$data->id; ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
            SEO-настройки
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
</div>