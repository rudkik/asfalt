<?php

switch ($siteData->url) {
    case '/'.$siteData->actionURLName.'/shopbranchtype/index':
    case '/'.$siteData->actionURLName.'/shopbranchtype/edit':
    case '/'.$siteData->actionURLName.'/shopbranchtype/new':
    case '/'.$siteData->actionURLName.'/shopbranchcatalog/index':
    case '/'.$siteData->actionURLName.'/shopbranch/index':
    case '/'.$siteData->actionURLName.'/shopbranch/edit':
    case '/'.$siteData->actionURLName.'/shopbranch/new':?>

    <?php if ((Func::isShopMenu('shopbranchtype/index', $data->values, $siteData))){ ?>
        <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shopbranchtype/index'){echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopbranchtype/index?<?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-red"></i>
                <span>Виды филиалов</span>
            </a>
        </li>
    <?php } ?>
    <?php if ((Func::isShopMenu('shopbranchcatalog/index-all', $data->values, $siteData))){ ?>
        <li <?php if(($siteData->url == '/'.$siteData->actionURLName.'/shopbranchcatalog/index-all') && (Request_RequestParams::getParamInt('type') == 0)){}else{echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopbranchcatalog/index?type=0<?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-red"></i>
                <span>Рубрики филиалов</span>
            </a>
        </li>
    <?php } ?>

    <?php echo trim($siteData->globalDatas['view::shopbranchtypes/menu']); ?>
<?php
        break;
    case '/'.$siteData->actionURLName.'/shopgoodtype/index':
    case '/'.$siteData->actionURLName.'/shopgoodcatalog/index':
    case '/'.$siteData->actionURLName.'/shopattribute/index':
    case '/'.$siteData->actionURLName.'/shopattributecatalog/index':
    case '/'.$siteData->actionURLName.'/shopattributegroup/index':
    case '/'.$siteData->actionURLName.'/shopgood/index':
    case '/'.$siteData->actionURLName.'/shopgood/new':
    case '/'.$siteData->actionURLName.'/shopgood/edit':
    case '/'.$siteData->actionURLName.'/shopaction/index':
    case '/'.$siteData->actionURLName.'/shopdiscount/index':
    case '/'.$siteData->actionURLName.'/shopcoupon/index':?>

    <?php if ((Func::isShopMenu('shopgoodtype/index', $data->values, $siteData))){ ?>
        <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shopgoodtype/index'){echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopgoodtype/index?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-red"></i>
                <span>Вид товаров и услуг</span>
            </a>
        </li>
    <?php } ?>
    <?php if ((Func::isShopMenu('shopgoodcatalog/index-all', array(), $siteData))){ ?>
        <li <?php if(($siteData->url == '/'.$siteData->actionURLName.'/shopgoodcatalog/index') && (Request_RequestParams::getParamInt('type') == 0)){}else{echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopgoodcatalog/index?type=0<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-yellow"></i>
                <span>Рубрики</span>
            </a>
        </li>
    <?php } ?>
    <?php if ((Func::isShopMenu('shopattribute/index-all', array(), $siteData))){ ?>
        <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shopattribute/index'){echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopattribute/index?type=0<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-aqua"></i>
                <span>Атрибуты</span>
            </a>
        </li>
    <?php } ?>
    <?php if ((Func::isShopMenu('shopattributecatalog/index-all', array(), $siteData))){ ?>
        <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shopattributecatalog/index'){echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopattributecatalog/index?type=0<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-blue"></i>
                <span>Рубрики атрибутов</span>
            </a>
        </li>
    <?php } ?>
    <?php if ((Func::isShopMenu('shopattributegroup/index-all', array(), $siteData))){ ?>
        <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shopattributegroup/index'){echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopattributegroup/index?type=0<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-black"></i>
                <span>Группы атрибутов</span>
            </a>
        </li>
    <?php } ?>

    <?php echo trim($siteData->globalDatas['view::shopgoodtypes/menu']); ?>

    <?php if ((Func::isShopMenu('shopaction/index', $data->values, $siteData))){ ?>
        <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shopaction/index'){echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopaction/index?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-lime"></i>
                <span>Акции</span>
            </a>
        </li>
    <?php } ?>
    <?php if ((Func::isShopMenu('shopdiscount/index', $data->values, $siteData))){ ?>
        <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shopdiscount/index'){echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopdiscount/index?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-orange"></i>
                <span>Скидки</span>
            </a>
        </li>
    <?php } ?>
    <?php if ((Func::isShopMenu('shopcoupon/index', $data->values, $siteData))){ ?>
        <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shopcoupon/index'){echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopcoupon/index?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-fuchsia"></i>
                <span>Купоны</span>
            </a>
        </li>
    <?php } ?>
<?php
        break;
    case '/'.$siteData->actionURLName.'/shopnewcatalog/index':
    case '/'.$siteData->actionURLName.'/shopnewcatalog/edit':
    case '/'.$siteData->actionURLName.'/shopnewcatalog/new':
    case '/'.$siteData->actionURLName.'/shopnewrubric/index':
    case '/'.$siteData->actionURLName.'/shopnewrubric/edit':
    case '/'.$siteData->actionURLName.'/shopnewrubric/new':
    case '/'.$siteData->actionURLName.'/shopnewhashtag/index':
    case '/'.$siteData->actionURLName.'/shopnewhashtag/edit':
    case '/'.$siteData->actionURLName.'/shopnewhashtag/new':
    case '/'.$siteData->actionURLName.'/shopnew/index':
    case '/'.$siteData->actionURLName.'/shopnew/edit':
    case '/'.$siteData->actionURLName.'/shopnew/new':
    case '/'.$siteData->actionURLName.'/shopfilecatalog/index':
    case '/'.$siteData->actionURLName.'/shopfilerubric/index':
    case '/'.$siteData->actionURLName.'/shopfile/index':
    case '/'.$siteData->actionURLName.'/shopgallerycatalog/index':
    case '/'.$siteData->actionURLName.'/shopgalleryrubric/index':
    case '/'.$siteData->actionURLName.'/shopgallery/index':
    case '/'.$siteData->actionURLName.'/shopgallery/edit':
    case '/'.$siteData->actionURLName.'/shopgallery/new':
    case '/'.$siteData->actionURLName.'/shopinformationdata/index':
    case '/'.$siteData->actionURLName.'/shopinformationdata/edit':
    case '/'.$siteData->actionURLName.'/shopinformationdata/new':?>

    <?php if ((Func::isShopMenu('shopnewcatalog/index', $data->values, $siteData))){ ?>
        <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shopnewcatalog/index'){echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopnewcatalog/index?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-red"></i>
                <span>Вид статей и новостей</span>
            </a>
        </li>
    <?php } ?>
    <?php if ((Func::isShopMenu('shopnewrubric/index-all', array(), $siteData))){ ?>
        <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shopnewrubric/index'){echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopnewrubric/index?type=0<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-yellow"></i>
                <span>Рубрики статей / новостей</span>
            </a>
        </li>
    <?php } ?>
    <?php if ((Func::isShopMenu('shopnewhashtag/index-all', array(), $siteData))){ ?>
        <li <?php if((Func::isCurrentMenu($siteData,'shopnewhashtag')) && (Request_RequestParams::getParamInt('type') == 0)){}else{echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopnewhashtag/index?type=0<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-yellow"></i>
                <span>Хэштеги статей / новостей</span>
            </a>
        </li>
    <?php } ?>
    <?php if ((Func::isShopMenu('shopnewselecttype/index-all', array(), $siteData))){ ?>
        <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shopnewselecttype/index'){echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopnewselecttype/index?type=0<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-yellow"></i>
                <span>Вид выделения статей / новостей</span>
            </a>
        </li>
    <?php } ?>

    <?php echo trim($siteData->globalDatas['view::shopnewcatalogs/menu']); ?>

    <?php if ((Func::isShopMenu('shopfilecatalog/index', $data->values, $siteData))){ ?>
        <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shopfilecatalog/index'){echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopfilecatalog/index?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-black"></i>
                <span>Виды документов</span>
            </a>
        </li>
    <?php } ?>
    <?php if ((Func::isShopMenu('shopfilerubric/index-all', array(), $siteData))){ ?>
        <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shopfilerubric/index'){echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopfilerubric/index?type=0<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-light-blue"></i>
                <span>Рубрики документов</span>
            </a>
        </li>
    <?php } ?>

    <?php echo trim($siteData->globalDatas['view::shopfilecatalogs/menu']); ?>

    <?php if ((Func::isShopMenu('shopgallerycatalog/index', $data->values, $siteData))){ ?>
        <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shopgallerycatalog/index'){echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopgallerycatalog/index?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-navy"></i>
                <span>Виды галерей</span>
            </a>
        </li>
    <?php } ?>
    <?php if ((Func::isShopMenu('shopgalleryrubric/index-all', array(), $siteData))){ ?>
        <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shopgalleryrubric/index'){echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopgalleryrubric/index?type=0<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-teal"></i>
                <span>Рубрики галерей</span>
            </a>
        </li>
    <?php } ?>

    <?php echo trim($siteData->globalDatas['view::shopgallerycatalogs/menu']); ?>

    <?php if ((Func::isShopMenu('shopinformationdata/index', $data->values, $siteData))){ ?>
        <li <?php if((Func::isCurrentMenu($siteData,'shopinformationdata'))){}else{echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopinformationdata/index?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-orange"></i>
                <span>Статичные блоки</span>
            </a>
        </li>
    <?php } ?>

<?php
        break;
    case '/'.$siteData->actionURLName.'/shopbill/index':
    case '/'.$siteData->actionURLName.'/shopbill/index-branch':
    case '/'.$siteData->actionURLName.'/shopreport/index':
    case '/'.$siteData->actionURLName.'/shopcommentcatalog/index':
    case '/'.$siteData->actionURLName.'/shopcommentrubric/index':
    case '/'.$siteData->actionURLName.'/shopcomment/index':
    case '/'.$siteData->actionURLName.'/shopquestioncatalog/index':
    case '/'.$siteData->actionURLName.'/shopquestionrubric/index':
    case '/'.$siteData->actionURLName.'/shopquestion/index':
    case '/'.$siteData->actionURLName.'/shopmessagecatalog/index':
    case '/'.$siteData->actionURLName.'/shopmessage/index':
    case '/'.$siteData->actionURLName.'/shopmessage/new':
    case '/'.$siteData->actionURLName.'/shopmessage/edit':?>

    <?php if ((Func::isShopMenu('shopbill/index', $data->values, $siteData))){ ?>
        <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shopbill/index'){echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopbill/index?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-red"></i>
                <span>Заказы</span>
            </a>
        </li>
    <?php } ?>
    <?php if ((Func::isShopMenu('shopbill/index-branch', $data->values, $siteData))){ ?>
        <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shopbill/index-branch'){echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopbill/index-branch?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-yellow"></i>
                <span>Заказы филиалов</span>
            </a>
        </li>
    <?php } ?>
    <?php if ((Func::isShopMenu('shopmessagecatalog/index', $data->values, $siteData))){ ?>
        <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shopmessagecatalog/index'){echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopmessagecatalog/index?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-blue"></i>
                <span>Виды сообщений</span>
            </a>
        </li>
    <?php } ?>

    <?php echo trim($siteData->globalDatas['view::shopmessagecatalogs/menu']); ?>

    <?php if ((Func::isShopMenu('shopreport/index', $data->values, $siteData))){ ?>
        <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shopreport/index'){echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopreport/index?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-aqua"></i>
                <span>Статистика заказов</span>
            </a>
        </li>
    <?php } ?>
    <?php if ((Func::isShopMenu('shopcommentcatalog/index', $data->values, $siteData))){ ?>
        <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shopcommentcatalog/index'){echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopcommentcatalog/index?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-blue"></i>
                <span>Виды комментарии</span>
            </a>
        </li>
    <?php } ?>
    <?php if ((Func::isShopMenu('shopcommentrubric/index-all', array(), $siteData))){ ?>
        <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shopcommentrubric/index'){echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopcommentrubric/index?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-black"></i>
                <span>Рубрики комментариев</span>
            </a>
        </li>
    <?php } ?>

    <?php echo trim($siteData->globalDatas['view::shopcommentcatalogs/menu']); ?>

    <?php if ((Func::isShopMenu('shopquestioncatalog/index', $data->values, $siteData))){ ?>
        <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shopquestioncatalog/index'){echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopquestioncatalog/index?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-gray"></i>
                <span>Виды вопросов / ответов</span>
            </a>
        </li>
    <?php } ?>
    <?php if ((Func::isShopMenu('shopquestionrubric/index-all', array(), $siteData))){ ?>
        <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shopquestionrubric/index'){echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopquestionrubric/index?type=0<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-navy"></i>
                <span>Рубрики вопросов / ответов</span>
            </a>
        </li>
    <?php } ?>

    <?php echo trim($siteData->globalDatas['view::shopquestioncatalogs/menu']); ?>

<?php
        break;
    case '/'.$siteData->actionURLName.'/shop/edit':
    case '/'.$siteData->actionURLName.'/shopdeliverytype/index':
    case '/'.$siteData->actionURLName.'/shoppaidtype/index':
    case '/'.$siteData->actionURLName.'/shopoperation/index':
    case '/'.$siteData->actionURLName.'/shopoperation/edit':
    case '/'.$siteData->actionURLName.'/shopoperation/new':
    case '/'.$siteData->actionURLName.'/shopaddress/editmain':
    case '/'.$siteData->actionURLName.'/shopaddresscontact/index':
    case '/'.$siteData->actionURLName.'/shopaddresscontact/edit':
    case '/'.$siteData->actionURLName.'/shopaddresscontact/new':
    case '/'.$siteData->actionURLName.'/shopaddress/index':?>

    <?php if ((Func::isShopMenu('shop/edit', $data->values, $siteData))){ ?>
        <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shop/edit'){echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shop/edit?is_edit=1&id=<?php echo $siteData->shopID; ?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-red"></i>
                <span>Информация о компании</span>
            </a>
        </li>
    <?php } ?>
    <?php if ((Func::isShopMenu('shopdeliverytype/index', $data->values, $siteData))){ ?>
        <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shopdeliverytype/index'){echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopdeliverytype/index?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-yellow"></i>
                <span>Доставка</span>
            </a>
        </li>
    <?php } ?>
    <?php if ((Func::isShopMenu('shoppaidtype/index', $data->values, $siteData))){ ?>
        <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shoppaidtype/index'){echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoppaidtype/index?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-aqua"></i>
                <span>Оплата</span>
            </a>
        </li>
    <?php } ?>
    <?php if ((Func::isShopMenu('shopoperation/index', $data->values, $siteData))){ ?>
        <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shopoperation/index'){echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopoperation/index?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-aqua"></i>
                <span>Сотрудники</span>
            </a>
        </li>
    <?php } ?>
    <?php if ((Func::isShopMenu('shopaddress/editmain', $data->values, $siteData))){ ?>
        <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shopaddress/editmain'){echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopaddress/editmain?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-aqua"></i>
                <span>Адрес компании</span>
            </a>
        </li>
    <?php } ?>
    <?php if ((Func::isShopMenu('shopaddresscontact/index', $data->values, $siteData))){ ?>
        <li <?php if((Func::isCurrentMenu($siteData,'shopaddresscontact'))){}else{echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopaddresscontact/index?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-aqua"></i>
                <span>Контакты компании</span>
            </a>
        </li>
    <?php } ?>
    <?php if ((Func::isShopMenu('shopaddress/index', $data->values, $siteData))){ ?>
        <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shopaddress/index'){echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopaddress/index?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-aqua"></i>
                <span>Филиалы</span>
            </a>
        </li>
    <?php } ?>

<?php
        break;
    case '/'.$siteData->actionURLName.'/shopoptions/group':?>

    <?php if ((Func::isShopMenu('siteoptions/heads', $data->values, $siteData))){ ?>
        <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/siteoptions/heads'){echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/siteoptions/heads?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-red"></i>
                <span>SEO-настройки</span>
            </a>
        </li>
    <?php } ?>
    <?php if ((Func::isShopMenu('shopemail/index', $data->values, $siteData))){ ?>
        <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shopemail/index'){echo 'class="menu-left"';} ?>>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopemail/index?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-yellow"></i>
                <span>Шаблоны e-mail сообщений</span>
            </a>
        </li>
    <?php } ?>

<?php
        break;
    case '/'.$siteData->actionURLName.'/shopsubscribecatalog/index':
    case '/'.$siteData->actionURLName.'/shopsubscribecatalog/new':
    case '/'.$siteData->actionURLName.'/shopsubscribecatalog/edit':
    case '/'.$siteData->actionURLName.'/shopsubscribe/index':
    case '/'.$siteData->actionURLName.'/shopsubscribe/new':
    case '/'.$siteData->actionURLName.'/shopsubscribe/edit':?>

        <?php if ((Func::isShopMenu('shopsubscribecatalog/index', $data->values, $siteData))){ ?>
            <li <?php if($siteData->url != '/'.$siteData->actionURLName.'/shopsubscribecatalog/index'){echo 'class="menu-left"';} ?>>
                <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopsubscribecatalog/index?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>"><i class="fa fa-circle-o text-blue"></i>
                    <span>Виды рассылок</span>
                </a>
            </li>
        <?php } ?>

    <?php echo trim($siteData->globalDatas['view::shopsubscribecatalogs/menu']); ?>


<?php
        break;
}?>