<?php $name = 'shopgood'; ?>
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
    <?php $key = $name.'/storage_count?type='.$data->id; ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
            Кол-во на складе
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
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
            Дилерска цена
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
    <?php $key = $name.'/rubrics?type='.$data->id; ?>
    <div class="form-group margin-t-15">
        <label style="font-weight: 400;">
            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
            Рубрики
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
    <?php $key = $name.'/stock?type='.$data->id; ?>
    <div class="form-group margin-t-15">
        <label style="font-weight: 400;">
            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
            Хранилище
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
    <?php $key = $name.'/stock_name?type='.$data->id; ?>
    <div class="form-group margin-t-15">
        <label style="font-weight: 400;">
            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
            Штрихкод на складе
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
            Подобные товары / услуги
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
    <?php $key = $name.'/group?type='.$data->id; ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
            Связанные товары
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
        <?php $key = $name.'/find/name_article?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Название или артикул
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/find/names_articles?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Название или артикул (поиск по подстрока)
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/find/article?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Артикул
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/find/name?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Название
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
        <?php $key = $name.'/find/stock?type='.$data->id; ?>
        <div class="form-group margin-t-15">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Хранилище
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/find/stock_name?type='.$data->id; ?>
        <div class="form-group margin-t-15">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Штрихкод склада
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/find/unit?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Единица измерения
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/find/select?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Тип выделения
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/find/brand?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Бренд
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
    </div>

    <div class="access-fields box-table">
        <?php $key = $name.'/table/id?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                ID
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/table/article?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Артикул
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/table/storage_count?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Кол-во на складе
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
        <?php $key = $name.'/table/stock?type='.$data->id; ?>
        <div class="form-group margin-t-15">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Хранилище
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/table/stock_rubric?type='.$data->id; ?>
        <div class="form-group margin-t-15">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Рубрика хранилища
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/table/stock_name?type='.$data->id; ?>
        <div class="form-group margin-t-15">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Штрихкод на складе
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/table/unit?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Единица измерения
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/table/select?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Тип выделения
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/table/brand?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Бренд
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
    </div>
<?php
$view = View::factory('cabinet/35/_shop/_table/catalog/menu/access/one/shoptablerubric');
$view->siteData = $siteData;
$view->data = $data;
$view->isShowMenuAll = TRUE;
echo Helpers_View::viewToStr($view);
?>
<?php echo $data->additionDatas['view::_shop/_table/catalog/menu/access/one/child']; ?>