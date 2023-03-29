<?php $name = 'shoptablestock'; ?>

<?php $key = $name.'/group?type='.$data->id; ?>
<div class="form-group margin-t-15">
    <h4 style="color: #00acd6;">
        <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
        <?php echo $data->values['name']; ?>
        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
    </h4>
</div>
<div class="access-fields">
    <?php $key = $name.'/barcode?type='.$data->id;?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
            Штрихкод
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
    <?php $key = $name.'/rubric?type='.$data->id;?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
            Рубрика
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
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
</div>
<?php
$view = View::factory('cabinet/35/_shop/_table/catalog/menu/access/one/shoptablerubric');
$view->siteData = $siteData;
$view->data = $data;
$view->isShowMenuAll = TRUE;
echo Helpers_View::viewToStr($view);
?>