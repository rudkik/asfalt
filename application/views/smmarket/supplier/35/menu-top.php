<div class="menu-top">
    <nav class="navbar navbar-default navbar-static" role="navigation" id="menu-top">
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
                <?php if ((Func::isShopMenu('shopbranch/group', $data->values, $siteData))){ ?>
                    <li class="dropdown">
                        <a id="drop0" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Филиалы <b class="caret"></b></a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="drop0">
                            <?php if ((Func::isShopMenu('shopbranchtype/index', $data->values, $siteData))){ ?>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopbranchtype/index?<?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                        Виды филиалов
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ((Func::isShopMenu('shopbranchcatalog/index-all', $data->values, $siteData))){ ?>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopbranchcatalog/index-all?<?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                        Рубрики филиалов
                                    </a>
                                </li>
                            <?php } ?>
                            <?php echo trim($siteData->globalDatas['view::shopbranchtypes/menu-top']); ?>
                        </ul>
                    </li>
                <?php } ?>

                <?php if ((Func::isShopMenu('shopgood/group', $data->values, $siteData))){ ?>
                    <li class="dropdown">
                        <a id="drop1" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Товары и услуги <b class="caret"></b></a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="drop1">
                            <?php if ((Func::isShopMenu('shopgoodtype/index', $data->values, $siteData))){ ?>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopgoodtype/index?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                        Вид товаров и услуг
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if ((Func::isShopMenu('shopgoodcatalog/index-all', $data->values, $siteData))
                                || (Func::isShopMenu('shopattribute/index-all', $data->values, $siteData))
                                || (Func::isShopMenu('shopattributecatalog/index-all', $data->values, $siteData))
                                || (Func::isShopMenu('shopattributegroup/index-all', $data->values, $siteData))){ ?>
                                <?php if ((Func::isShopMenu('shopgoodtype/index', $data->values, $siteData))){ ?>
                                    <li class="divider" role="presentation"></li>
                                <?php } ?>

                                <?php if ((Func::isShopMenu('shopgoodcatalog/index-all', array(), $siteData))){ ?>
                                    <li role="presentation">
                                        <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopgoodcatalog/index?type=0<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                            Рубрики
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if ((Func::isShopMenu('shopattribute/index-all', array(), $siteData))){ ?>
                                    <li role="presentation">
                                        <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopattribute/index?type=0<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                            Атрибуты
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if ((Func::isShopMenu('shopattributecatalog/index-all', array(), $siteData))){ ?>
                                    <li role="presentation">
                                        <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopattributecatalog/index?type=0<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                            Рубрики атрибутов
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if ((Func::isShopMenu('shopattributegroup/index-all', array(), $siteData))){ ?>
                                    <li role="presentation">
                                        <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopattributegroup/index?type=0<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                            Группы атрибутов
                                        </a>
                                    </li>
                                <?php } ?>

                                <li class="divider" role="presentation"></li>
                            <?php } ?>

                            <?php echo trim($siteData->globalDatas['view::shopgoodtypes/menu-top']); ?>

                            <li class="divider" role="presentation"></li>
                            <?php if ((Func::isShopMenu('shopaction/index', $data->values, $siteData))){ ?>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopaction/index?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                        Акции
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ((Func::isShopMenu('shopdiscount/index', $data->values, $siteData))){ ?>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopdiscount/index?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                        Скидки
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ((Func::isShopMenu('shopcoupon/index', $data->values, $siteData))){ ?>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopcoupon/index?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                        Купоны
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>

                <?php if ((Func::isShopMenu('shopnew/group', $data->values, $siteData))
                    || (Func::isShopMenu('shopgallery/group', $data->values, $siteData))
                    || (Func::isShopMenu('shopfile/group', $data->values, $siteData))){ ?>
                    <li class="dropdown">
                        <a id="drop2" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Статьи и новости <b class="caret"></b></a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="drop2">

                            <?php if (Func::isShopMenu('shopnew/group', $data->values, $siteData)){ ?>
                                <?php if ((Func::isShopMenu('shopnewcatalog/index', $data->values, $siteData))){ ?>
                                    <li role="presentation">
                                        <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopnewcatalog/index?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                            Вид статей и новостей
                                        </a>
                                    </li>
                                <?php } ?>

                                <?php if (Func::isShopMenu('shopnewrubric/index-all', $data->values, $siteData)){ ?>
                                    <?php if ((Func::isShopMenu('shopnewcatalog/index', $data->values, $siteData))){ ?>
                                        <li class="divider" role="presentation"></li>
                                    <?php } ?>

                                    <?php if ((Func::isShopMenu('shopnewrubric/index-all', array(), $siteData))){ ?>
                                        <li role="presentation">
                                            <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopnewrubric/index?type=0<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                                Рубрики статей / новостей
                                            </a>
                                        </li>
                                    <?php } ?>
                                <?php } ?>

                                <?php if (Func::isShopMenu('shopnewhashtag/index-all', $data->values, $siteData)){ ?>
                                    <?php if ((Func::isShopMenu('shopnewcatalog/index', $data->values, $siteData))
                                    || (Func::isShopMenu('shopnewrubric/index-all', $data->values, $siteData))){ ?>
                                        <li class="divider" role="presentation"></li>
                                    <?php } ?>

                                    <?php if ((Func::isShopMenu('shopnewhashtag/index-all', array(), $siteData))){ ?>
                                        <li role="presentation">
                                            <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopnewhashtag/index?type=0<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                                Хэштеги статей / новостей
                                            </a>
                                        </li>
                                    <?php } ?>
                                <?php } ?>

                                <?php echo trim($siteData->globalDatas['view::shopnewcatalogs/menu-top']); ?>
                            <?php } ?>

                            <?php if (Func::isShopMenu('shopfile/group', $data->values, $siteData)){ ?>

                                <?php if ((Func::isShopMenu('shopnew/group', $data->values, $siteData))){ ?>
                                    <li class="divider" role="presentation"></li>
                                <?php } ?>

                                <?php if ((Func::isShopMenu('shopfilecatalog/index', $data->values, $siteData))){ ?>
                                    <li role="presentation">
                                        <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopfilecatalog/index?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                            Вид документов
                                        </a>
                                    </li>
                                <?php } ?>

                                <?php if (Func::isShopMenu('shopfilerubric/index-all', $data->values, $siteData)){ ?>
                                    <?php if ((Func::isShopMenu('shopfilecatalog/index', $data->values, $siteData))){ ?>
                                        <li class="divider" role="presentation"></li>
                                    <?php } ?>

                                    <?php if ((Func::isShopMenu('shopfilerubric/index-all', array(), $siteData))){ ?>
                                        <li role="presentation">
                                            <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopfilerubric/index?type=0<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                                Рубрики документов
                                            </a>
                                        </li>
                                    <?php } ?>
                                <?php } ?>

                                <?php echo trim($siteData->globalDatas['view::shopfilecatalogs/menu-top']); ?>
                            <?php } ?>

                            <?php if (Func::isShopMenu('shopgallery/group', $data->values, $siteData)){ ?>

                                <?php if ((Func::isShopMenu('shopnew/group', $data->values, $siteData))
                                    || (Func::isShopMenu('shopfile/group', $data->values, $siteData))){ ?>
                                    <li class="divider" role="presentation"></li>
                                <?php } ?>

                                <?php if ((Func::isShopMenu('shopgallerycatalog/index', $data->values, $siteData))){ ?>
                                    <li role="presentation">
                                        <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopgallerycatalog/index?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                            Вид галерей
                                        </a>
                                    </li>
                                <?php } ?>

                                <?php if (Func::isShopMenu('shopgalleryrubric/index-all', $data->values, $siteData)){ ?>
                                    <?php if ((Func::isShopMenu('shopgallerycatalog/index', $data->values, $siteData))){ ?>
                                        <li class="divider" role="presentation"></li>
                                    <?php } ?>

                                    <?php if ((Func::isShopMenu('shopgalleryrubric/index-all', array(), $siteData))){ ?>
                                        <li role="presentation">
                                            <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopgalleryrubric/index?type=0<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                                Рубрики галерей
                                            </a>
                                        </li>
                                    <?php } ?>
                                <?php } ?>

                                <?php echo trim($siteData->globalDatas['view::shopgallerycatalogs/menu-top']); ?>
                            <?php } ?>

                            <?php if ((Func::isShopMenu('shopnew/group', $data->values, $siteData))
                                || (Func::isShopMenu('shopfile/group', $data->values, $siteData))
                                || (Func::isShopMenu('shopgallery/group', $data->values, $siteData))){ ?>
                                <li class="divider" role="presentation"></li>
                            <?php } ?>

                            <?php if ((Func::isShopMenu('shopinformationdata/index', $data->values, $siteData))){ ?>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopinformationdata/index?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                        Статичные блоки
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>

                <?php if ((Func::isShopMenu('shopsubscribe/group', $data->values, $siteData))
                    || (Func::isShopMenu('shopcomment/group', $data->values, $siteData))
                    || (Func::isShopMenu('shopmessage/group', $data->values, $siteData))
                    || (Func::isShopMenu('shopquestion/group', $data->values, $siteData))
                    || (Func::isShopMenu('shopclientphone/group', $data->values, $siteData))){ ?>
                    <li class="dropdown">
                        <a id="drop3" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">От пользователей <b class="caret"></b></a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="drop3">

                            <?php if (Func::isShopMenu('shopcomment/group', $data->values, $siteData)){ ?>
                                <?php if ((Func::isShopMenu('shopcommentcatalog/index', $data->values, $siteData))){ ?>
                                    <li role="presentation">
                                        <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopcommentcatalog/index?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                            Виды комментариев
                                        </a>
                                    </li>
                                <?php } ?>

                                <?php if (Func::isShopMenu('shopcommentrubric/index-all', $data->values, $siteData)){ ?>
                                    <?php if ((Func::isShopMenu('shopcommentcatalog/index', $data->values, $siteData))){ ?>
                                        <li class="divider" role="presentation"></li>
                                    <?php } ?>

                                    <?php if ((Func::isShopMenu('shopcommentrubric/index-all', array(), $siteData))){ ?>
                                        <li role="presentation">
                                            <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopcommentrubric/index?type=0<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                                Рубрики комментариев
                                            </a>
                                        </li>
                                    <?php } ?>
                                <?php } ?>

                                <?php echo trim($siteData->globalDatas['view::shopcommentcatalogs/menu-top']); ?>
                            <?php } ?>

                            <?php if (Func::isShopMenu('shopquestion/group', $data->values, $siteData)){ ?>

                                <?php if ((Func::isShopMenu('shopcomment/group', $data->values, $siteData))){ ?>
                                    <li class="divider" role="presentation"></li>
                                <?php } ?>

                                <?php if ((Func::isShopMenu('shopquestioncatalog/index', $data->values, $siteData))){ ?>
                                    <li role="presentation">
                                        <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopquestioncatalog/index?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                            Вид вопросов / ответов
                                        </a>
                                    </li>
                                <?php } ?>

                                <?php if (Func::isShopMenu('shopquestionrubric/index-all', $data->values, $siteData)){ ?>
                                    <?php if ((Func::isShopMenu('shopquestioncatalog/index', $data->values, $siteData))){ ?>
                                        <li class="divider" role="presentation"></li>
                                    <?php } ?>

                                    <?php if ((Func::isShopMenu('shopquestionrubric/index-all', array(), $siteData))){ ?>
                                        <li role="presentation">
                                            <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopquestionrubric/index?type=0<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                                Рубрики вопросов / ответов
                                            </a>
                                        </li>
                                    <?php } ?>
                                <?php } ?>

                                <?php echo trim($siteData->globalDatas['view::shopquestioncatalogs/menu-top']); ?>
                            <?php } ?>

                            <?php if (Func::isShopMenu('shopmessage/group', $data->values, $siteData)){ ?>
                                <?php if ((Func::isShopMenu('shopcomment/group', $data->values, $siteData))
                                    || (Func::isShopMenu('shopquestion/group', $data->values, $siteData))){ ?>
                                    <li class="divider" role="presentation"></li>
                                <?php } ?>

                                <?php if ((Func::isShopMenu('shopmessagecatalog/index', $data->values, $siteData))){ ?>
                                    <li role="presentation">
                                        <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopmessagecatalog/index?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                            Виды сообщений
                                        </a>
                                    </li>
                                <?php } ?>

                                <?php echo trim($siteData->globalDatas['view::shopmessagecatalogs/menu-top']); ?>
                            <?php } ?>

                            <?php if ((Func::isShopMenu('shopsubscribe/group', $data->values, $siteData))){ ?>

                                <?php if ((Func::isShopMenu('shopcomment/group', $data->values, $siteData))
                                    || (Func::isShopMenu('shopquestion/group', $data->values, $siteData))
                                    || (Func::isShopMenu('shopmessage/group', $data->values, $siteData))){ ?>
                                    <li class="divider" role="presentation"></li>
                                <?php } ?>

                                <?php if ((Func::isShopMenu('shopsubscribecatalog/index', $data->values, $siteData))){ ?>
                                    <li role="presentation">
                                        <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopsubscribecatalog/index?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                            Вид рассылок
                                        </a>
                                    </li>
                                <?php } ?>

                                <?php echo trim($siteData->globalDatas['view::shopsubscribecatalogs/menu-top']); ?>
                            <?php } ?>

                            <?php if ((Func::isShopMenu('shopclientphone/group', $data->values, $siteData))){ ?>

                                <?php if ((Func::isShopMenu('shopcomment/group', $data->values, $siteData))
                                    || (Func::isShopMenu('shopquestion/group', $data->values, $siteData))
                                    || (Func::isShopMenu('shopmessage/group', $data->values, $siteData))
                                    || (Func::isShopMenu('shopsubscribe/group', $data->values, $siteData))){ ?>
                                    <li class="divider" role="presentation"></li>
                                <?php } ?>

                                <?php if ((Func::isShopMenu('shopclientphonecatalog/index', $data->values, $siteData))){ ?>
                                    <li role="presentation">
                                        <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopclientphonecatalog/index?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                            Вид телефонов
                                        </a>
                                    </li>
                                <?php } ?>

                                <?php echo trim($siteData->globalDatas['view::shopclientphonecatalogs/menu-top']); ?>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>

                <?php if ((Func::isShopMenu('shopbill/group', $data->values, $siteData))){ ?>
                    <li class="dropdown">
                        <a id="drop3" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Заказы <b class="caret"></b></a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="drop3">

                            <?php if (Func::isShopMenu('shopbill/group', $data->values, $siteData)){ ?>
                                <?php if ((Func::isShopMenu('shopbill/index', $data->values, $siteData))){ ?>
                                    <li role="presentation">
                                        <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopbill/index?is_branch=0<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                            Заказы
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if ((Func::isShopMenu('shopbill/index-branch', $data->values, $siteData))){ ?>
                                    <li role="presentation">
                                        <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopbill/index?is_branch=1<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                            Заказы
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if ((Func::isShopMenu('shopreport/index', $data->values, $siteData))){ ?>
                                    <li role="presentation">
                                        <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopreport/index?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                            Статистика заказов
                                        </a>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>

                <?php if (Func::isShopMenu('shopinformation/group', $data->values, $siteData)){ ?>
                    <li class="dropdown">
                        <a id="drop3" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Информация о компании <b class="caret"></b></a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="drop3">
                            <?php if ((Func::isShopMenu('shop/edit', $data->values, $siteData))){ ?>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shop/edit?is_edit=1&id=<?php echo $siteData->shopID; ?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                        Информация о компании
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ((Func::isShopMenu('shopaddress/editmain', $data->values, $siteData))){ ?>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopaddress/editmain?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                        Адрес компании
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ((Func::isShopMenu('shopaddresscontact/index', $data->values, $siteData))){ ?>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopaddresscontact/index?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                        Контакты компании
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ((Func::isShopMenu('shopaddress/index', $data->values, $siteData))){ ?>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopaddress/index?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                        Адреса филиалов
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ((Func::isShopMenu('shopdeliverytype/index', $data->values, $siteData))){ ?>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopdeliverytype/index?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                        Доставка
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ((Func::isShopMenu('shoppaidtype/index', $data->values, $siteData))){ ?>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoppaidtype/index?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                        Оплата
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ((Func::isShopMenu('shopoperation/index', $data->values, $siteData))){ ?>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopoperation/index?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                        Сотрудники
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>

                <?php if (Func::isShopMenu('siteoptions/heads', $data->values, $siteData)
                    || Func::isShopMenu('shopemail/index', array(), $siteData)){ ?>
                    <li class="dropdown">
                        <a id="drop4" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Настройки сайта <b class="caret"></b></a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="drop4">
                            <?php if ((Func::isShopMenu('siteoptions/heads', $data->values, $siteData))){ ?>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/siteoptions/heads?is_edit=1&id=<?php echo $siteData->shopID; ?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                        SEO-настройки
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ((Func::isShopMenu('shopemail/index', $data->values, $siteData))){ ?>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopemail/index?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>">
                                        Шаблоны e-mail сообщений
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