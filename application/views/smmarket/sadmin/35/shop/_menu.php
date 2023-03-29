<div class="row top20" id="edit_panel">
    <div class="col-md-4">
        <?php if($isShowMenuAll || Func::isShopMenuVisible('shopaction/index', $siteData)){ ?>
        <div style="margin-bottom: 5px;" class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shopaction/index]" class="flat-red" <?php if(Func::isShopMenu('shopaction/index', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox"> Акции
            </label>
        </div>
        <?php } ?>

        <?php if($isShowMenuAll || Func::isShopMenuVisible('shopdiscount/index', $siteData)){ ?>
        <div style="margin-bottom: 5px;" class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shopdiscount/index]" class="flat-red"  <?php if(Func::isShopMenu('shopdiscount/index', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox"> Скидки
            </label>
        </div>
        <?php } ?>

        <?php if($isShowMenuAll || Func::isShopMenuVisible('shopcoupon/index', $siteData)){ ?>
        <div style="margin-bottom: 5px;" class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shopcoupon/index]" class="flat-red"  <?php if(Func::isShopMenu('shopcoupon/index', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox"> Купоны
            </label>
        </div>
        <?php } ?>

        <?php if($isShowMenuAll || Func::isShopMenuVisible('shopgoodtype/index', $siteData)){ ?>
        <div style="margin-bottom: 5px; margin-top: 25px"  class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shopgoodtype/index]" class="flat-red"  <?php if(Func::isShopMenu('shopgoodtype/index', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox"> Типы товаров
            </label>
        </div>
        <?php } ?>

        <?php if($isShowMenuAll || Func::isShopMenuVisible('shopgoodselecttype/index', $siteData)){ ?>
        <div style="margin-bottom: 5px;" class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shopgoodselecttype/index]" class="flat-red"  <?php if(Func::isShopMenu('shopgoodselecttype/index', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox"> Статусы товаров
            </label>
        </div>
        <?php } ?>

        <div style="margin-bottom: 5px; margin-top: 25px"  class="form-group">
            <label>
                Общие для всех товаров
            </label>
        </div>

        <?php if($isShowMenuAll || Func::isShopMenuVisible('shopgoodcatalog/index-all', $siteData)){ ?>
        <div style="margin-bottom: 5px;" class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shopgoodcatalog/index-all]" class="flat-red"  <?php if(Func::isShopMenu('shopgoodcatalog/index-all', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Категории
            </label>
        </div>
        <?php } ?>

        <?php if($isShowMenuAll || Func::isShopMenuVisible('shopattribute/index-all', $siteData)){ ?>
        <div style="margin-bottom: 5px;" class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shopattribute/index-all]" class="flat-red"  <?php if(Func::isShopMenu('shopattribute/index-all', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox"> Атрибуты
            </label>
        </div>
        <?php } ?>

        <?php if($isShowMenuAll || Func::isShopMenuVisible('shopattributecatalog/index-all', $siteData)){ ?>
        <div style="margin-bottom: 5px;" class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shopattributecatalog/index-all]" class="flat-red"  <?php if(Func::isShopMenu('shopattributecatalog/index-all', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox"> Категория атрибутов
            </label>
        </div>
        <?php } ?>

        <?php if($isShowMenuAll || Func::isShopMenuVisible('shopattributegroup/index-all', $siteData)){ ?>
            <div style="margin-bottom: 5px;" class="form-group">
                <label style="font-weight: 400;">
                    <input name="shop_menu[shopattributegroup/index-all]" class="flat-red"  <?php if(Func::isShopMenu('shopattributegroup/index-all', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox"> Группировка атрибутов
                </label>
            </div>
        <?php } ?>

        <?php
        $s =  trim($siteData->globalDatas['view::shopgoodtypes/shopmenu']);
        foreach($data->values as $key => $value){
            $tmp = 'name="shop_menu['.$key.']"';
            if(Request_RequestParams::isBoolean($value) === TRUE) {
                $s = str_replace($tmp, $tmp.' checked value="1"', $s);
            }else{
                $s = str_replace($tmp, $tmp.' value="0"', $s);
            }
        }
        echo $s;
        ?>
    </div>

    <div class="col-md-4">

        <?php if($isShowMenuAll || Func::isShopMenuVisible('shopinformationdata/index', $siteData)){ ?>
        <div style="margin-bottom: 5px;" class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shopinformationdata/index]" class="flat-red"  <?php if(Func::isShopMenu('shopinformationdata/index', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox"> Статичные блоки
            </label>
        </div>
        <?php } ?>

        <?php if($isShowMenuAll || Func::isShopMenuVisible('shopnewcatalog/index', $siteData)){ ?>
        <div style="margin-bottom: 5px; margin-top: 25px" class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shopnewcatalog/index]" class="flat-red"  <?php if(Func::isShopMenu('shopnewcatalog/index', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox"> Типы статей
            </label>
        </div>
        <?php } ?>

        <?php if($isShowMenuAll || Func::isShopMenuVisible('shopnewrubric/index-all', $siteData)){ ?>
            <div style="margin-bottom: 5px;" class="form-group">
                <label style="font-weight: 400;">
                    <input name="shop_menu[shopnewrubric/index-all]" class="flat-red"  <?php if(Func::isShopMenu('shopnewrubric/index-all', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Категории статей
                </label>
            </div>
        <?php } ?>

        <?php
        $s =  trim($siteData->globalDatas['view::shopnewcatalogs/shopmenu']);
        foreach($data->values as $key => $value){
            $tmp = 'name="shop_menu['.$key.']"';
            if(Request_RequestParams::isBoolean($value) === TRUE) {
                $s = str_replace($tmp, $tmp.' checked value="1"', $s);
            }else{
                $s = str_replace($tmp, $tmp.' value="0"', $s);
            }
        }
        echo $s;
        ?>

        <?php if($isShowMenuAll || Func::isShopMenuVisible('shopgallerycatalog/index', $siteData)){ ?>
        <div style="margin-bottom: 5px; margin-top: 25px" class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shopgallerycatalog/index]" class="flat-red"  <?php if(Func::isShopMenu('shopgallerycatalog/index', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox"> Типы фотогалерей
            </label>
        </div>
        <?php } ?>

        <?php
        $s =  trim($siteData->globalDatas['view::shopgallerycatalogs/shopmenu']);
        foreach($data->values as $key => $value){
            $tmp = 'name="shop_menu['.$key.']"';
            if(Request_RequestParams::isBoolean($value) === TRUE) {
                $s = str_replace($tmp, $tmp.' checked value="1"', $s);
            }else{
                $s = str_replace($tmp, $tmp.' value="0"', $s);
            }
        }
        echo $s;
        ?>

    </div>

    <div class="col-md-4">
        <?php if($isShowMenuAll || Func::isShopMenuVisible('shopquestion/index', $siteData)){ ?>
        <div style="margin-bottom: 5px;" class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shopquestion/index]" class="flat-red"  <?php if(Func::isShopMenu('shopquestion/index', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox"> Вопросы
            </label>
        </div>
        <?php } ?>

        <?php if($isShowMenuAll || Func::isShopMenuVisible('shopcomment/index', $siteData)){ ?>
        <div style="margin-bottom: 5px;" class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shopcomment/index]" class="flat-red"  <?php if(Func::isShopMenu('shopcomment/index', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox"> Комментарии
            </label>
        </div>
        <?php } ?>

        <?php if($isShowMenuAll || Func::isShopMenuVisible('shop/edit', $siteData)){ ?>
        <div style="margin-bottom: 5px; margin-top: 25px" class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shop/edit]" class="flat-red"  <?php if(Func::isShopMenu('shop/edit', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox"> Информация о магазине
            </label>
        </div>
        <?php } ?>

        <?php if($isShowMenuAll || Func::isShopMenuVisible('shopdeliverytype/index', $siteData)){ ?>
        <div style="margin-bottom: 5px; margin-top: 25px" class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shopdeliverytype/index]" class="flat-red"  <?php if(Func::isShopMenu('shopdeliverytype/index', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox"> Доставка
            </label>
        </div>
        <?php } ?>

        <?php if($isShowMenuAll || Func::isShopMenuVisible('shoppaidtype/index', $siteData)){ ?>
        <div style="margin-bottom: 5px;" class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shoppaidtype/index]" class="flat-red"  <?php if(Func::isShopMenu('shoppaidtype/index', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox"> Оплата
            </label>
        </div>
        <?php } ?>

        <?php if($isShowMenuAll || Func::isShopMenuVisible('shopoperation/index', $siteData)){ ?>
        <div style="margin-bottom: 5px;" class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shopoperation/index]" class="flat-red"  <?php if(Func::isShopMenu('shopoperation/index', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox"> Сотрудники
            </label>
        </div>
        <?php } ?>

        <?php if($isShowMenuAll || Func::isShopMenuVisible('shopaddress/editmain', $siteData)){ ?>
        <div style="margin-bottom: 5px; margin-top: 25px"  class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shopaddress/editmain]" class="flat-red"  <?php if(Func::isShopMenu('shopaddress/editmain', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox"> Адрес магазина
            </label>
        </div>
        <?php } ?>

        <?php if($isShowMenuAll || Func::isShopMenuVisible('shopaddresscontact/index', $siteData)){ ?>
        <div style="margin-bottom: 5px;" class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shopaddresscontact/index]" class="flat-red"  <?php if(Func::isShopMenu('shopaddresscontact/index', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox"> Контакты
            </label>
        </div>
        <?php } ?>

        <?php if($isShowMenuAll || Func::isShopMenuVisible('shopaddress/index', $siteData)){ ?>
        <div style="margin-bottom: 5px;" class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shopaddress/index]" class="flat-red"  <?php if(Func::isShopMenu('shopaddress/index', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox"> Контакты филиалов
            </label>
        </div>
        <?php } ?>

        <div style="margin-bottom: 5px; margin-top: 25px"  class="form-group">
            <label>
                Настройки сайта
            </label>
        </div>

        <?php if($isShowMenuAll || Func::isShopMenuVisible('siteoptions/heads', $siteData)){ ?>
        <div style="margin-bottom: 5px;" class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[siteoptions/heads]" class="flat-red"  <?php if(Func::isShopMenu('siteoptions/heads', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox"> Заголовки сайта
            </label>
        </div>
        <?php } ?>

        <?php if($isShowMenuAll || Func::isShopMenuVisible('siteoptions/sitemaps', $siteData)){ ?>
        <div style="margin-bottom: 5px;" class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[siteoptions/sitemaps]" class="flat-red"  <?php if(Func::isShopMenu('siteoptions/sitemaps', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox"> Карта сайта
            </label>
        </div>
        <?php } ?>

        <?php if($isShowMenuAll || Func::isShopMenuVisible('shop/options', $siteData)){ ?>
        <div style="margin-bottom: 5px;" class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shop/options]" class="flat-red"  <?php if(Func::isShopMenu('shop/options', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox"> Общие настройки
            </label>
        </div>
        <?php } ?>

        <div style="margin-bottom: 5px; margin-top: 25px"  class="form-group">
            <label>
                Заказы, отчеты и графики
            </label>
        </div>

        <?php if($isShowMenuAll || Func::isShopMenuVisible('shopbill', $siteData)){ ?>
        <div style="margin-bottom: 5px;" class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shopbill]" class="flat-red"  <?php if(Func::isShopMenu('shopbill', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox"> Заказы
            </label>
        </div>
        <?php } ?>

        <?php if($isShowMenuAll || Func::isShopMenuVisible('shopreport/day', $siteData)){ ?>
        <div style="margin-bottom: 5px;" class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shopreport/day]" class="flat-red"  <?php if(Func::isShopMenu('shopreport/day', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox"> Отчет по дням
            </label>
        </div>
        <?php } ?>

        <?php if($isShowMenuAll || Func::isShopMenuVisible('shopreport/billitem', $siteData)){ ?>
        <div style="margin-bottom: 5px;" class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shopreport/billitem]" class="flat-red"  <?php if(Func::isShopMenu('shopreport/billitem', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox"> Отчеты по товарам
            </label>
        </div>
        <?php } ?>

        <?php if($isShowMenuAll || Func::isShopMenuVisible('shopreport/salesgraph', $siteData)){ ?>
        <div style="margin-bottom: 5px;" class="form-group">
            <label style="font-weight: 400;">
                <input name="shop_menu[shopreport/salesgraph]" class="flat-red"  <?php if(Func::isShopMenu('shopreport/salesgraph', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox"> График продаж

        </div>
        <?php } ?>
    </div>
</div>
