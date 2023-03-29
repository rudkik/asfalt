<?php if(Func::isShopMenuVisible('shopbranch/group', $siteData)){ ?>
    <div class="col-md-4">
        <div class="box box-info">
            <div class="box-header">
                <label style="font-weight: 400;">
                    <input data-id="group" name="shop_menu[shopbranch/group]" class="minimal"  <?php if(Func::isShopMenu('shopbranch/group', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">
                    <h3 class="box-title"><b>Филиалы</b></h3>
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
            </div>
            <div class="box-body record-input">
                <?php if(Func::isShopMenuVisible('shopbranchtype/index', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopbranchtype/index]" class="minimal"  <?php if(Func::isShopMenu('shopbranchtype/index', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Виды филиалов
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>
                <?php if(Func::isShopMenuVisible('shopbranchcatalog/index-all', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopbranchcatalog/index-all]" class="minimal"  <?php if(Func::isShopMenu('shopbranchcatalog/index-all', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Рубрики (общие)
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>
                <?php if(Func::isShopMenuVisible('shopbranchcatalog/index-all-root', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopbranchcatalog/index-all-root]" class="minimal"  <?php if(Func::isShopMenu('shopbranchcatalog/index-all-root', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Рубрики второго уровня (общие)
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>

                <?php echo $siteData->globalDatas['view::shopbranchtypes/shopmenu'];?>
            </div>
            <div class="box-footer clearfix"></div>
        </div>
    </div>
<?php } ?>
<?php if(Func::isShopMenuVisible('shopgood/group', $siteData)){ ?>
    <div class="col-md-4">
        <div class="box box-info">
            <div class="box-header">
                <label style="font-weight: 400;">
                    <input data-id="group" name="shop_menu[shopgood/group]" class="minimal"  <?php if(Func::isShopMenu('shopgood/group', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">
                    <h3 class="box-title"><b>Товары / услуги</b></h3>
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
            </div>
            <div class="box-body record-input">
                <?php if(Func::isShopMenuVisible('shopgoodtype/index', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopgoodtype/index]" class="minimal"  <?php if(Func::isShopMenu('shopgoodtype/index', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Виды товаров / услуг
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>
                <?php if(Func::isShopMenuVisible('shopgoodselecttype/index', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopgoodselecttype/index]" class="minimal"  <?php if(Func::isShopMenu('shopgoodselecttype/index', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Типы выделения товаров / услуг
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>
                <?php if(Func::isShopMenuVisible('shopgoodcatalog/index-all', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopgoodcatalog/index-all]" class="minimal"  <?php if(Func::isShopMenu('shopgoodcatalog/index-all', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Рубрики (общие)
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>
                <?php if(Func::isShopMenuVisible('shopgoodcatalog/index-all-root', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopgoodcatalog/index-all-root]" class="minimal"  <?php if(Func::isShopMenu('shopgoodcatalog/index-all-root', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Рубрики второго уровня (общие)
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>
                <?php if(Func::isShopMenuVisible('shopgoodcatalog/index-all-params', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopgoodcatalog/index-all-params]" class="minimal"  <?php if(Func::isShopMenu('shopgoodcatalog/index-all-params', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Доп. параметры рубрик (общие)
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>
                <?php if(Func::isShopMenuVisible('shopattribute/index-all', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopattribute/index-all]" class="minimal"  <?php if(Func::isShopMenu('shopattribute/index-all', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox"> Атрибуты (общие)
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>

                <?php if(Func::isShopMenuVisible('shopattributecatalog/index-all', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopattributecatalog/index-all]" class="minimal"  <?php if(Func::isShopMenu('shopattributecatalog/index-all', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox"> Рубрики атрибутов (общие)
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>

                <?php if(Func::isShopMenuVisible('shopattributegroup/index-all', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopattributegroup/index-all]" class="minimal"  <?php if(Func::isShopMenu('shopattributegroup/index-all', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox"> Группы атрибутов (общие)
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>

                <?php echo $siteData->globalDatas['view::shopgoodtypes/shopmenu'];?>
            </div>
            <div class="box-footer clearfix"></div>
        </div>
    </div>
<?php } ?>
<?php if(Func::isShopMenuVisible('shoppromo/group', $siteData)){ ?>
    <div class="col-md-4">
        <div class="box box-info">
            <div class="box-header">
                <label style="font-weight: 400;">
                    <input data-id="group" name="shop_menu[shoppromo/group]" class="minimal"  <?php if(Func::isShopMenu('shoppromo/group', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">
                    <h3 class="box-title"><b>Промо</b></h3>
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
            </div>
            <div class="box-body record-input">
                <?php if(Func::isShopMenuVisible('shopaction/index', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopaction/index]" class="minimal"  <?php if(Func::isShopMenu('shopaction/index', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Акции
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>
                <?php if(Func::isShopMenuVisible('shopdiscount/index', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopdiscount/index]" class="minimal"  <?php if(Func::isShopMenu('shopdiscount/index', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Скидки
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>
                <?php if(Func::isShopMenuVisible('shopcoupon/index', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopcoupon/index]" class="minimal"  <?php if(Func::isShopMenu('shopcoupon/index', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Купоны
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>
            </div>
            <div class="box-footer clearfix"></div>
        </div>
    </div>
<?php } ?>
<?php if(Func::isShopMenuVisible('shopnew/group', $siteData)){ ?>
    <div class="col-md-4">
        <div class="box box-info">
            <div class="box-header">
                <label style="font-weight: 400;">
                    <input data-id="group" name="shop_menu[shopnew/group]" class="minimal"  <?php if(Func::isShopMenu('shopnew/group', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">
                    <h3 class="box-title"><b>Статьи / новости</b></h3>
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
            </div>
            <div class="box-body record-input">
                <?php if(Func::isShopMenuVisible('shopinformationdata/index', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopinformationdata/index]" class="minimal"  <?php if(Func::isShopMenu('shopinformationdata/index', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Статичные блоки
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>
                <?php if(Func::isShopMenuVisible('shopnewcatalog/index', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopnewcatalog/index]" class="minimal"  <?php if(Func::isShopMenu('shopnewcatalog/index', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Виды статей / новостей
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>
                <?php if(Func::isShopMenuVisible('shopnewrubric/index-all', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopnewrubric/index-all]" class="minimal"  <?php if(Func::isShopMenu('shopnewrubric/index-all', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Рубрики (общие)
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>
                <?php if(Func::isShopMenuVisible('shopnewrubric/index-all-root', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopnewrubric/index-all-root]" class="minimal"  <?php if(Func::isShopMenu('shopnewrubric/index-all-root', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Рубрики второго уровня (общие)
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>
                <?php if(Func::isShopMenuVisible('shopnewrubric/index-all-params', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopnewrubric/index-all-params]" class="minimal"  <?php if(Func::isShopMenu('shopnewrubric/index-all-params', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Доп. параметры рубрик (общие)
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>
                <?php if(Func::isShopMenuVisible('shopnewhashtag/index-all', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopnewhashtag/index-all]" class="minimal"  <?php if(Func::isShopMenu('shopnewhashtag/index-all', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Хэштеги (общие)
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>

                <?php echo $siteData->globalDatas['view::shopnewcatalogs/shopmenu'];?>

            </div>
            <div class="box-footer clearfix"></div>
        </div>
    </div>
<?php } ?>
<?php if(Func::isShopMenuVisible('shopfile/group', $siteData)){ ?>
    <div class="col-md-4">
        <div class="box box-info">
            <div class="box-header">
                <label style="font-weight: 400;">
                    <input data-id="group" name="shop_menu[shopfile/group]" class="minimal"  <?php if(Func::isShopMenu('shopfile/group', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">
                    <h3 class="box-title"><b>Файлы</b></h3>
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
            </div>
            <div class="box-body record-input">
                <?php if(Func::isShopMenuVisible('shopfilecatalog/index', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopfilecatalog/index]" class="minimal"  <?php if(Func::isShopMenu('shopfilecatalog/index', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Виды файлов
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>
                <?php if(Func::isShopMenuVisible('shopfilerubric/index-all', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopfilerubric/index-all]" class="minimal"  <?php if(Func::isShopMenu('shopfilerubric/index-all', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Рубрики (общие)
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>
                <?php if(Func::isShopMenuVisible('shopfilerubric/index-all-root', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopfilerubric/index-all-root]" class="minimal"  <?php if(Func::isShopMenu('shopfilerubric/index-all-root', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Рубрики второго уровня (общие)
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>
                <?php if(Func::isShopMenuVisible('shopfilerubric/index-all-params', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopfilerubric/index-all-params]" class="minimal"  <?php if(Func::isShopMenu('shopfilerubric/index-all-params', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Доп. параметры рубрик (общие)
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>

                <?php echo $siteData->globalDatas['view::shopfilecatalogs/shopmenu'];?>
            </div>
            <div class="box-footer clearfix"></div>
        </div>
    </div>
<?php } ?>
<?php if(Func::isShopMenuVisible('shopgallery/group', $siteData)){ ?>
    <div class="col-md-4">
        <div class="box box-info">
            <div class="box-header">
                <label style="font-weight: 400;">
                    <input data-id="group" name="shop_menu[shopgallery/group]" class="minimal"  <?php if(Func::isShopMenu('shopgallery/group', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">
                    <h3 class="box-title"><b>Галерея</b></h3>
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
            </div>
            <div class="box-body record-input">
                <?php if(Func::isShopMenuVisible('shopgallerycatalog/index', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopgallerycatalog/index]" class="minimal"  <?php if(Func::isShopMenu('shopgallerycatalog/index', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Виды галлерей
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>
                <?php if(Func::isShopMenuVisible('shopgalleryrubric/index-all', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopgalleryrubric/index-all]" class="minimal"  <?php if(Func::isShopMenu('shopgalleryrubric/index-all', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Рубрики (общие)
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>
                <?php if(Func::isShopMenuVisible('shopgalleryrubric/index-all-root', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopgalleryrubric/index-all-root]" class="minimal"  <?php if(Func::isShopMenu('shopgalleryrubric/index-all-root', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Рубрики второго уровня (общие)
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>
                <?php if(Func::isShopMenuVisible('shopgalleryrubric/index-all-params', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopgalleryrubric/index-all-params]" class="minimal"  <?php if(Func::isShopMenu('shopgalleryrubric/index-all-params', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Доп. параметры рубрик (общие)
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>

                <?php echo $siteData->globalDatas['view::shopgallerycatalogs/shopmenu'];?>
            </div>
            <div class="box-footer clearfix"></div>
        </div>
    </div>
<?php } ?>
<?php if(Func::isShopMenuVisible('shopcomment/group', $siteData)){ ?>
    <div class="col-md-4">
        <div class="box box-info">
            <div class="box-header">
                <label style="font-weight: 400;">
                    <input data-id="group" name="shop_menu[shopcomment/group]" class="minimal"  <?php if(Func::isShopMenu('shopcomment/group', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">
                    <h3 class="box-title"><b>Комментарии</b></h3>
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
            </div>
            <div class="box-body record-input">
                <?php if(Func::isShopMenuVisible('shopcommentcatalog/index', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopcommentcatalog/index]" class="minimal"  <?php if(Func::isShopMenu('shopcommentcatalog/index', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Виды комментариев
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>
                <?php if(Func::isShopMenuVisible('shopcommentrubric/index-all', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopcommentrubric/index-all]" class="minimal"  <?php if(Func::isShopMenu('shopcommentrubric/index-all', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Рубрики (общие)
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>
                <?php if(Func::isShopMenuVisible('shopcommentrubric/index-all-root', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopcommentrubric/index-all-root]" class="minimal"  <?php if(Func::isShopMenu('shopcommentrubric/index-all-root', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Рубрики второго уровня (общие)
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>
                <?php if(Func::isShopMenuVisible('shopcommentrubric/index-all-params', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopcommentrubric/index-all-params]" class="minimal"  <?php if(Func::isShopMenu('shopcommentrubric/index-all-params', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Доп. параметры рубрик (общие)
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>

                <?php echo $siteData->globalDatas['view::shopcommentcatalogs/shopmenu'];?>
            </div>
            <div class="box-footer clearfix"></div>
        </div>
    </div>
<?php } ?>
<?php if(Func::isShopMenuVisible('shopquestion/group', $siteData)){ ?>
    <div class="col-md-4">
        <div class="box box-info">
            <div class="box-header">
                <label style="font-weight: 400;">
                    <input data-id="group" name="shop_menu[shopquestion/group]" class="minimal"  <?php if(Func::isShopMenu('shopquestion/group', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">
                    <h3 class="box-title"><b>Вопросы / ответы</b></h3>
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
            </div>
            <div class="box-body record-input">
                <?php if(Func::isShopMenuVisible('shopquestioncatalog/index', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopquestioncatalog/index]" class="minimal"  <?php if(Func::isShopMenu('shopquestioncatalog/index', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Виды вопросов / ответов
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>
                <?php if(Func::isShopMenuVisible('shopquestionrubric/index-all', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopquestionrubric/index-all]" class="minimal"  <?php if(Func::isShopMenu('shopquestionrubric/index-all', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Рубрики (общие)
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>
                <?php if(Func::isShopMenuVisible('shopquestionrubric/index-all-root', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopquestionrubric/index-all-root]" class="minimal"  <?php if(Func::isShopMenu('shopquestionrubric/index-all-root', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Рубрики второго уровня (общие)
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>
                <?php if(Func::isShopMenuVisible('shopquestionrubric/index-all-params', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopquestionrubric/index-all-params]" class="minimal"  <?php if(Func::isShopMenu('shopquestionrubric/index-all-params', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Доп. параметры рубрик (общие)
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>

                <?php echo $siteData->globalDatas['view::shopquestioncatalogs/shopmenu'];?>
            </div>
            <div class="box-footer clearfix"></div>
        </div>
    </div>
<?php } ?>
<?php if(Func::isShopMenuVisible('shopmessage/group', $siteData)){ ?>
    <div class="col-md-4">
        <div class="box box-info">
            <div class="box-header">
                <label style="font-weight: 400;">
                    <input data-id="group" name="shop_menu[shopmessage/group]" class="minimal"  <?php if(Func::isShopMenu('shopmessage/group', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">
                    <h3 class="box-title"><b>Сообщения</b></h3>
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
            </div>
            <div class="box-body record-input">
                <?php if(Func::isShopMenuVisible('shopmessagecatalog/index', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopmessagecatalog/index]" class="minimal"  <?php if(Func::isShopMenu('shopmessagecatalog/index', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Виды статей / новостей
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>

                <?php echo $siteData->globalDatas['view::shopmessagecatalogs/shopmenu'];?>

            </div>
            <div class="box-footer clearfix"></div>
        </div>
    </div>
<?php } ?>

<?php if(Func::isShopMenuVisible('shopsubscribege/group', $siteData)){ ?>
    <div class="col-md-4">
        <div class="box box-info">
            <div class="box-header">
                <label style="font-weight: 400;">
                    <input data-id="group" name="shop_menu[shopsubscribege/group]" class="minimal"  <?php if(Func::isShopMenu('shopsubscribege/group', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">
                    <h3 class="box-title"><b>Рассылка</b></h3>
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
            </div>
            <div class="box-body record-input">
                <?php if(Func::isShopMenuVisible('shopsubscribegecatalog/index', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopsubscribegecatalog/index]" class="minimal"  <?php if(Func::isShopMenu('shopsubscribegecatalog/index', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Виды статей / новостей
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>

                <?php echo $siteData->globalDatas['view::shopsubscribecatalogs/shopmenu'];?>

            </div>
            <div class="box-footer clearfix"></div>
        </div>
    </div>
<?php } ?>

<?php if(Func::isShopMenuVisible('shopclientphonege/group', $siteData)){ ?>
    <div class="col-md-4">
        <div class="box box-info">
            <div class="box-header">
                <label style="font-weight: 400;">
                    <input data-id="group" name="shop_menu[shopclientphonege/group]" class="minimal"  <?php if(Func::isShopMenu('shopclientphonege/group', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">
                    <h3 class="box-title"><b>Телефоны клиентов</b></h3>
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
            </div>
            <div class="box-body record-input">
                <?php if(Func::isShopMenuVisible('shopclientphonegecatalog/index', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopclientphonegecatalog/index]" class="minimal"  <?php if(Func::isShopMenu('shopclientphonegecatalog/index', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Виды статей / новостей
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>

                <?php echo $siteData->globalDatas['view::shopclientphonecatalogs/shopmenu'];?>

            </div>
            <div class="box-footer clearfix"></div>
        </div>
    </div>
<?php } ?>

<?php if(Func::isShopMenuVisible('shopbill/group', $siteData)){ ?>
    <div class="col-md-4">
        <div class="box box-info">
            <div class="box-header">
                <label style="font-weight: 400;">
                    <input data-id="group" name="shop_menu[shopbill/group]" class="minimal"  <?php if(Func::isShopMenu('shopbill/group', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">
                    <h3 class="box-title"><b>Заказы</b></h3>
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
            </div>
            <div class="box-body record-input">
                <?php if(Func::isShopMenuVisible('shopbill/index', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopbill/index]" class="minimal"  <?php if(Func::isShopMenu('shopbill/index', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Заказы
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>
                <?php if(Func::isShopMenuVisible('shopbill/index-branch', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopbill/index-branch]" class="minimal"  <?php if(Func::isShopMenu('shopbill/index-branch', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Заказы филиалов
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>
                <?php if(Func::isShopMenuVisible('shopreport/index', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopreport/index]" class="minimal"  <?php if(Func::isShopMenu('shopreport/index', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Статистика заказов
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>
            </div>
            <div class="box-footer clearfix"></div>
        </div>
    </div>
<?php } ?>
<?php if(Func::isShopMenuVisible('shopinformation/group', $siteData)){ ?>
    <div class="col-md-4">
        <div class="box box-info">
            <div class="box-header">
                <label style="font-weight: 400;">
                    <input data-id="group" name="shop_menu[shopinformation/group]" class="minimal"  <?php if(Func::isShopMenu('shopinformation/group', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">
                    <h3 class="box-title"><b>Информация о компании</b></h3>
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
            </div>
            <div class="box-body record-input">
                <?php if(Func::isShopMenuVisible('shop/edit', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shop/edit]" class="minimal"  <?php if(Func::isShopMenu('shop/edit', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Информация о компании
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>
                <?php if(Func::isShopMenuVisible('shopdeliverytype/index', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopdeliverytype/index]" class="minimal"  <?php if(Func::isShopMenu('shopdeliverytype/index', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Доставка
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>
                <?php if(Func::isShopMenuVisible('shoppaidtype/index', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shoppaidtype/index]" class="minimal"  <?php if(Func::isShopMenu('shoppaidtype/index', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Оплата
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>
                <?php if(Func::isShopMenuVisible('shopoperation/index', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopoperation/index]" class="minimal"  <?php if(Func::isShopMenu('shopoperation/index', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Сотрудники
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>
                <?php if(Func::isShopMenuVisible('shopaddress/editmain', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopaddress/editmain]" class="minimal"  <?php if(Func::isShopMenu('shopaddress/editmain', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Адрес компании
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>
                <?php if(Func::isShopMenuVisible('shopaddresscontact/index', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopaddresscontact/index]" class="minimal"  <?php if(Func::isShopMenu('shopaddresscontact/index', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Контакты компании
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>
                <?php if(Func::isShopMenuVisible('shopdeliverytype/index', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopaddress/index]" class="minimal"  <?php if(Func::isShopMenu('shopaddress/index', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Адреса филиалов
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>
            </div>
            <div class="box-footer clearfix"></div>
        </div>
    </div>
<?php } ?>
<?php if(Func::isShopMenuVisible('shopoptions/group', $siteData)){ ?>
    <div class="col-md-4">
        <div class="box box-info">
            <div class="box-header">
                <label style="font-weight: 400;">
                    <input data-id="group" name="shop_menu[shopoptions/group]" class="minimal"  <?php if(Func::isShopMenu('shopoptions/group', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">
                    <h3 class="box-title"><b>Настройки сайта</b></h3>
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
            </div>
            <div class="box-body record-input">
                <?php if(Func::isShopMenuVisible('siteoptions/heads', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[siteoptions/heads]" class="minimal"  <?php if(Func::isShopMenu('siteoptions/heads', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  SEO-настройки
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>
                <?php if(Func::isShopMenuVisible('shopemail/index', $siteData)){ ?>
                    <div class="form-group">
                        <label style="font-weight: 400;">
                            <input name="shop_menu[shopemail/index]" class="minimal"  <?php if(Func::isShopMenu('shopemail/index', $data->values, $siteData) === TRUE){echo 'checked value="1"';}else{echo 'value="0"';};?> type="checkbox">  Шаблоны e-mail сообщений
                            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                        </label>
                    </div>
                <?php } ?>
            </div>
            <div class="box-footer clearfix"></div>
        </div>
    </div>
<?php } ?>
