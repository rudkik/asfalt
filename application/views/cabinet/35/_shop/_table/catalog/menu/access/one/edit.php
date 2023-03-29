<div class="row">
    <?php if(!empty($siteData->replaceDatas['view::_shop/_table/catalog/menu/access/list/shopnew'])){ ?>
    <?php $name = 'shopnew'; ?>
    <div class="col-md-4">
        <div class="box box-info">
            <div class="box-header" style="padding-bottom: 0px;">
                <label style="font-weight: 400;">
                    <input data-id="group" name="shop_menu[<?php echo $name; ?>/group]" class="minimal"  <?php if(Func::isShopMenu($name.'/group', $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">
                    <h3 class="box-title"><b>Статьи / новости</b></h3>
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
            </div>
            <div class="box-body record-input" style="padding-top: 0px;">
                <?php echo trim($siteData->globalDatas['view::_shop/_table/catalog/menu/access/list/shopnew']); ?>
            </div>
            <div class="box-footer clearfix"></div>
        </div>
    </div>
    <?php } ?>
    <?php if(!empty($siteData->replaceDatas['view::_shop/_table/catalog/menu/access/list/shopcar'])){ ?>
        <?php $name = 'shopcar'; ?>
        <div class="col-md-4">
            <div class="box box-info">
                <div class="box-header" style="padding-bottom: 0px;">
                    <label style="font-weight: 400;">
                        <input data-id="group" name="shop_menu[<?php echo $name; ?>/group]" class="minimal"  <?php if(Func::isShopMenu($name.'/group', $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">
                        <h3 class="box-title"><b>Машины</b></h3>
                        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                    </label>
                </div>
                <div class="box-body record-input">
                    <?php echo trim($siteData->globalDatas['view::_shop/_table/catalog/menu/access/list/shopcar']); ?>
                </div>
                <div class="box-footer clearfix"></div>
            </div>
        </div>
    <?php } ?>
    <?php if(!empty($siteData->replaceDatas['view::_shop/_table/catalog/menu/access/list/shopgood'])){ ?>
    <?php $name = 'shopgood'; ?>
    <div class="col-md-4">
        <div class="box box-info">
            <div class="box-header" style="padding-bottom: 0px;">
                <label style="font-weight: 400;">
                    <input data-id="group" name="shop_menu[<?php echo $name; ?>/group]" class="minimal"  <?php if(Func::isShopMenu($name.'/group', $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">
                    <h3 class="box-title"><b>Товары / услуги</b></h3>
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
            </div>
            <div class="box-body record-input">
                <?php echo trim($siteData->globalDatas['view::_shop/_table/catalog/menu/access/list/shopgood']); ?>

                <div class="form-group">
                    <h4 class="text-red">
                        <input name="shop_menu[shopgoodtooperation/index]" class="minimal"  <?php if(Func::isShopMenu('shopgoodtooperation/index', $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Цены операторов
                        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                    </h4>
                </div>
            </div>
            <div class="box-footer clearfix"></div>
        </div>
    </div>
    <?php } ?>
    <?php if(!empty($siteData->replaceDatas['view::_shop/_table/catalog/menu/access/list/shopfile'])){ ?>
        <?php $name = 'shopfile'; ?>
        <div class="col-md-4">
            <div class="box box-info">
                <div class="box-header" style="padding-bottom: 0px;">
                    <label style="font-weight: 400;">
                        <input data-id="group" name="shop_menu[<?php echo $name; ?>/group]" class="minimal"  <?php if(Func::isShopMenu($name.'/group', $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">
                        <h3 class="box-title"><b>Файлы / документы</b></h3>
                        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                    </label>
                </div>
                <div class="box-body record-input">
                    <?php echo trim($siteData->globalDatas['view::_shop/_table/catalog/menu/access/list/shopfile']); ?>
                </div>
                <div class="box-footer clearfix"></div>
            </div>
        </div>
    <?php } ?>
    <?php if(!empty($siteData->replaceDatas['view::_shop/_table/catalog/menu/access/list/shopcalendar'])){ ?>
        <?php $name = 'shopcalendar'; ?>
        <div class="col-md-4">
            <div class="box box-info">
                <div class="box-header" style="padding-bottom: 0px;">
                    <label style="font-weight: 400;">
                        <input data-id="group" name="shop_menu[<?php echo $name; ?>/group]" class="minimal"  <?php if(Func::isShopMenu($name.'/group', $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">
                        <h3 class="box-title"><b>Календари</b></h3>
                        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                    </label>
                </div>
                <div class="box-body record-input">
                    <?php echo trim($siteData->globalDatas['view::_shop/_table/catalog/menu/access/list/shopcalendar']); ?>
                </div>
                <div class="box-footer clearfix"></div>
            </div>
        </div>
    <?php } ?>
    <?php if(!empty($siteData->replaceDatas['view::_shop/_table/catalog/menu/access/list/shopgallery'])){ ?>
    <?php $name = 'shopgallery'; ?>
    <div class="col-md-4">
        <div class="box box-info">
            <div class="box-header" style="padding-bottom: 0px;">
                <label style="font-weight: 400;">
                    <input data-id="group" name="shop_menu[<?php echo $name; ?>/group]" class="minimal"  <?php if(Func::isShopMenu($name.'/group', $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">
                    <h3 class="box-title"><b>Фотогалереи</b></h3>
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
            </div>
            <div class="box-body record-input">
                <?php echo trim($siteData->globalDatas['view::_shop/_table/catalog/menu/access/list/shopgallery']); ?>
            </div>
            <div class="box-footer clearfix"></div>
        </div>
    </div>
    <?php } ?>
    <?php if(!empty($siteData->replaceDatas['view::_shop/_table/catalog/menu/access/list/shopbranch'])){ ?>
    <?php $name = 'shopbranch'; ?>
    <div class="col-md-3">
        <div class="box box-info">
            <div class="box-header" style="padding-bottom: 0px;">
                <label style="font-weight: 400;">
                    <input data-id="group" name="shop_menu[<?php echo $name; ?>/group]" class="minimal"  <?php if(Func::isShopMenu($name.'/group', $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">
                    <h3 class="box-title"><b>Филилалы</b></h3>
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
            </div>
            <div class="box-body record-input">
                <?php echo trim($siteData->globalDatas['view::_shop/_table/catalog/menu/access/list/shopbranch']); ?>
            </div>
            <div class="box-footer clearfix"></div>
        </div>
    </div>
    <?php } ?>
    <?php if(!empty($siteData->replaceDatas['view::_shop/_table/catalog/menu/access/list/shopcomment'])){ ?>
    <?php $name = 'shopcomment'; ?>
    <div class="col-md-4">
        <div class="box box-info">
            <div class="box-header" style="padding-bottom: 0px;">
                <label style="font-weight: 400;">
                    <input data-id="group" name="shop_menu[<?php echo $name; ?>/group]" class="minimal"  <?php if(Func::isShopMenu($name.'/group', $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">
                    <h3 class="box-title"><b>Комментарии</b></h3>
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
            </div>
            <div class="box-body record-input">
                <?php echo trim($siteData->globalDatas['view::_shop/_table/catalog/menu/access/list/shopcomment']); ?>
            </div>
            <div class="box-footer clearfix"></div>
        </div>
    </div>
    <?php } ?>
    <?php if(!empty($siteData->replaceDatas['view::_shop/_table/catalog/menu/access/list/shopquestion'])){ ?>
    <?php $name = 'shopquestion'; ?>
    <div class="col-md-4">
        <div class="box box-info">
            <div class="box-header" style="padding-bottom: 0px;">
                <label style="font-weight: 400;">
                    <input data-id="group" name="shop_menu[<?php echo $name; ?>/group]" class="minimal"  <?php if(Func::isShopMenu($name.'/group', $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">
                    <h3 class="box-title"><b>Вопросы / ответы</b></h3>
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
            </div>
            <div class="box-body record-input">
                <?php echo trim($siteData->globalDatas['view::_shop/_table/catalog/menu/access/list/shopquestion']); ?>
            </div>
            <div class="box-footer clearfix"></div>
        </div>
    </div>
    <?php } ?>
    <?php if(!empty($siteData->replaceDatas['view::_shop/_table/catalog/menu/access/list/shopcoupon'])){ ?>
        <?php $name = 'shopcoupon'; ?>
        <div class="col-md-4">
            <div class="box box-info">
                <div class="box-header" style="padding-bottom: 0px;">
                    <label style="font-weight: 400;">
                        <input data-id="group" name="shop_menu[<?php echo $name; ?>/group]" class="minimal"  <?php if(Func::isShopMenu($name.'/group', $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">
                        <h3 class="box-title"><b>Купоны</b></h3>
                        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                    </label>
                </div>
                <div class="box-body record-input">
                    <?php echo trim($siteData->globalDatas['view::_shop/_table/catalog/menu/access/list/shopcoupon']); ?>
                </div>
                <div class="box-footer clearfix"></div>
            </div>
        </div>
    <?php } ?>
    <?php if(!empty($siteData->replaceDatas['view::_shop/_table/catalog/menu/access/list/shoppersondiscount'])){ ?>
        <?php $name = 'shoppersondiscount'; ?>
        <div class="col-md-4">
            <div class="box box-info">
                <div class="box-header" style="padding-bottom: 0px;">
                    <label style="font-weight: 400;">
                        <input data-id="group" name="shop_menu[<?php echo $name; ?>/group]" class="minimal"  <?php if(Func::isShopMenu($name.'/group', $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">
                        <h3 class="box-title"><b>Персональные скидки</b></h3>
                        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                    </label>
                </div>
                <div class="box-body record-input">
                    <?php echo trim($siteData->globalDatas['view::_shop/_table/catalog/menu/access/list/shoppersondiscount']); ?>
                </div>
                <div class="box-footer clearfix"></div>
            </div>
        </div>
    <?php } ?>
    <?php if(!empty($siteData->replaceDatas['view::_shop/_table/catalog/menu/access/list/shopmessage'])){ ?>
    <?php $name = 'shopmessage'; ?>
    <div class="col-md-4">
        <div class="box box-info">
            <div class="box-header" style="padding-bottom: 0px;">
                <label style="font-weight: 400;">
                    <input data-id="group" name="shop_menu[<?php echo $name; ?>/group]" class="minimal"  <?php if(Func::isShopMenu($name.'/group', $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">
                    <h3 class="box-title"><b>Сообщения</b></h3>
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
            </div>
            <div class="box-body record-input">
                <?php echo trim($siteData->globalDatas['view::_shop/_table/catalog/menu/access/list/shopmessage']); ?>
            </div>
            <div class="box-footer clearfix"></div>
        </div>
    </div>
    <?php } ?>
    <?php if(!empty($siteData->replaceDatas['view::_shop/_table/catalog/menu/access/list/shopsubscribe'])){ ?>
    <?php $name = 'shopsubscribe'; ?>
    <div class="col-md-4">
        <div class="box box-info">
            <div class="box-header" style="padding-bottom: 0px;">
                <label style="font-weight: 400;">
                    <input data-id="group" name="shop_menu[<?php echo $name; ?>/group]" class="minimal"  <?php if(Func::isShopMenu($name.'/group', $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">
                    <h3 class="box-title"><b>Рассылка</b></h3>
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
            </div>
            <div class="box-body record-input">
                <?php echo trim($siteData->globalDatas['view::_shop/_table/catalog/menu/access/list/shopsubscribe']); ?>
            </div>
            <div class="box-footer clearfix"></div>
        </div>
    </div>
    <?php } ?>
    <?php if(!empty($siteData->replaceDatas['view::_shop/_table/catalog/menu/access/list/shopclient'])){ ?>
    <?php $name = 'shopclient'; ?>
    <div class="col-md-4">
        <div class="box box-info">
            <div class="box-header" style="padding-bottom: 0px;">
                <label style="font-weight: 400;">
                    <input data-id="group" name="shop_menu[<?php echo $name; ?>/group]" class="minimal"  <?php if(Func::isShopMenu($name.'/group', $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">
                    <h3 class="box-title"><b>Клиенты</b></h3>
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
            </div>
            <div class="box-body record-input">
                <?php echo trim($siteData->globalDatas['view::_shop/_table/catalog/menu/access/list/shopclient']); ?>
            </div>
            <div class="box-footer clearfix"></div>
        </div>
    </div>
    <?php } ?>
    <?php if(!empty($siteData->replaceDatas['view::_shop/_table/catalog/menu/access/list/shopsubscribe'])){ ?>
    <?php $name = 'shopsubscribe'; ?>
    <div class="col-md-4">
        <div class="box box-info">
            <div class="box-header" style="padding-bottom: 0px;">
                <label style="font-weight: 400;">
                    <input data-id="group" name="shop_menu[<?php echo $name; ?>/group]" class="minimal"  <?php if(Func::isShopMenu($name.'/group', $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">
                    <h3 class="box-title"><b>Рассылка</b></h3>
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
            </div>
            <div class="box-body record-input">
                <?php echo trim($siteData->globalDatas['view::_shop/_table/catalog/menu/access/list/shopsubscribe']); ?>
            </div>
            <div class="box-footer clearfix"></div>
        </div>
    </div>
    <?php } ?>
    <?php if(!empty($siteData->replaceDatas['view::_shop/_table/catalog/menu/access/list/shopoperation'])){ ?>
    <?php $name = 'shopoperation'; ?>
    <div class="col-md-4">
        <div class="box box-info">
            <div class="box-header" style="padding-bottom: 0px;">
                <label style="font-weight: 400;">
                    <input data-id="group" name="shop_menu[<?php echo $name; ?>/group]" class="minimal"  <?php if(Func::isShopMenu($name.'/group', $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">
                    <h3 class="box-title"><b>Операторы</b></h3>
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
            </div>
            <div class="box-body record-input">
                <?php echo trim($siteData->globalDatas['view::_shop/_table/catalog/menu/access/list/shopoperation']); ?>
            </div>
            <div class="box-footer clearfix"></div>
        </div>
    </div>
    <?php } ?>
    <?php if(!empty($siteData->replaceDatas['view::_shop/_table/catalog/menu/access/list/shopbill'])){ ?>
        <?php $name = 'shopbill'; ?>
        <div class="col-md-4">
            <div class="box box-info">
                <div class="box-header" style="padding-bottom: 0px;">
                    <label style="font-weight: 400;">
                        <input data-id="group" name="shop_menu[<?php echo $name; ?>/group]" class="minimal"  <?php if(Func::isShopMenu($name.'/group', $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">
                        <h3 class="box-title"><b>Заказы</b></h3>
                        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                    </label>
                </div>
                <div class="box-body record-input">
                    <?php echo trim($siteData->globalDatas['view::_shop/_table/catalog/menu/access/list/shopbill']); ?>
                    <?php $key = 'shopbillstatus/index';?>
                    <div class="form-group margin-t-15">
                        <h4 style="color: #00acd6;">
                            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                            Статусы заказов
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </h4>
                    </div>

                    <div class="access-fields">
                        <?php $key = $name.'/rubric?type='.$data->id;?>
                        <div class="form-group">
                            <label style="font-weight: 400;">
                                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                                Рубрика
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <?php $key = $name.'/text?type='.$data->id;?>
                        <div class="form-group">
                            <label style="font-weight: 400;">
                                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                                Описание
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <?php $key = $name.'/text-html?type='.$data->id;?>
                        <div class="form-group">
                            <label style="font-weight: 400;">
                                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                                Описание HTML
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <?php $key = $name.'/image?type='.$data->id; ?>
                        <div class="form-group">
                            <label style="font-weight: 400;">
                                <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                                Картинка
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="box-footer clearfix"></div>
            </div>
        </div>
    <?php } ?>
    <?php if(!empty($siteData->replaceDatas['view::_shop/_table/catalog/menu/access/list/shopoperationstock'])){ ?>
        <?php $name = 'shopoperationstock'; ?>
        <div class="col-md-4">
            <div class="box box-info">
                <div class="box-header" style="padding-bottom: 0px;">
                    <label style="font-weight: 400;">
                        <input data-id="group" name="shop_menu[<?php echo $name; ?>/group]" class="minimal"  <?php if(Func::isShopMenu($name.'/group', $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">
                        <h3 class="box-title"><b>Товары у менеджров</b></h3>
                        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                    </label>
                </div>
                <div class="box-body record-input">
                    <?php echo trim($siteData->globalDatas['view::_shop/_table/catalog/menu/access/list/shopoperationstock']); ?>
                </div>
                <div class="box-footer clearfix"></div>
            </div>
        </div>
    <?php } ?>
    <?php if(!empty($siteData->replaceDatas['view::_shop/_table/catalog/menu/access/list/shopreturn'])){ ?>
        <?php $name = 'shopreturn'; ?>
        <div class="col-md-4">
            <div class="box box-info">
                <div class="box-header" style="padding-bottom: 0px;">
                    <label style="font-weight: 400;">
                        <input data-id="group" name="shop_menu[<?php echo $name; ?>/group]" class="minimal"  <?php if(Func::isShopMenu($name.'/group', $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">
                        <h3 class="box-title"><b>Возвраты</b></h3>
                        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                    </label>
                </div>
                <div class="box-body record-input">
                    <?php echo trim($siteData->globalDatas['view::_shop/_table/catalog/menu/access/list/shopreturn']); ?>
                </div>
                <div class="box-footer clearfix"></div>
            </div>
        </div>
    <?php } ?>
    <?php if(!empty($siteData->replaceDatas['view::_shop/_table/catalog/menu/access/list/shoppaid'])){ ?>
        <?php $name = 'shoppaid'; ?>
        <div class="col-md-4">
            <div class="box box-info">
                <div class="box-header" style="padding-bottom: 0px;">
                    <label style="font-weight: 400;">
                        <input data-id="group" name="shop_menu[<?php echo $name; ?>/group]" class="minimal"  <?php if(Func::isShopMenu($name.'/group', $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">
                        <h3 class="box-title"><b>Оплаты</b></h3>
                        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                    </label>
                </div>
                <div class="box-body record-input">
                    <?php echo trim($siteData->globalDatas['view::_shop/_table/catalog/menu/access/list/shoppaid']); ?>
                </div>
                <div class="box-footer clearfix"></div>
            </div>
        </div>
    <?php } ?>
    <div class="col-md-4">
        <div class="box box-info">
            <div class="box-header" style="padding-bottom: 0px;">
                <label style="font-weight: 400;">
                    <input data-id="group" name="shop_menu[shopinformation/group]" class="minimal"  <?php if(Func::isShopMenu('shopinformation/group', $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">
                    <h3 class="box-title"><b>Информация о компании</b></h3>
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
            </div>
            <div class="box-body record-input">
                <div class="form-group">
                    <h4 class="text-red">
                        <input name="shop_menu[shop/edit]" class="minimal"  <?php if(Func::isShopMenu('shop/edit', $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Информация о компании
                        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                    </h4>
                </div>
                <div class="access-fields">
                    <?php $name = 'shop'; ?>
                    <?php $key = $name.'/subdomain';?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                            Субдомен
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                    <?php $key = $name.'/domain';?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                            Домен
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                    <?php $key = $name.'/work_time';?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                            Режим работы
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                    <?php $key = $name.'/requisites';?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                            Реквизиты
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                    <?php $key = $name.'/city';?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                            Города
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                    <?php $key = $name.'/land';?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                            Страны
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                    <?php $key = $name.'/currency';?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                            Валюта
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                    <?php $key = $name.'/text?type='.$data->id; ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                            Описание
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                    <?php $key = $name.'/text-html?type='.$data->id; ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                            Описание HTML
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                    <?php $key = $name.'/image?type='.$data->id; ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                            Картинка
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label style="font-weight: 400;">
                        <input name="shop_menu[shopdeliverytype/index]" class="minimal"  <?php if(Func::isShopMenu('shopdeliverytype/index', $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Доставка
                        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                    </label>
                </div>
                <div class="form-group">
                    <label style="font-weight: 400;">
                        <input name="shop_menu[shoppaidtype/index]" class="minimal"  <?php if(Func::isShopMenu('shoppaidtype/index', $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Оплата
                        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                    </label>
                </div>
                <div class="form-group">
                    <label style="font-weight: 400;">
                        <input name="shop_menu[shopaddresscontact/index]" class="minimal"  <?php if(Func::isShopMenu('shopaddresscontact/index', $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Контакты
                        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                    </label>
                </div>
                <div class="access-fields">
                    <?php $name = 'shopaddresscontact'; ?>
                    <?php $key = $name.'/text'; ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                            Описание
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                    <?php $key = $name.'/text-html'; ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                            Описание HTML
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label style="font-weight: 400;">
                        <input name="shop_menu[shopaddresscontactrubric/index]" class="minimal"  <?php if(Func::isShopMenu('shopaddresscontactrubric/index', $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Рубрики контактов
                        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                    </label>
                </div>
                <div class="form-group">
                    <label style="font-weight: 400;">
                        <input name="shop_menu[shopaddress/editmain]" class="minimal"  <?php if(Func::isShopMenu('shopaddress/editmain', $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Адрес компании
                        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                    </label>
                </div>
                <div class="access-fields">
                    <?php $name = 'shopaddress'; ?>
                    <?php $key = $name.'/land'; ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                            Страна
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                    <?php $key = $name.'/city'; ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                            Город
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                    <?php $key = $name.'/text'; ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                            Описание
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                    <?php $key = $name.'/text-html'; ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[<?php echo $key; ?>]" class="minimal" type="checkbox" <?php if(Func::isShopMenu($key, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?>>
                            Описание HTML
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label style="font-weight: 400;">
                        <input name="shop_menu[shopaddress/index]" class="minimal"  <?php if(Func::isShopMenu('shopaddress/index', $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Адреса филиалов
                        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                    </label>
                </div>
            </div>
            <div class="box-footer clearfix"></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box box-info">
            <div class="box-header" style="padding-bottom: 0px;">
                <label style="font-weight: 400;">
                    <input data-id="group" name="shop_menu[shopoptions/group]" class="minimal"  <?php if(Func::isShopMenu('shopoptions/group', $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">
                    <h3 class="box-title"><b>Настройки сайта</b></h3>
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
            </div>
            <div class="box-body record-input">
                <div class="form-group">
                    <label style="font-weight: 400;">
                        <input name="shop_menu[siteoptions/heads]" class="minimal"  <?php if(Func::isShopMenu('siteoptions/heads', $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  SEO-настройки
                        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                    </label>
                </div>
                <div class="form-group">
                    <label style="font-weight: 400;">
                        <input name="shop_menu[shopemail/index]" class="minimal"  <?php if(Func::isShopMenu('shopemail/index', $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Шаблоны e-mail сообщений
                        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                    </label>
                </div>
                <div class="form-group">
                    <label style="font-weight: 400;">
                        <input name="shop_menu[shopredirect/index]" class="minimal"  <?php if(Func::isShopMenu('shopredirect/index', $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Шаблоны e-mail сообщений
                        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                    </label>
                </div>
            </div>
            <div class="box-footer clearfix"></div>
        </div>
    </div>
</div>
<div class="row">
    <div hidden>
        <input name="data_language_id" value="<?php echo $siteData->dataLanguageID; ?>">
        <?php if($siteData->branchID > 0){ ?>
            <input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
        <?php } ?>
        <?php if($siteData->superUserID > 0){ ?>
            <input name="shop_id" value="<?php echo $siteData->shopID; ?>">
        <?php } ?>
    </div>

    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>