<?php $name = 'shopcoupon'; ?>
<?php $key = $name.'/index?type='.$data->id;?>
<div class="form-group margin-t-15">
    <h4 class="text-red">
        <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
        <?php echo $data->values['name']; ?>
        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
    </h4>
</div>
<?php $key = $name.'/unit?type='.$data->id;
?>
<div class="form-group">
    <label style="font-weight: 400;">
        <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
        Единица измерения
        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
    </label>
</div>

<?php $key = $name.'/select?type='.$data->id;
?>
<div class="form-group">
    <label style="font-weight: 400;">
        <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
        Тип выделения
        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
    </label>
</div>

<?php $key = $name.'/brand?type='.$data->id;
?>
<div class="form-group">
    <label style="font-weight: 400;">
        <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
        Бренд
        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
    </label>
</div>

<?php $key = $name.'/hashtag?type='.$data->id;
?>
<div class="form-group">
    <label style="font-weight: 400;">
        <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
        Хэштег
        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
    </label>
</div>

<?php $key = $name.'/filter?type='.$data->id;
?>
<div class="form-group">
    <label style="font-weight: 400;">
        <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
        Фильтры
        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
    </label>
</div>

<?php $key = $name.'/similar?type='.$data->id;
?>
<div class="form-group">
    <label style="font-weight: 400;">
        <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
        Подобные товары / услуги
        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
    </label>
</div>

<?php $key = $name.'/group?type='.$data->id;
?>
<div class="form-group">
    <label style="font-weight: 400;">
        <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
        Связанные товары
        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
    </label>
</div>

<?php $key = $name.'/text?type='.$data->id;
?>
<div class="form-group">
    <label style="font-weight: 400;">
        <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
        Описание
        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
    </label>
</div>

<?php $key = $name.'/text-html?type='.$data->id;
?>
<div class="form-group">
    <label style="font-weight: 400;">
        <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
        Описание HTML
        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
    </label>
</div>

<?php $key = $name.'/image?type='.$data->id;
?>
<div class="form-group">
    <label style="font-weight: 400;">
        <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
        Картинка
        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
    </label>
</div>

<?php $key = $name.'/rubric?type='.$data->id;
?>
<div class="form-group margin-t-15">
    <h4 style="color: #00acd6;">
        <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
        Рубрика
        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
    </h4>
</div>

<?php
$view = View::factory('cabinet/35/_shop/_table/catalog/menu/access/one/shoptablerubric');
$view->siteData = $siteData;
$view->data = $data;
$view->isShowMenuAll = TRUE;
echo Helpers_View::viewToStr($view);
?>
<?php echo $data->additionDatas['view::_shop/_table/catalog/menu/access/one/child']; ?>