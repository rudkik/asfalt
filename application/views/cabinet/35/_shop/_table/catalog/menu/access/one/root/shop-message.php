<?php $name = 'shopmessage'; ?>
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
        <?php $key = $name.'/rubric?type='.$data->id; ?>
        <div class="form-group margin-t-15">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Рубрика
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

        <?php
        $view = View::factory('cabinet/35/_addition/params/access');
        $view->siteData = $siteData;
        $view->data = $data;
        $view->objectName = 'shop_message';
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
        <?php $key = $name.'/table/id?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                ID
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
        $view->objectName = 'shop_message';
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