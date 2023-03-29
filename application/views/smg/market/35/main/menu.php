<?php if($siteData->operation->getShopPositionID() == 0 || $siteData->operation->getShopPositionID() == Model_AutoPart_Shop_Position::POSITION_BILL){ ?>
    <li <?php if(strpos($siteData->url, '/shopbill/')){echo 'class="active"';}?>>
        <a href="<?php echo $siteData->urlBasic; ?>/market/shopbill/index">
            <i class="fa fa-pagelines fa-fw">
                <div class="icon-bg bg-green"></div>
            </i>
            <span class="menu-title">Заказы</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="nav nav-second-level">
            <?php if($siteData->operation->getShopPositionID() == 0){ ?>
                <li <?php if(strpos($siteData->url, '/shopbillitem/stock')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopbillitem/stock"><span class="submenu-title">Подочетные товары</span></a></li>
                <li <?php if(strpos($siteData->url, '/shopreceiveitem/stock')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopreceiveitem/stock"><span class="submenu-title">Товары на складе</span></a></li>
                <li <?php if(strpos($siteData->url, '/shopbill/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopbill/index"><span class="submenu-title">Заказы</span></a></li>
                <li <?php if(strpos($siteData->url, '/shopbillitem/bill')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopbillitem/need_buy"><span class="submenu-title">Товары заказов</span></a></li>
                <li <?php if(strpos($siteData->url, '/shopbillbuyer/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopbillbuyer/index"><span class="submenu-title">Покупатели</span></a></li>

                <li <?php if(strpos($siteData->url, '/shopsupplieraddress/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopsupplieraddress/index"><span class="submenu-title">Адреса поставщиков</span></a></li>
                <li <?php if(strpos($siteData->url, '/shopcourieraddress/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopcourieraddress/index"><span class="submenu-title">Адреса курьеров</span></a></li>
                <li <?php if(strpos($siteData->url, '/shopbilldeliveryaddress/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopbilldeliveryaddress/index"><span class="submenu-title">Адреса покупателей</span></a></li>
                <li <?php if(strpos($siteData->url, '/shopotheraddress/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopotheraddress/index"><span class="submenu-title">Другие адреса</span></a></li>
            <?php }elseif($siteData->operation->getShopPositionID() == Model_AutoPart_Shop_Position::POSITION_COURIER){ ?>
            <?php } ?>
        </ul>
    </li>
<?php } ?>
<?php if($siteData->operation->getShopPositionID() == 0){ ?>
    <li <?php if(strpos($siteData->url, '/shopbill/')){echo 'class="active"';}?>>
        <a href="<?php echo $siteData->urlBasic; ?>/market/shopbill/index">
            <i class="fa fa-pagelines fa-fw">
                <div class="icon-bg bg-green"></div>
            </i>
            <span class="menu-title">Закуп</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="nav nav-second-level">
            <li <?php if(strpos($siteData->url, '/shoppreorder/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shoppreorder/index"><span class="submenu-title">Закуп товаров</span></a></li>
            <li <?php if(strpos($siteData->url, '/shopcourierroute/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopcourierroute/index"><span class="submenu-title">Маршруты</span></a></li>
            <li <?php if(strpos($siteData->url, '/shopcourier/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopcourier/index"><span class="submenu-title">Курьеры</span></a></li>
            <li <?php if(strpos($siteData->url, '/shopcourierpoint/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopcourierpoint/index"><span class="submenu-title">Точки маршрута курьеров</span></a></li>
            <li <?php if(strpos($siteData->url, '/shopsupplier/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopsupplier/index"><span class="submenu-title">Поставщики</span></a></li>
        </ul>
    </li>
<?php } ?>
<?php if($siteData->operation->getShopPositionID() == 0 || $siteData->operation->getShopPositionID() == Model_AutoPart_Shop_Position::POSITION_COURIER){ ?>
    <li <?php if(strpos($siteData->url, '/shopbill/')){echo 'class="active"';}?>>
        <a href="<?php echo $siteData->urlBasic; ?>/market/shopbill/index">
            <i class="fa fa-pagelines fa-fw">
                <div class="icon-bg bg-green"></div>
            </i>
            <span class="menu-title">Закуп курьером</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="nav nav-second-level">
            <li <?php if(strpos($siteData->url, '/shopbill/courier')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopbill/courier"><span class="submenu-title">Заказы курьера</span></a></li>
            <li <?php if(strpos($siteData->url, '/shopcourierroute/my_route')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopcourierroute/my_route"><span class="submenu-title">Мой маршрут</span></a></li>
            <li <?php if(strpos($siteData->url, '/shopcourierroute/courier')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopcourierroute/courier"><span class="submenu-title">Маршруты</span></a></li>
            <li <?php if(strpos($siteData->url, '/shoppreorder/courier')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shoppreorder/courier"><span class="submenu-title">Закуп товаров</span></a></li>
            <li <?php if(strpos($siteData->url, '/shopbillitem/stock_courier') || strpos($siteData->url, '/shopbillitem/stock_transfer')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopbillitem/stock_courier"><span class="submenu-title">Подочетные товары</span></a></li>
        </ul>
    </li>
<?php } ?>
<?php if($siteData->operation->getShopPositionID() == 0 || $siteData->operation->getShopPositionID() == Model_AutoPart_Shop_Position::POSITION_BOOKKEEPING){ ?>
    <li <?php if(strpos($siteData->url, '/shopbill/')){echo 'class="active"';}?>>
        <a href="<?php echo $siteData->urlBasic; ?>/market/shopbill/index">
            <i class="fa fa-pagelines fa-fw">
                <div class="icon-bg bg-green"></div>
            </i>
            <span class="menu-title">Бухгалтеру</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="nav nav-second-level">
            <li <?php if(strpos($siteData->url, '/shopreceiveitem/stock')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopreceiveitem/stock"><span class="submenu-title">Товары на складе</span></a></li>
            <li <?php if(strpos($siteData->url, '/shopbillitem/sold')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopbillitem/sold"><span class="submenu-title">Проданные товары</span></a></li>
            <li <?php if(strpos($siteData->url, '/shopreceive/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopreceive/index"><span class="submenu-title">Накладные</span></a></li>

            <li <?php if(strpos($siteData->url, '/shopbillitem/completed')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopbillitem/completed"><span class="submenu-title">Цены закупа заказов</span></a></li>
            <li <?php if(strpos($siteData->url, '/shoppaymentcourier/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shoppaymentcourier/index"><span class="submenu-title">Выплаты курьерам для закупа</span></a></li>
            <li <?php if(strpos($siteData->url, '/shoppaymentsource/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shoppaymentsource/index"><span class="submenu-title">Выплаты от источников</span></a></li>
            <li <?php if(strpos($siteData->url, '/shopcommissionsource/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopcommissionsource/index"><span class="submenu-title">Коммисия за продажу источника</span></a></li>
            <li <?php if(strpos($siteData->url, '/shopexpense/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopexpense/index"><span class="submenu-title">Расходы</span></a></li>

            <li <?php if(strpos($siteData->url, '/shopexpensetype/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopexpensetype/index"><span class="submenu-title">Типы расходов</span></a></li>
            <li <?php if(strpos($siteData->url, '/shopbankaccountbalance/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopbankaccountbalance/index"><span class="submenu-title">Баланс банковских счетов</span></a></li>
        </ul>
    </li>
<?php } ?>
<?php if($siteData->operation->getShopPositionID() == 0){ ?>
    <li <?php if(strpos($siteData->url, '/shopbill/')){echo 'class="active"';}?>>
        <a href="<?php echo $siteData->urlBasic; ?>/market/shopbill/index">
            <i class="fa fa-pagelines fa-fw">
                <div class="icon-bg bg-green"></div>
            </i>
            <span class="menu-title">Деньги</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="nav nav-second-level">
            <li <?php if(strpos($siteData->url, '/shopreceive/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopreceive/index"><span class="submenu-title">Накладные</span></a></li>

        </ul>
    </li>
<?php } ?>
<?php if($siteData->operation->getShopPositionID() == 0){ ?>
    <li>
        <a href="#">
            <i class="fa fa-edit fa-fw">
                <div class="icon-bg bg-violet"></div>
            </i>
            <span class="menu-title">Товары</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="nav nav-second-level">
            <li <?php if(strpos($siteData->url, '/shopsupplierpricelist/index')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopsupplierpricelist/index"><span class="submenu-title">Прайс листы поставщиков</span></a></li>
            <li <?php if(strpos($siteData->url, '/shopproduct/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopproduct/index"><span class="submenu-title">Товары</span></a></li>
            <li <?php if(strpos($siteData->url, '/shopproduct/child_product')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopproduct/child_product"><span class="submenu-title">Связь товаров</span></a></li>
            <li <?php if(strpos($siteData->url, '/shoprubric/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shoprubric/index"><span class="submenu-title">Рубрики</span></a></li>
            <li <?php if(strpos($siteData->url, '/shopbrand/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopbrand/index"><span class="submenu-title">Бренды</span></a></li>
            <li <?php if(strpos($siteData->url, '/shopsupplier/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopsupplier/index"><span class="submenu-title">Поставщики</span></a></li>
        </ul>
    </li>
<?php } ?>
<?php if($siteData->operation->getShopPositionID() == 0 || $siteData->operation->getShopPositionID() == Model_AutoPart_Shop_Position::POSITION_INDETIFY){ ?>
    <li>
        <a href="#">
            <i class="fa fa-edit fa-fw">
                <div class="icon-bg bg-violet"></div>
            </i>
            <span class="menu-title">Интеграция</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="nav nav-second-level">
            <li <?php if(strpos($siteData->url, '/shopproduct/identify')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopproduct/identify"><span class="submenu-title">Распознание товаров</span></a></li>
            <li <?php if(strpos($siteData->url, '/shopproductsource/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopproductsource/index"><span class="submenu-title">Распознанные товары</span></a></li>
            <li <?php if(strpos($siteData->url, '/shopproductjoin/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopproductjoin/index"><span class="submenu-title">Статистика распознаний</span></a></li>
            <li <?php if(strpos($siteData->url, '/shopproductsourceprice/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopproductsourceprice/index"><span class="submenu-title">Цены реализации</span></a></li>
            <li <?php if(strpos($siteData->url, '/shopproduct/work')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopproduct/work"><span class="submenu-title">Нераспознанные товары</span></a></li>
            <li <?php if(strpos($siteData->url, '/shoprubricsource/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shoprubricsource/index"><span class="submenu-title">Рубрики</span></a></li>
            <li <?php if(strpos($siteData->url, '/shopsource/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopsource/index"><span class="submenu-title">Источники</span></a></li>
        </ul>
    </li>
<?php } ?>
<?php if($siteData->operation->getIsAdmin() || $siteData->operation->getShopPositionID() == Model_AutoPart_Shop_Position::POSITION_INVESTOR){ ?>
    <li>
        <a href="#">
            <i class="fa fa-edit fa-fw">
                <div class="icon-bg bg-violet"></div>
            </i>
            <span class="menu-title">Инвестору</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="nav nav-second-level">
            <li <?php if(strpos($siteData->url, '/shopbillitem/income')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopbillitem/income"><span class="submenu-title">Доход с товаров</span></a></li>
            <li <?php if(strpos($siteData->url, '/shopinvestordeposit/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopinvestordeposit/index"><span class="submenu-title">Вклады</span></a></li>
            <li <?php if(strpos($siteData->url, '/shopinvestorincome/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopinvestorincome/index"><span class="submenu-title">Доходы</span></a></li>
            <li <?php if(strpos($siteData->url, '/shopinvestor/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopinvestor/index"><span class="submenu-title">Инвесторы</span></a></li>
        </ul>
    </li>
<?php } ?>
<?php if($siteData->operation->getIsAdmin()){ ?>
    <li>
        <a href="#">
            <i class="fa fa-edit fa-fw">
                <div class="icon-bg bg-violet"></div>
            </i>
            <span class="menu-title">Данные компаний</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="nav nav-second-level">
            <li <?php if(strpos($siteData->url, '/shopcompany/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopcompany/index"><span class="submenu-title">Компании</span></a></li>
            <li <?php if(strpos($siteData->url, '/shopoffice/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopoffice/index"><span class="submenu-title">Офисы</span></a></li>
            <li <?php if(strpos($siteData->url, '/shopproductstorage/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopproductstorage/index"><span class="submenu-title">Склады</span></a></li>
            <li <?php if(strpos($siteData->url, '/shopbankaccount/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopbankaccount/index"><span class="submenu-title">Банковские счета</span></a></li>
        </ul>
    </li>
<?php } ?>
<?php if($siteData->operation->getIsAdmin()){ ?>
    <li>
        <a href="#">
            <i class="fa fa-edit fa-fw">
                <div class="icon-bg bg-violet"></div>
            </i>
            <span class="menu-title">Справочники</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="nav nav-second-level">
            <li <?php if(strpos($siteData->url, '/shopproductstorage/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopproductstorage/index"><span class="submenu-title">Список складов</span></a></li>
            <li <?php if(strpos($siteData->url, '/shopoffice/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopoffice/index"><span class="submenu-title">Список офисов компании</span></a></li>
            <li <?php if(strpos($siteData->url, '/shopbilldeliverytype/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopbilldeliverytype/index"><span class="submenu-title">Способы доставки</span></a></li>
            <li <?php if(strpos($siteData->url, '/shopbillpaymenttype/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopbillpaymenttype/index"><span class="submenu-title">Способы оплаты</span></a></li>
            <li <?php if(strpos($siteData->url, '/shopbillstatus/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopbillstatus/index"><span class="submenu-title">Статусы заказов</span></a></li>
            <li <?php if(strpos($siteData->url, '/shopbillitemstatus/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopbillitemstatus/index"><span class="submenu-title">Статусы товаров заказов</span></a></li>
            <li <?php if(strpos($siteData->url, '/shopbillstatussource/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopbillstatussource/index"><span class="submenu-title">Статусы заказа источников</span></a></li>
            <li <?php if(strpos($siteData->url, '/shopbillcanceltype/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopbillcanceltype/index"><span class="submenu-title">Причины отказов</span></a></li>
            <li <?php if(strpos($siteData->url, '/shopbillstatesource/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopbillstatesource/index"><span class="submenu-title">Стадии обработки заказа</span></a></li>
            <li <?php if(strpos($siteData->url, '/shopproductstatus/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopproductstatus/index"><span class="submenu-title">Статусы товаров</span></a></li>
            <?php if($siteData->operation->getIsAdmin()){ ?>
                <li <?php if(strpos($siteData->url, '/shopoperation/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopoperation/index"><span class="submenu-title">Операторы</span></a></li>
                <li <?php if(strpos($siteData->url, '/shopposition/')){echo 'class="active"';}?>><a href="<?php echo $siteData->urlBasic; ?>/market/shopposition/index"><span class="submenu-title">Должность</span></a></li>
            <?php } ?>
        </ul>
    </li>
<?php } ?>