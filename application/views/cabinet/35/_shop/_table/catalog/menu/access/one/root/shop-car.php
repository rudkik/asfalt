<?php $name = 'shopcar'; ?>
<?php $key = $name.'/index?type='.$data->id;?>
    <div class="form-group margin-t-15">
        <h4 class="text-red">
            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
            <?php echo $data->values['name']; ?>
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </h4>
    </div>
    <div class="access-fields">
        <h6 class="text-right" style="margin: 0px;">Редактирование</h6>
        <?php $key = $name.'/price?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Цена
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/price_old?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Старая цена
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/price_cost?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Дилерская цена
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/currency?type='.$data->id; ?>
        <div class="form-group margin-t-15">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Валюта
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/rubric?type='.$data->id; ?>
        <div class="form-group margin-t-15">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Рубрика
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/mark?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Марка
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/model?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Модель
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/production_land?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Страна производства
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/location_land?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Страна нахождения
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/location_city?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Город нахождения
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
    </div>

    <div class="access-fields box-find">
        <h6 class="text-right" style="margin: 0px;">Поиск</h6>
        <?php $key = $name.'/find/name?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Название
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/find/name_total?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Полное название
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/find/mark?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Марка
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/find/model?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Модель
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/find/rubric?type='.$data->id; ?>
        <div class="form-group margin-t-15">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Рубрика
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/find/hashtag?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Хэштег
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/find/filter?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Фильтры
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>

        <?php
        $view = View::factory('cabinet/35/_addition/params/access');
        $view->siteData = $siteData;
        $view->data = $data;
        $view->objectName = 'shop_car';
        $view->where = 'find';
        echo Helpers_View::viewToStr($view);
        ?>
    </div>

    <div class="access-fields box-table">
        <h6 class="text-right" style="margin: 0px;">В списке</h6>
        <?php $key = $name.'/table/name?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Название
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/table/name_total?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Полное название
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/table/mark?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Марка
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/table/model?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Модель
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/table/id?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                ID
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/table/price?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Цена
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/table/rubric?type='.$data->id; ?>
        <div class="form-group margin-t-15">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Рубрика
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/table/text?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Описание
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/table/image?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Картинка
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>

        <?php
        $view = View::factory('cabinet/35/_addition/params/access');
        $view->siteData = $siteData;
        $view->data = $data;
        $view->objectName = 'shop_car';
        $view->where = 'table';
        echo Helpers_View::viewToStr($view);
        ?>
    </div>
<?php
$view = View::factory('cabinet/35/_shop/_table/catalog/menu/access/one/shoptablerubric');
$view->siteData = $siteData;
$view->data = $data;
$view->isShowMenuAll = TRUE;
echo Helpers_View::viewToStr($view);
?>
<?php echo $data->additionDatas['view::_shop/_table/catalog/menu/access/one/child']; ?>