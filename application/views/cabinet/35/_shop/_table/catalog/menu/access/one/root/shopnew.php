<?php $name = 'shopnew'; ?>
<?php $key = $name.'/index?type='.$data->id;?>
<div class="form-group margin-t-15">
    <h4 class="text-red">
        <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
        <?php echo $data->values['name']; ?>
        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
    </h4>
</div>
<div class="access-fields">
    <?php $key = $name.'/article?type='.$data->id; ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
            Артикул
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>

    <?php $key = $name.'/rubric?type='.$data->id;?>
    <div class="form-group margin-t-15">
        <label style="font-weight: 400;">
            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
            Рубрика
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
    <?php $key = $name.'/rubrics?type='.$data->id; ?>
    <div class="form-group margin-t-15">
        <label style="font-weight: 400;">
            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
            Рубрики
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
    <?php $key = $name.'/unit?type='.$data->id;?>
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
    <?php $key = $name.'/brand?type='.$data->id; ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
            Бренд
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
    <?php $key = $name.'/hashtag?type='.$data->id; ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
            Хэштег
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
    <?php $key = $name.'/filter?type='.$data->id; ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
            Фильтры
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
    <?php $key = $name.'/similar?type='.$data->id; ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
            Подобные статьи
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
    <?php $key = $name.'/group?type='.$data->id; ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
            Связанные статьи
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
    <?php $key = $name.'/created_at?type='.$data->id; ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
            Дата создания
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
</div>
<?php
$view = View::factory('cabinet/35/_shop/_table/catalog/menu/access/one/shoptablerubric');
$view->siteData = $siteData;
$view->data = $data;
$view->isShowMenuAll = TRUE;
echo Helpers_View::viewToStr($view);
?>
<?php echo $data->additionDatas['view::_shop/_table/catalog/menu/access/one/child']; ?>