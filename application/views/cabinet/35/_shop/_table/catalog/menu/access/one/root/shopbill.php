<?php $name = 'shopbill'; ?>
<?php $key = $name.'/index?type='.$data->id;?>
<div class="form-group margin-t-15">
    <h4 class="text-red">
        <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
        <?php echo $data->values['name']; ?>
        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
    </h4>
</div>
    <div class="access-fields">
        <?php $key = $name.'/name?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                ФИО
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/shop_bill_status_id?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Статус
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/shop_paid_type_id?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Оплата
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/shop_delivery_type_id?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Доставка
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/shop_root_id?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Магазин
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/country_id?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Страна
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/city_id?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Город
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/paid_at?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Дата оплаты
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/delivery_at?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Дата доставки
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/delivery_amount?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Стоимость доставки
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/address?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Адрес
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
    </div>

<?php $key = $name.'/branch?type='.$data->id;?>
    <div class="form-group margin-t-15">
        <h4 style="color: #00acd6;">
            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
            <?php echo $data->values['name']; ?> филиалов
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </h4>
    </div>

<?php $key = 'shopreport/branch/bill?type='.$data->id;?>
    <div class="form-group margin-t-15">
        <h4 style="color: #00acd6;">
            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
            <?php echo $data->values['name'];?> отчеты
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </h4>
    </div>
<?php $key = 'shopreport/good/bill?type='.$data->id;?>
    <div class="form-group margin-t-15">
        <h4 style="color: #00acd6;">
            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
            Проданные отчеты
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </h4>
    </div>
<?php echo $data->additionDatas['view::_shop/_table/catalog/menu/access/one/child']; ?>