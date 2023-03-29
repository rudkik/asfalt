<div class="menu-top">
    <nav class="navbar navbar-default navbar-static" role="navigation" id="menu-top" style="background-color: #d87a68;">
        <div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#menu-top .bs-example-js-navbar-collapse">
                <span class="sr-only">Переключить навигацию</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="navbar-collapse bs-example-js-navbar-collapse collapse" aria-expanded="false" style="height: 1px;">
            <ul class="nav navbar-nav">
                <?php if ((Func::isShopMenu('shoptablecatalog/group', $siteData))){ ?>
                    <li class="dropdown">
                        <a id="drop0" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Виды объектов <b class="caret"></b></a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="drop0">
                            <?php if ((Func::isShopMenu('shoptablecatalog/branch', $siteData))){ ?>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo Func::getFullURL($siteData, '/shoptablecatalog/index', array(), array('is_public_ignore' => 1, 'table_id' => Model_Shop::TABLE_ID)); ?>">
                                        Виды филиалов
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ((Func::isShopMenu('shoptablecatalog/good', $siteData))){ ?>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo Func::getFullURL($siteData, '/shoptablecatalog/index', array(), array('is_public_ignore' => 1, 'table_id' => Model_Shop_Good::TABLE_ID)); ?>">
                                        Виды товаров / услуг
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ((Func::isShopMenu('shoptablecatalog/new', $siteData))){ ?>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo Func::getFullURL($siteData, '/shoptablecatalog/index', array(), array('is_public_ignore' => 1, 'table_id' => Model_Shop_New::TABLE_ID)); ?>">
                                        Виды новостей / статей
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ((Func::isShopMenu('shoptablecatalog/file', $siteData))){ ?>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo Func::getFullURL($siteData, '/shoptablecatalog/index', array(), array('is_public_ignore' => 1, 'table_id' => Model_Shop_File::TABLE_ID)); ?>">
                                        Виды файлов
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ((Func::isShopMenu('shoptablecatalog/calendar', $siteData))){ ?>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo Func::getFullURL($siteData, '/shoptablecatalog/index', array(), array('is_public_ignore' => 1, 'table_id' => Model_Shop_File::TABLE_ID)); ?>">
                                        Виды календарей
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ((Func::isShopMenu('shoptablecatalog/gallery', $siteData))){ ?>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo Func::getFullURL($siteData, '/shoptablecatalog/index', array(), array('is_public_ignore' => 1, 'table_id' => Model_Shop_Gallery::TABLE_ID)); ?>">
                                        Виды галерей
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ((Func::isShopMenu('shoptablecatalog/bill', $siteData))){ ?>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo Func::getFullURL($siteData, '/shoptablecatalog/index', array(), array('is_public_ignore' => 1, 'table_id' => Model_Shop_Bill::TABLE_ID)); ?>">
                                        Виды заказов
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ((Func::isShopMenu('shoptablecatalog/question', $siteData))){ ?>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo Func::getFullURL($siteData, '/shoptablecatalog/index', array(), array('is_public_ignore' => 1, 'table_id' => Model_Shop_Question::TABLE_ID)); ?>">
                                        Виды вопросов
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ((Func::isShopMenu('shoptablecatalog/comment', $siteData))){ ?>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo Func::getFullURL($siteData, '/shoptablecatalog/index', array(), array('is_public_ignore' => 1, 'table_id' => Model_Shop_Comment::TABLE_ID)); ?>">
                                        Виды комментарий
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ((Func::isShopMenu('shoptablecatalog/operation', $siteData))){ ?>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo Func::getFullURL($siteData, '/shoptablecatalog/index', array(), array('is_public_ignore' => 1, 'table_id' => Model_Shop_Operation::TABLE_ID)); ?>">
                                        Виды операторов
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ((Func::isShopMenu('shoptablecatalog/client', $siteData))){ ?>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo Func::getFullURL($siteData, '/shoptablecatalog/index', array(), array('is_public_ignore' => 1, 'table_id' => Model_Shop_Client::TABLE_ID)); ?>">
                                        Виды клиентов
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ((Func::isShopMenu('shoptablecatalog/coupon', $siteData))){ ?>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo Func::getFullURL($siteData, '/shoptablecatalog/index', array(), array('is_public_ignore' => 1, 'table_id' => Model_Shop_Coupon::TABLE_ID)); ?>">
                                        Виды купонов
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>
                <?php if ((Func::isShopMenu('shopbranch/group', $siteData))){ ?>
                    <li class="dropdown">
                        <a id="drop0" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Филиалы <b class="caret"></b></a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="drop0">
                            <?php echo $siteData->globalDatas['view::_shop/_table/catalog/menu/top/list/shopbranch'];?>
                        </ul>
                    </li>
                <?php } ?>

                <?php if ((Func::isShopMenu('shopgood/group', $siteData))){ ?>
                    <li class="dropdown">
                        <a id="drop1" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Товары / услуги <b class="caret"></b></a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="drop1">
                            <?php echo $siteData->globalDatas['view::_shop/_table/catalog/menu/top/list/shopgood'];?>

                            <?php echo $siteData->globalDatas['view::_shop/_table/catalog/menu/top/list/shopcoupon'];?>

                            <?php echo $siteData->globalDatas['view::_shop/_table/catalog/menu/top/list/shoppersondiscount'];?>

                            <?php if ((Func::isShopMenu('shopaction/index', $siteData))){ ?>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopaction/index?is_public_ignore=1&<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                        Акции
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ((Func::isShopMenu('shopdiscount/index', $siteData))){ ?>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopdiscount/index?is_public_ignore=1&<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                        Скидки
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ((Func::isShopMenu('shopgoodtooperation/index', $siteData))){ ?>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopgoodtooperation/index?&<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                        Цены операторов
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>

                <?php if ((Func::isShopMenu('shopcar/group', $siteData))){ ?>
                    <li class="dropdown">
                        <a id="drop1" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Машины <b class="caret"></b></a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="drop1">
                            <?php echo $siteData->globalDatas['view::_shop/_table/catalog/menu/top/list/shopcar'];?>
                        </ul>
                    </li>
                <?php } ?>

                <?php if ((Func::isShopMenu('shopnew/group', $siteData))
                    || (Func::isShopMenu('shopgallery/group', $siteData))
                    || (Func::isShopMenu('shopfile/group', $siteData))
                    || (Func::isShopMenu('shopcalendar/group', $siteData))){ ?>
                    <li class="dropdown">
                        <a id="drop2" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Статьи / новости <b class="caret"></b></a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="drop2">
                            <?php echo $siteData->globalDatas['view::_shop/_table/catalog/menu/top/list/shopnew'];?>
                            <?php echo $siteData->globalDatas['view::_shop/_table/catalog/menu/top/list/shopgallery'];?>
                            <?php echo $siteData->globalDatas['view::_shop/_table/catalog/menu/top/list/shopfile'];?>
                            <?php echo $siteData->globalDatas['view::_shop/_table/catalog/menu/top/list/shopcalendar'];?>
                        </ul>
                    </li>
                <?php } ?>

                <?php if ((Func::isShopMenu('shopsubscribe/group', $siteData))
                    || (Func::isShopMenu('shopcomment/group', $siteData))
                    || (Func::isShopMenu('shopmessage/group', $siteData))
                    || (Func::isShopMenu('shopquestion/group', $siteData))
                    || (Func::isShopMenu('shopclient/group', $siteData))){ ?>
                    <li class="dropdown">
                        <a id="drop3" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">От пользователей <b class="caret"></b></a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="drop3">
                            <?php echo $siteData->globalDatas['view::_shop/_table/catalog/menu/top/list/shopclient'];?>
                            <?php echo $siteData->globalDatas['view::_shop/_table/catalog/menu/top/list/shopcomment'];?>
                            <?php echo $siteData->globalDatas['view::_shop/_table/catalog/menu/top/list/shopquestion'];?>
                            <?php echo $siteData->globalDatas['view::_shop/_table/catalog/menu/top/list/shopmessage'];?>
                            <?php echo $siteData->globalDatas['view::_shop/_table/catalog/menu/top/list/shopsubscribe'];?>
                        </ul>
                    </li>
                <?php } ?>

                <?php if ((Func::isShopMenu('shopbill/group', $siteData))){ ?>
                    <li class="dropdown">
                        <a id="drop3" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Заказы <b class="caret"></b></a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="drop3">
                            <?php echo $siteData->globalDatas['view::_shop/_table/catalog/menu/top/list/shopbill'];?>
                            <?php echo $siteData->globalDatas['view::_shop/_table/catalog/menu/top/list/shopoperationstock'];?>
                            <?php echo $siteData->globalDatas['view::_shop/_table/catalog/menu/top/list/shoppaid'];?>
                            <?php if ((Func::isShopMenu('shopbillstatus/index', $siteData))){ ?>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo Func::getFullURL($siteData, '/shopbillstatus/index', array(), array('is_public_ignore' => 1)); ?>">
                                        Статусы заказов
                                    </a>
                                </li>
                            <?php } ?>
                            <?php echo $siteData->globalDatas['view::_shop/_table/catalog/menu/top/list/shopreturn'];?>
                        </ul>
                    </li>
                <?php } ?>
                <?php if (Func::isShopMenu('shopinformation/group', $siteData)){ ?>
                    <li class="dropdown">
                        <a id="drop3" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Информация о компании <b class="caret"></b></a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="drop3">
                            <?php echo $siteData->globalDatas['view::_shop/_table/catalog/menu/top/list/shopoperation'];?>
                            <li role="presentation">
                                <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/user/index?1=1<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                    Пользователи
                                </a>
                            </li>
                            <?php if ((Func::isShopMenu('shop/edit', $siteData))){ ?>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shop/edit?is_edit=1&id=<?php echo $siteData->shopID; ?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                        Информация о компании
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ((Func::isShopMenu('shopaddress/editmain', $siteData))){ ?>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopaddress/editmain?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                        Основной адрес
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ((Func::isShopMenu('shopaddress/index', $siteData))){ ?>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopaddress/index?is_public_ignore=1&<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                        Дополнительные адреса
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ((Func::isShopMenu('shopaddresscontact/index', $siteData))){ ?>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopaddresscontact/index?is_public_ignore=1&<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                        Контакты
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ((Func::isShopMenu('shopaddresscontactrubric/index', $siteData))){ ?>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopaddresscontactrubric/index?is_public_ignore=1&<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                        Рубрики контактов
                                    </a>
                                </li>
                            <?php } ?>
                            <li class="divider" role="presentation"></li>

                            <?php if ((Func::isShopMenu('shopdeliverytype/index', $siteData))){ ?>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopdeliverytype/index?is_public_ignore=1&<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                        Доставка
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ((Func::isShopMenu('shoppaidtype/index', $siteData))){ ?>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoppaidtype/index?is_public_ignore=1&<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                        Оплата
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>

                <?php if (Func::isShopMenu('siteoptions/heads', $siteData)
                    || Func::isShopMenu('shopemail/index', $siteData)){ ?>
                    <li class="dropdown">
                        <a id="drop4" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Настройки сайта <b class="caret"></b></a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="drop4">
                            <?php if ((Func::isShopMenu('siteoptions/heads', $siteData))){ ?>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/siteoptions/head?is_edit=1&id=<?php echo $siteData->shopID; ?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                        SEO-настройки
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ((Func::isShopMenu('shopemail/index', $siteData))){ ?>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopemail/index?is_public_ignore=1&<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                        Шаблоны e-mail сообщений
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ((Func::isShopMenu('shopredirect/index', $siteData))){ ?>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopredirect/index?is_public_ignore=1&<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                        Настройка редиректа
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </nav>
</div>