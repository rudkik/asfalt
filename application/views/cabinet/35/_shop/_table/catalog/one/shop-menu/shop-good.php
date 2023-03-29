<div class="form-group margin-b-20"></div>
<?php if(Func::isShopMenu('shopgood/index?type='.$data->id, $siteData)){ ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[shopgood/index?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopgood/index?type='.$data->id, $data->additionDatas, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> <b><?php echo Func::mb_strtoupper($data->values['name']); ?></b>
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
<?php } ?>
<?php if(Func::isShopMenu('shopgood/text?type='.$data->id, $siteData)){ ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[shopgood/text?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopgood/text?type='.$data->id, $data->additionDatas, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Описание
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
<?php } ?>
<?php if(Func::isShopMenu('shopgood/text-html?type='.$data->id, $siteData)){ ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[shopgood/text-html?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopgood/text-html?type='.$data->id, $data->additionDatas, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Описание в виде HTML
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
<?php } ?>
<?php if(Func::isShopMenu('shopgood/image?type='.$data->id, $siteData)){ ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[shopgood/image?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopgood/image?type='.$data->id, $data->additionDatas, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Изображение
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
<?php } ?>
<?php if(Func::isShopMenu('shopgood/catalog?type='.$data->id, $siteData)){ ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[shopgood/catalog?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopgood/catalog?type='.$data->id, $data->additionDatas, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Рубрики
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
<?php } ?>
<?php if(Func::isShopMenu('shopgood/unit-type?type='.$data->id, $siteData)){ ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[shopgood/unit-type?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopgood/unit-type?type='.$data->id, $data->additionDatas, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Единицы измерения
        </label>
    </div>
<?php } ?>
<?php if(Func::isShopMenu('shopgood/select-type?type='.$data->id, $siteData)){ ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[shopgood/select-type?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopgood/select-type?type='.$data->id, $data->additionDatas, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Виды выделения
        </label>
    </div>
<?php } ?>
<?php if(Func::isShopMenu('shopgood/attribute?type='.$data->id, $siteData)){ ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[shopgood/attribute?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopgood/attribute?type='.$data->id, $data->additionDatas, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Атрибуты
        </label>
    </div>
<?php } ?>
<?php if(Func::isShopMenu('shopgood/similar?type='.$data->id, $siteData)){ ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[shopgood/similar?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopgood/similar?type='.$data->id, $data->additionDatas, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Подобные
        </label>
    </div>
<?php } ?>
<?php if(Func::isShopMenu('shopgood/seo?type='.$data->id, $siteData)){ ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[shopgood/seo?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopgood/seo?type='.$data->id, $data->additionDatas, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> SEO
        </label>
    </div>
<?php } ?>
<?php if(Func::isShopMenu('shopgood/remarketing?type='.$data->id, $siteData)){ ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[shopgood/remarketing?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopgood/remarketing?type='.$data->id, $data->additionDatas, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Ремаркетинг
        </label>
    </div>
<?php } ?>
<?php if(Func::isShopMenu('shopgood/child?type='.$data->id, $siteData)){ ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[shopgood/child?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopgood/child?type='.$data->id, $data->additionDatas, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Подтовары
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
<?php } ?>
<?php if(Func::isShopMenu('shopgood/group?type='.$data->id, $siteData)){ ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[shopgood/group?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopgood/group?type='.$data->id, $data->additionDatas, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Группы товаров
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
<?php } ?>

<?php if(Func::isShopMenu('shopgoodcatalog/index?type='.$data->id, $siteData)){ ?>
    <div class="form-group">
        <label style="font-weight: 400;color: #00acd6;">
            <input name="shop_menu[shopgoodcatalog/index?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopgoodcatalog/index?type='.$data->id, $data->additionDatas, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Рубрики
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
<?php } ?>
<?php if(Func::isShopMenu('shopgoodcatalog/index-root?type='.$data->id, $siteData)){ ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[shopgoodcatalog/index?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopgoodcatalog/index-root?type='.$data->id, $data->additionDatas, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Рубрики второго уровня
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
<?php } ?>
<?php if(Func::isShopMenu('shopgoodcatalog/index-params?type='.$data->id, $siteData)){ ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[shopgoodcatalog/index-params?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopgoodcatalog-params/index?type='.$data->id, $data->additionDatas, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Доп. параметры рубрик
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
<?php } ?>
<?php if(Func::isShopMenu('shopattribute/index?type='.$data->id, $siteData)){ ?>
    <div class="form-group">
        <label style="font-weight: 400;color: #00acd6;">
            <input name="shop_menu[shopattribute/index?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopattribute/index?type='.$data->id, $data->additionDatas, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Атрибуты
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
<?php } ?>

<?php if(Func::isShopMenu('shopattributegroup/index?type='.$data->id, $siteData)){ ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[shopattributegroup/index?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopattributegroup/index?type='.$data->id, $data->additionDatas, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Группы атрибутов
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
<?php } ?>




<?php if(Func::isShopMenu('shopattributecatalog/index?type='.$data->id, $siteData)){ ?>
    <div class="form-group">
        <label style="font-weight: 400;">
            <input name="shop_menu[shopattributecatalog/index?type=<?php echo $data->id; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu('shopattributecatalog/index?type='.$data->id, $data->additionDatas, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>> Рубрики атрибутов
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </label>
    </div>
<?php } ?>
