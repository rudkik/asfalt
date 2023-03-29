<?php $name = 'shopoperationstock'; ?>
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
                Название
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/shop_operation_id?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Менеджер
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/is_close?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Статус
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/amount?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Стоимость
                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            </label>
        </div>
        <?php $key = $name.'/amount_first?type='.$data->id; ?>
        <div class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                Первоначальная стоимость
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

<?php $key = 'shopreport/branch/operationstock?type='.$data->id;?>
    <div class="form-group margin-t-15">
        <h4 style="color: #00acd6;">
            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
            <?php echo $data->values['name'];?> отчеты
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </h4>
    </div>
<?php $key = 'shopreport/good/operationstock?type='.$data->id;?>
    <div class="form-group margin-t-15">
        <h4 style="color: #00acd6;">
            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
            Проданные отчеты
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </h4>
    </div>
<?php echo $data->additionDatas['view::_shop/_table/catalog/menu/access/one/child']; ?>