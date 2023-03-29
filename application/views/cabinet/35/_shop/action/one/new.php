<form action="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopaction/save" method="post" style="padding-right: 5px;">
<div class="row">
    <div class="col-md-9">
        <div class="row record-input record-tab">
            <div class="col-md-3 record-title"></div>
            <div class="col-md-5" style="max-width: 250px;">
                <span class="span-checkbox">
                    <input name="is_public" value="1" checked type="checkbox" class="minimal">
                    Запустить акцию
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </span>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Название
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
            </div>
            <div class="col-md-9">
                <input name="name" type="text" class="form-control" placeholder="Название">
            </div>
        </div>
        <div class="row record-input2 record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Срок действия от
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input name="from_at" type="datetime" class="form-control pull-right">
                </div>
            </div>
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Срок действия до
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input name="to_at" type="datetime" class="form-control pull-right">
                </div>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    Описание
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </label>
            </div>
            <div class="col-md-9 record-textarea">
                <textarea name="text" placeholder="Описание..." rows="11" class="form-control"></textarea>
            </div>
        </div>
        <div class="nav-tabs-custom margin-t-15">
            <ul class="nav nav-tabs" id="promo-list">
                <li class="active"><a href="#tab0" data-toggle="tab" data-id="0">Без просчета  <i class="fa fa-fw fa-info text-blue"></i></a></li>
                <li class=""><a href="#tab1" data-toggle="tab" data-id="<?php echo Model_ActionType::ACTION_TYPE_BILL_AMOUNT;?>">От суммы заказа <i class="fa fa-fw fa-info text-blue"></i></a></li>
                <li class=""><a href="#tab2" data-toggle="tab" data-id="<?php echo Model_ActionType::ACTION_TYPE_CATALOGS;?>">На рубрики товаров / услуг <i class="fa fa-fw fa-info text-blue"></i></a></li>
                <li class=""><a href="#tab3" data-toggle="tab" data-id="<?php echo Model_ActionType::ACTION_TYPE_GOODS;?>">На товары / услуги <i class="fa fa-fw fa-info text-blue"></i></a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="tab0">
                    <div class="row">
                        <div class="col-sm-12 padding-b-10 text-center">
                            <div class="contacts-list-msg text-center margin-b-5">Без просчета акции</div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab1">
                    <div class="row record-input record-tab">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Общая сумма
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input name="amount" type="text" class="form-control" placeholder="Общая сумма">
                        </div>
                        <div class="col-md-1" style="padding-top: 8px;">
                            <span><?php echo trim(str_replace('{amount}', '', $siteData->currency->getSymbol()));?></span>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab2">
                    <?php echo $siteData->globalDatas['view::_shop/_table/rubric/list/promo'];?>
                    <div class="row record-input record-tab margin-t-15">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Общее кол-во
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-2">
                            <input name="shop_table_rubrics_count" type="text" class="form-control" placeholder="Общее кол-во">
                        </div>
                        <div class="col-md-1" style="padding-top: 8px;">
                            <span>шт.</span>
                        </div>
                    </div>
                    <div class="row record-input record-tab">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Общая сумма
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-2">
                            <input name="shop_table_rubrics_amount" type="text" class="form-control" placeholder="Общая сумма">
                        </div>
                        <div class="col-md-1" style="padding-top: 8px;">
                            <span><?php echo trim(str_replace('{amount}', '', $siteData->currency->getSymbol()));?></span>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab3">
                    <?php echo $siteData->globalDatas['view::_shop/good/list/promo'];?>
                    <div class="row record-input record-tab margin-t-15">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Общее кол-во
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-2">
                            <input name="shop_goods_count" type="text" class="form-control" placeholder="Общее кол-во">
                        </div>
                        <div class="col-md-1" style="padding-top: 8px;">
                            <span>шт.</span>
                        </div>
                    </div>
                    <div class="row record-input record-tab">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Общая сумма
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-2">
                            <input name="shop_goods_amount" type="text" class="form-control" placeholder="Общая сумма">
                        </div>
                        <div class="col-md-1" style="padding-top: 8px;">
                            <span><?php echo trim(str_replace('{amount}', '', $siteData->currency->getSymbol()));?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs" id="gift-list">
                <li class="active"><a href="#tab4" data-toggle="tab" data-id="<?php echo Model_GiftType::GIFT_TYPE_BILL_COMMENT;?>">Примечание к заказу <i class="fa fa-fw fa-info text-blue"></i></a></li>
                <li class=""><a href="#tab5" data-toggle="tab" data-id="<?php echo Model_GiftType::GIFT_TYPE_BILL_GIFT;?>">Подарки <i class="fa fa-fw fa-info text-blue"></i></a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="tab4">
                    <div class="row record-input record-tab">
                        <div class="col-md-3 record-title">
                            <label>
                                Примечание к заказу
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <textarea name="gift_bill_comment" placeholder="Примечание к заказу" rows="3" class="form-control"><?php echo Arr::path($data->additionDatas, 'gift_bill_comment', '');?></textarea>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab5">
                    <?php echo $siteData->globalDatas['view::_shop/good/list/promo-gift'];?>
                    <div class="row record-input record-tab margin-t-15">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Общее кол-во
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-2">
                            <input name="gift_shop_goods_count" type="text" class="form-control" placeholder="Общее кол-во">
                        </div>
                        <div class="col-md-1" style="padding-top: 8px;">
                            <span>шт.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <?php
        $view = View::factory('cabinet/35/_addition/files');
        $view->siteData = $siteData;
        $view->data = $data;
        $view->columnSize = 12;
        echo Helpers_View::viewToStr($view);
        ?>
    </div>
</div>
<div class="row">
    <div hidden>
        <input id="gift-type" name="gift_type_id" value="<?php echo Model_GiftType::GIFT_TYPE_BILL_COMMENT;?>">
        <input id="promo-type" name="action_type_id" value="0">
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
</form>
<script>
    CKEDITOR.replace('text');
</script>

<?php
$view = View::factory('cabinet/35/popup/promo');
$view->siteData = $siteData;
$view->data = $data;
echo Helpers_View::viewToStr($view);
?>
<?php
$view = View::factory('cabinet/35/popup/promo-gift');
$view->siteData = $siteData;
$view->data = $data;
echo Helpers_View::viewToStr($view);
?>
