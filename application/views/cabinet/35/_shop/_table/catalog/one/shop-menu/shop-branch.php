<div class="form-group margin-b-20"></div>
<?php if(Func::isShopMenu('shopbrand/index?type='.$data->id, $siteData)){ ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[shopbrand/index?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopbrand/index?type='.$data->id, $data->additionDatas, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> <b><?php echo Func::mb_strtoupper($data->values['name']); ?></b>
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
<?php } ?>