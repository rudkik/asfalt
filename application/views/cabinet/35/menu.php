<?php if ($siteData->controllerName =='shoptablecatalog'){ ?>
        <?php if ((Func::isShopMenu('shoptablecatalog/branch', $siteData))){ ?>
            <li <?php if(Request_RequestParams::getParamInt('table_id') != Model_Shop::TABLE_ID){echo 'class="menu-left"';} ?>>
                <a href="<?php echo Func::getFullURL($siteData, '/shoptablecatalog/index', array(), array('is_public_ignore' => 1, 'table_id' => Model_Shop::TABLE_ID)); ?>"><i class="fa fa-circle-o text-red"></i>
                    <span>Виды филиалов</span>
                </a>
            </li>
        <?php } ?>
        <?php if ((Func::isShopMenu('shoptablecatalog/good', $siteData))){ ?>
            <li <?php if(Request_RequestParams::getParamInt('table_id') != Model_Shop_Good::TABLE_ID){echo 'class="menu-left"';} ?>>
                <a href="<?php echo Func::getFullURL($siteData, '/shoptablecatalog/index', array(), array('is_public_ignore' => 1, 'table_id' => Model_Shop_Good::TABLE_ID)); ?>"><i class="fa fa-circle-o text-red"></i>
                    <span>Виды товаров / услуг</span>
                </a>
            </li>
        <?php } ?>
        <?php if ((Func::isShopMenu('shoptablecatalog/new', $siteData))){ ?>
            <li <?php if(Request_RequestParams::getParamInt('table_id') != Model_Shop_New::TABLE_ID){echo 'class="menu-left"';} ?>>
                <a href="<?php echo Func::getFullURL($siteData, '/shoptablecatalog/index', array(), array('is_public_ignore' => 1, 'table_id' => Model_Shop_New::TABLE_ID)); ?>"><i class="fa fa-circle-o text-red"></i>
                    <span>Виды новостей / статей</span>
                </a>
            </li>
        <?php } ?>
        <?php if ((Func::isShopMenu('shoptablecatalog/file', $siteData))){ ?>
            <li <?php if(Request_RequestParams::getParamInt('table_id') != Model_Shop_File::TABLE_ID){echo 'class="menu-left"';} ?>>
                <a href="<?php echo Func::getFullURL($siteData, '/shoptablecatalog/index', array(), array('is_public_ignore' => 1, 'table_id' => Model_Shop_File::TABLE_ID)); ?>"><i class="fa fa-circle-o text-red"></i>
                    <span>Виды файлов</span>
                </a>
            </li>
        <?php } ?>
        <?php if ((Func::isShopMenu('shoptablecatalog/calendar', $siteData))){ ?>
            <li <?php if(Request_RequestParams::getParamInt('table_id') != Model_Shop_File::TABLE_ID){echo 'class="menu-left"';} ?>>
                <a href="<?php echo Func::getFullURL($siteData, '/shoptablecatalog/index', array(), array('is_public_ignore' => 1, 'table_id' => Model_Shop_Calendar::TABLE_ID)); ?>"><i class="fa fa-circle-o text-red"></i>
                    <span>Виды календаря</span>
                </a>
            </li>
        <?php } ?>
        <?php if ((Func::isShopMenu('shoptablecatalog/gallery', $siteData))){ ?>
            <li <?php if(Request_RequestParams::getParamInt('table_id') != Model_Shop_Gallery::TABLE_ID){echo 'class="menu-left"';} ?>>
                <a href="<?php echo Func::getFullURL($siteData, '/shoptablecatalog/index', array(), array('is_public_ignore' => 1, 'table_id' => Model_Shop_Gallery::TABLE_ID)); ?>"><i class="fa fa-circle-o text-red"></i>
                    <span>Виды галерей</span>
                </a>
            </li>
        <?php } ?>
        <?php if ((Func::isShopMenu('shoptablecatalog/bill', $siteData))){ ?>
            <li <?php if(Request_RequestParams::getParamInt('table_id') != Model_Shop_Bill::TABLE_ID){echo 'class="menu-left"';} ?>>
                <a href="<?php echo Func::getFullURL($siteData, '/shoptablecatalog/index', array(), array('is_public_ignore' => 1, 'table_id' => Model_Shop_Bill::TABLE_ID)); ?>"><i class="fa fa-circle-o text-red"></i>
                    <span>Виды заказов</span>
                </a>
            </li>
        <?php } ?>
        <?php if ((Func::isShopMenu('shoptablecatalog/operationstock', $siteData))){ ?>
            <li <?php if(Request_RequestParams::getParamInt('table_id') != Model_Shop_Bill::TABLE_ID){echo 'class="menu-left"';} ?>>
                <a href="<?php echo Func::getFullURL($siteData, '/shoptablecatalog/index', array(), array('is_public_ignore' => 1, 'table_id' => Model_Shop_Operation_Stock::TABLE_ID)); ?>"><i class="fa fa-circle-o text-red"></i>
                    <span>Виды складов менеджеров</span>
                </a>
            </li>
        <?php } ?>
        <?php if ((Func::isShopMenu('shoptablecatalog/question', $siteData))){ ?>
            <li <?php if(Request_RequestParams::getParamInt('table_id') != Model_Shop_Question::TABLE_ID){echo 'class="menu-left"';} ?>>
                <a href="<?php echo Func::getFullURL($siteData, '/shoptablecatalog/index', array(), array('is_public_ignore' => 1, 'table_id' => Model_Shop_Question::TABLE_ID)); ?>"><i class="fa fa-circle-o text-red"></i>
                    <span>Виды вопросов</span>
                </a>
            </li>
        <?php } ?>
        <?php if ((Func::isShopMenu('shoptablecatalog/comment', $siteData))){ ?>
            <li <?php if(Request_RequestParams::getParamInt('table_id') != Model_Shop_Comment::TABLE_ID){echo 'class="menu-left"';} ?>>
                <a href="<?php echo Func::getFullURL($siteData, '/shoptablecatalog/index', array(), array('is_public_ignore' => 1, 'table_id' => Model_Shop_Comment::TABLE_ID)); ?>"><i class="fa fa-circle-o text-red"></i>
                    <span>Виды комментарий</span>
                </a>
            </li>
        <?php } ?>
        <?php if ((Func::isShopMenu('shoptablecatalog/operation', $siteData))){ ?>
            <li <?php if(Request_RequestParams::getParamInt('table_id') != Model_Shop_Operation::TABLE_ID){echo 'class="menu-left"';} ?>>
                <a href="<?php echo Func::getFullURL($siteData, '/shoptablecatalog/index', array(), array('is_public_ignore' => 1, 'table_id' => Model_Shop_Operation::TABLE_ID)); ?>"><i class="fa fa-circle-o text-red"></i>
                    <span>Виды операторов</span>
                </a>
            </li>
        <?php } ?>
        <?php if ((Func::isShopMenu('shoptablecatalog/client', $siteData))){ ?>
            <li <?php if(Request_RequestParams::getParamInt('table_id') != Model_Shop_Client::TABLE_ID){echo 'class="menu-left"';} ?>>
                <a href="<?php echo Func::getFullURL($siteData, '/shoptablecatalog/index', array(), array('is_public_ignore' => 1, 'table_id' => Model_Shop_Client::TABLE_ID)); ?>"><i class="fa fa-circle-o text-red"></i>
                    <span>Виды клиентов</span>
                </a>
            </li>
        <?php } ?>
        <?php if ((Func::isShopMenu('shoptablecatalog/coupon', $siteData))){ ?>
            <li <?php if(Request_RequestParams::getParamInt('table_id') != Model_Shop_Coupon::TABLE_ID){echo 'class="menu-left"';} ?>>
                <a href="<?php echo Func::getFullURL($siteData, '/shoptablecatalog/index', array(), array('is_public_ignore' => 1, 'table_id' => Model_Shop_Coupon::TABLE_ID)); ?>"><i class="fa fa-circle-o text-red"></i>
                    <span>Виды купонов</span>
                </a>
            </li>
        <?php } ?>

<?php }elseif(($siteData->controllerName =='shopbranch')
    ||(($siteData->controllerName =='shoptablerubric') && (Request_RequestParams::getParamInt('table_id') == Model_Shop::TABLE_ID))){ ?>
    <?php echo $siteData->globalDatas['view::_shop/_table/catalog/menu/list/shopbranch'];?>

<?php }elseif(($siteData->controllerName =='shopcar')
    ||($siteData->controllerName =='shopmodel')
    ||($siteData->controllerName =='shopmark')
    ||(($siteData->controllerName =='shoptablehashtag') && (Request_RequestParams::getParamInt('table_id') == Model_Shop_Car::TABLE_ID))
    ||(($siteData->controllerName =='shoptablestock') && (Request_RequestParams::getParamInt('table_id') == Model_Shop_Car::TABLE_ID))
    ||(($siteData->controllerName =='shoptableparam') && (Request_RequestParams::getParamInt('table_id') == Model_Shop_Car::TABLE_ID))
    ||(($siteData->controllerName =='shoptablerubric') && (Request_RequestParams::getParamInt('table_id') == Model_Shop_Car::TABLE_ID))){ ?>
    <?php echo $siteData->globalDatas['view::_shop/_table/catalog/menu/list/shopcar'];?>
<?php }elseif(($siteData->controllerName =='shopgood')
    || ($siteData->controllerName =='shopaction')
    || ($siteData->controllerName =='shopdiscount')
    || ($siteData->controllerName =='shopgoodtooperation')
    ||(($siteData->controllerName =='shoptablehashtag') && (Request_RequestParams::getParamInt('table_id') == Model_Shop_Good::TABLE_ID))
    ||(($siteData->controllerName =='shoptablestock') && (Request_RequestParams::getParamInt('table_id') == Model_Shop_Good::TABLE_ID))
    ||(($siteData->controllerName =='shoptablebrand') && (Request_RequestParams::getParamInt('table_id') == Model_Shop_Good::TABLE_ID))
    ||(($siteData->controllerName =='shoptableselect') && (Request_RequestParams::getParamInt('table_id') == Model_Shop_Good::TABLE_ID))
    ||(($siteData->controllerName =='shoptableunit') && (Request_RequestParams::getParamInt('table_id') == Model_Shop_Good::TABLE_ID))
    ||(($siteData->controllerName =='shoptablerubric') && (Request_RequestParams::getParamInt('table_id') == Model_Shop_Good::TABLE_ID))){ ?>
    <?php echo $siteData->globalDatas['view::_shop/_table/catalog/menu/list/shopgood'];?>
    <?php echo $siteData->globalDatas['view::_shop/_table/catalog/menu/list/shopcoupon'];?>
    <?php echo $siteData->globalDatas['view::_shop/_table/catalog/menu/list/shoppersondiscount'];?>

    <?php if ((Func::isShopMenu('shopaction/index', $siteData))){ ?>
        <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shopaction/index'){echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopaction/index?is_public_ignore=1&<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-lime"></i>
                <span>Акции</span>
            </a>
        </li>
    <?php } ?>
    <?php if ((Func::isShopMenu('shopdiscount/index', $siteData))){ ?>
        <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shopdiscount/index'){echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopdiscount/index?is_public_ignore=1&<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-orange"></i>
                <span>Скидки</span>
            </a>
        </li>
    <?php } ?>
    <?php if ((Func::isShopMenu('shopgoodtooperation/index', $siteData))){ ?>
        <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shopgoodtooperation/index'){echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopgoodtooperation/index?&<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-orange"></i>
                <span>Цены операторов</span>
            </a>
        </li>
    <?php } ?>

<?php }elseif(($siteData->controllerName =='shopnew')
    || ($siteData->controllerName =='shopgallery')
    || ($siteData->controllerName =='shopfile')
    || ($siteData->controllerName =='shopcalendar')
    ||(($siteData->controllerName =='shoptablerubric')
        && ((Request_RequestParams::getParamInt('table_id') == Model_Shop_New::TABLE_ID)
        || (Request_RequestParams::getParamInt('table_id') == Model_Shop_Gallery::TABLE_ID)
        ||(Request_RequestParams::getParamInt('table_id') == Model_Shop_File::TABLE_ID)))){ ?>

    <?php echo $siteData->globalDatas['view::_shop/_table/catalog/menu/list/shopnew'];?>
    <?php echo $siteData->globalDatas['view::_shop/_table/catalog/menu/list/shopgallery'];?>
    <?php echo $siteData->globalDatas['view::_shop/_table/catalog/menu/list/shopfile'];?>
    <?php echo $siteData->globalDatas['view::_shop/_table/catalog/menu/list/shopcalendar'];?>

<?php }elseif(($siteData->controllerName =='shopclient')
    || ($siteData->controllerName =='shopcomment')
    || ($siteData->controllerName =='shopquestion')
    || ($siteData->controllerName =='shopmessage')
    || ($siteData->controllerName =='shopsubscribe')
    || (($siteData->controllerName =='shoptablerubric')
        && ((Request_RequestParams::getParamInt('table_id') == Model_Shop_Client::TABLE_ID)
        || (Request_RequestParams::getParamInt('table_id') == Model_Shop_Comment::TABLE_ID)
        || (Request_RequestParams::getParamInt('table_id') == Model_Shop_Question::TABLE_ID)
        || (Request_RequestParams::getParamInt('table_id') == Model_Shop_Message::TABLE_ID)
        || (Request_RequestParams::getParamInt('table_id') == Model_Shop_Subscribe::TABLE_ID)))){ ?>

    <?php echo $siteData->globalDatas['view::_shop/_table/catalog/menu/list/shopclient'];?>
    <?php echo $siteData->globalDatas['view::_shop/_table/catalog/menu/list/shopcomment'];?>
    <?php echo $siteData->globalDatas['view::_shop/_table/catalog/menu/list/shopquestion'];?>
    <?php echo $siteData->globalDatas['view::_shop/_table/catalog/menu/list/shopmessage'];?>
    <?php echo $siteData->globalDatas['view::_shop/_table/catalog/menu/list/shopsubscribe'];?>

<?php }elseif(($siteData->controllerName =='shopbill')
    || ($siteData->controllerName =='shopbillstatus')
    || ($siteData->controllerName =='shoppaid')
    || ($siteData->controllerName =='shopreturn')
    || ($siteData->controllerName =='shopoperationstock')
    || ($siteData->controllerName =='shopreport')){ ?>

    <?php echo $siteData->globalDatas['view::_shop/_table/catalog/menu/list/shopbill'];?>
    <?php echo $siteData->globalDatas['view::_shop/_table/catalog/menu/list/shopoperationstock'];?>
    <?php echo $siteData->globalDatas['view::_shop/_table/catalog/menu/list/shoppaid'];?>
    <?php if ((Func::isShopMenu('shopbillstatus/index', $siteData))){ ?>
        <li <?php if(!(($siteData->controllerName == 'shopbillstatus')
            && (Request_RequestParams::getParamInt('type') == $data->id))){echo 'class="menu-left"';} ?>>
            <a href="<?php echo Func::getFullURL($siteData, '/shopbillstatus/index', array(), array('is_public_ignore' => 1)); ?>"><i class="fa fa-circle-o text-light-blue"></i>
                <span>Статусы заказов</span>
            </a>
        </li>
    <?php } ?>
    <?php echo $siteData->globalDatas['view::_shop/_table/catalog/menu/list/shopreturn'];?>

<?php }elseif(($siteData->controllerName =='shop')
    || ($siteData->controllerName =='shopaddress')
    || ($siteData->controllerName =='shopaddresscontact')
    || ($siteData->controllerName =='shopdeliverytype')
    || ($siteData->controllerName =='shoppaidtype')
    || ($siteData->controllerName =='shopoperation')
    ||(($siteData->controllerName =='shoptablerubric') && (Request_RequestParams::getParamInt('table_id') == Model_Shop_AddressContact::TABLE_ID))){ ?>

    <?php echo $siteData->globalDatas['view::_shop/_table/catalog/menu/list/shopoperation'];?>
    <?php if ((Func::isShopMenu('shop/edit', $siteData))){ ?>
        <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shop/edit'){echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shop/edit?is_edit=1&id=<?php echo $siteData->shopID; ?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-red"></i>
                <span>Информация о компании</span>
            </a>
        </li>
    <?php } ?>
    <?php if ((Func::isShopMenu('shopaddress/editmain', $siteData))){ ?>
        <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shopaddress/editmain'){echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopaddress/editmain?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-aqua"></i>
                <span>Основной адрес</span>
            </a>
        </li>
    <?php } ?>
    <?php if ((Func::isShopMenu('shopaddress/index', $siteData))){ ?>
        <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shopaddress/index'){echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopaddress/index?is_public_ignore=1&<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-aqua"></i>
                <span>Дополнительные адреса</span>
            </a>
        </li>
    <?php } ?>
    <?php if ((Func::isShopMenu('shopaddresscontact/index', $siteData))){ ?>
        <li <?php if((Func::isCurrentMenu($siteData,'shopaddresscontact'))){}else{echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopaddresscontact/index?is_public_ignore=1&<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-aqua"></i>
                <span>Контакты</span>
            </a>
        </li>
    <?php } ?>
    <?php if ((Func::isShopMenu('shopaddresscontactrubric/index', $siteData))){ ?>
        <li <?php if((Func::isCurrentMenu($siteData,'shopaddresscontactrubric'))){}else{echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopaddresscontactrubric/index?is_public_ignore=1&<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-aqua"></i>
                <span>Рубрики контактов</span>
            </a>
        </li>
    <?php } ?>
    <?php if ((Func::isShopMenu('shopdeliverytype/index', $siteData))){ ?>
        <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shopdeliverytype/index'){echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopdeliverytype/index?is_public_ignore=1&<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-yellow"></i>
                <span>Доставка</span>
            </a>
        </li>
    <?php } ?>
    <?php if ((Func::isShopMenu('shoppaidtype/index', $siteData))){ ?>
        <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shoppaidtype/index'){echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoppaidtype/index?is_public_ignore=1&<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-aqua"></i>
                <span>Оплата</span>
            </a>
        </li>
    <?php } ?>

<?php }elseif(($siteData->controllerName =='siteoptions')
    || ($siteData->controllerName =='shopemail')
    || ($siteData->controllerName =='shopredirect')){ ?>

    <?php if ((Func::isShopMenu('siteoptions/heads', $siteData))){ ?>
        <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/siteoptions/head'){echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/siteoptions/head?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-red"></i>
                <span>SEO-настройки</span>
            </a>
        </li>
    <?php } ?>
    <?php if ((Func::isShopMenu('shopemail/index', $siteData))){ ?>
        <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shopemail/index'){echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopemail/index?is_public_ignore=1&<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-yellow"></i>
                <span>Шаблоны e-mail сообщений</span>
            </a>
        </li>
    <?php } ?>
    <?php if ((Func::isShopMenu('shopredirect/index', $siteData))){ ?>
        <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shopredirect/index'){echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopredirect/index?is_public_ignore=1&<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-yellow"></i>
                <span>Настройка редиректа</span>
            </a>
        </li>
    <?php } ?>

<?php }?>

<?php
if(strpos($siteData->url, '/site/') > -1) {
    $view = View::factory('cabinet/35/main/site/menu');
    $view->siteData = $siteData;
    $view->data = $data;
    echo Helpers_View::viewToStr($view);
}
?>