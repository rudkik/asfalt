<form action="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopdiscount/save" method="post" style="padding-right: 5px;">
<div class="row">
    <div class="col-md-9">
        <div class="row record-input record-tab">
            <div class="col-md-3 record-title"></div>
            <div class="col-md-5" style="max-width: 250px;">
                <span class="span-checkbox">
                    <input name="is_public" <?php if ($data->values['is_public'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
                    Запустить скидку
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </span>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                    <span>
                        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                        Название
                        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                    </span>
            </div>
            <div class="col-md-9">
                <input name="name" type="text" class="form-control" placeholder="Название" value="<?php echo htmlspecialchars($data->values['name']);?>">
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                    <span>
                        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                        Срок действия от
                        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                    </span>
            </div>
            <div class="col-md-9">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input name="from_at" type="datetime" class="form-control pull-right" value="<?php echo htmlspecialchars($data->values['from_at']);?>">
                </div>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                    <span>
                        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                        Срок действия до
                        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                    </span>
            </div>
            <div class="col-md-9">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input name="to_at" type="datetime" class="form-control pull-right" value="<?php echo htmlspecialchars($data->values['to_at']);?>">
                </div>
            </div>
        </div>

        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <span>
                    Описание
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                </span>

            </div>
            <div class="col-md-9 record-textarea">
                <textarea name="text" placeholder="Описание..." rows="11" class="form-control"><?php echo $data->values['text'];?></textarea>
            </div>
        </div>

        <div class="nav-tabs-custom margin-top-15px">
            <ul class="nav nav-tabs" id="promo-list">
                <li class="<?php if(intval($data->values['discount_type_id']) == 0){echo 'active';} ?>"><a href="#tab0" data-toggle="tab" data-id="0">Без просчета  <i class="fa fa-fw fa-info text-blue"></i></a></li>
                <li class="<?php if($data->values['discount_type_id'] == Model_DiscountType::DISCOUNT_TYPE_BILL_AMOUNT){echo 'active';} ?>"><a href="#tab1" data-toggle="tab" data-id="<?php echo Model_DiscountType::DISCOUNT_TYPE_BILL_AMOUNT;?>">От суммы заказа <i class="fa fa-fw fa-info text-blue"></i></a></li>
                <li class="<?php if($data->values['discount_type_id'] == Model_DiscountType::DISCOUNT_TYPE_CATALOGS){echo 'active';} ?>"><a href="#tab2" data-toggle="tab" data-id="<?php echo Model_DiscountType::DISCOUNT_TYPE_CATALOGS;?>">На рубрики товаров / услуг <i class="fa fa-fw fa-info text-blue"></i></a></li>
                <li class="<?php if($data->values['discount_type_id'] == Model_DiscountType::DISCOUNT_TYPE_GOODS){echo 'active';} ?>"><a href="#tab3" data-toggle="tab" data-id="<?php echo Model_DiscountType::DISCOUNT_TYPE_GOODS;?>">На товары / услуги <i class="fa fa-fw fa-info text-blue"></i></a></li>
            </ul>
            <div class="tab-content">
                <div class="<?php if(intval($data->values['discount_type_id']) == 0){echo 'active';} ?> tab-pane" id="tab0">
                    <div class="row">
                        <div class="col-sm-12 padding-bottom-10px text-center">
                            <div class="contacts-list-msg text-center margin-bottom-5px">Без просчета акции</div>
                        </div>
                    </div>
                </div>
                <div class="<?php if($data->values['discount_type_id'] == Model_DiscountType::DISCOUNT_TYPE_BILL_AMOUNT){echo 'active';} ?> tab-pane" id="tab1">
                    <div class="row record-input record-tab">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Сумма
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input name="amount" type="text" class="form-control" placeholder="Сумма" value="<?php echo htmlspecialchars(Arr::path($data->additionDatas, 'amount', ''));?>">
                        </div>
                        <div class="col-md-1" style="padding-top: 8px;">
                            <span><?php echo trim(str_replace('{amount}', '', $siteData->currency->getSymbol()));?></span>
                        </div>
                    </div>
                </div>
                <div class="<?php if($data->values['discount_type_id'] == Model_DiscountType::DISCOUNT_TYPE_CATALOGS){echo 'active';} ?> tab-pane" id="tab2">
                    <?php echo $siteData->globalDatas['view::shopgoodcatalogs/promo'];?>
                    <div class="row record-input record-tab margin-top-15px">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Кол-во товаров / услуг
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input name="shopgoodcatalogs_count" type="text" class="form-control" placeholder="Кол-во товаров" value="<?php echo Arr::path($data->additionDatas, 'shopgoodcatalogs_count', ''); ?>">
                        </div>
                        <div class="col-md-1" style="padding-top: 8px;">
                            <span>шт.</span>
                        </div>
                    </div>
                </div>
                <div class="<?php if($data->values['discount_type_id'] == Model_DiscountType::DISCOUNT_TYPE_GOODS){echo 'active';} ?> tab-pane" id="tab3">
                    <?php echo $siteData->globalDatas['view::shopgoods/promo'];?>
                    <div class="row record-input record-tab margin-top-15px">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Кол-во товаров / услуг
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-2">
                            <input name="shopgoods_count" type="text" class="form-control" placeholder="Кол-во товаров" value="<?php echo Arr::path($data->additionDatas, 'shopgoods_count', ''); ?>">
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
                            <input name="shopgoods_amount" type="text" class="form-control" placeholder="Общая сумма товаров / услуг" value="<?php echo Arr::path($data->additionDatas, 'shopgoods_amount', ''); ?>">
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
                <li class="<?php if($data->values['gift_type_id'] != Model_GiftType::GIFT_TYPE_BILL_DISCOUNT){echo 'active';} ?>"><a href="#tab4" data-toggle="tab" data-id="<?php echo Model_GiftType::GIFT_TYPE_BILL_COMMENT;?>">Примечание к заказу <i class="fa fa-fw fa-info text-blue"></i></a></li>
                <li class="<?php if($data->values['gift_type_id'] == Model_GiftType::GIFT_TYPE_BILL_DISCOUNT){echo 'active';} ?>"><a href="#tab5" data-toggle="tab" data-id="<?php echo Model_GiftType::GIFT_TYPE_BILL_DISCOUNT;?>">Скидка <i class="fa fa-fw fa-info text-blue"></i></a></li>
            </ul>
            <div class="tab-content">
                <div class="<?php if($data->values['gift_type_id'] != Model_GiftType::GIFT_TYPE_BILL_DISCOUNT){echo 'active';} ?> tab-pane" id="tab4">
                    <div class="row record-input record-tab">
                        <div class="col-md-3 record-title">
                            <label>
                                Примечание к заказу
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>

                        </div>
                        <div class="col-md-9">
                            <textarea name="bill_comment" placeholder="Примечание к заказу" rows="3" class="form-control"><?php echo $data->values['bill_comment'];?></textarea>
                        </div>
                    </div>
                </div>
                <div class="<?php if($data->values['gift_type_id'] == Model_GiftType::GIFT_TYPE_BILL_DISCOUNT){echo 'active';} ?> tab-pane" id="tab5">
                    <div class="row record-input record-tab">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Скидка
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input name="discount" type="text" class="form-control" placeholder="Кол-во товаров" value="<?php echo Func::getNumberStr($data->values['discount']);?>">
                        </div>
                        <div class="col-md-1" style="padding-top: 8px;">
                            <select class="form-control select2" style="width: 100%; padding-left: 4px;" name="is_percent">
                                <option <?php if($data->values['discount'] == 1){echo 'selected="selected"';}?> value="1">%</option>
                                <option <?php if($data->values['discount'] != 1){echo 'selected="selected"';}?> value="0"><?php echo trim(str_replace('{amount}', '', $siteData->currency->getSymbol()));?></option>
                            </select>
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
        <input id="gift-type" name="gift_type_id" value="<?php echo $data->values['gift_type_id']; ?>">
        <input id="promo-type" name="discount_type_id" value="<?php echo $data->values['discount_type_id']; ?>">
        <input name="data_language_id" value="<?php echo $siteData->dataLanguageID; ?>">
        <?php if($siteData->branchID > 0){ ?>
            <input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
        <?php } ?>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
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