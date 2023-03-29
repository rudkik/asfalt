<form id="form-filter" class="box-body no-padding padding-bottom-10px">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-1-5">
                    <div class="form-group">
                        <label for="delivery_at_from_equally">
                            Дата доставки от
                        </label>
                        <input name="shop_bill_id/delivery_at_from_equally" type="datetime"  date-type="date"  class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus(Request_RequestParams::getParamDate('shop_bill_id/delivery_at_from_equally'));?>">
                    </div>
                </div>
                <div class="col-md-1-5">
                    <div class="form-group">
                        <label for="delivery_at_to">
                            Дата доставки до
                        </label>
                        <input name="shop_bill_id/delivery_at_to" type="datetime"  date-type="date"  class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus(Request_RequestParams::getParamDate('shop_bill_id/delivery_at_to'));?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="shop_company_id">Компания</label>
                        <select data-type="select2" id="shop_company_id" name="shop_company_id" class="form-control select2" required style="width: 100%;">
                            <?php $tmp = Request_RequestParams::getParamInt('shop_company_id'); ?>
                            <option value="-1" data-id="-1" <?php if($tmp === NULL || $tmp < 0){echo 'selected';} ?>>Выберите значение</option>
                            <?php
                            $tmp = 'data-id="'.$tmp.'"';
                            echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/company/list/list']));
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="shop_supplier_id">Поставщик</label>
                        <select data-type="select2" id="shop_supplier_id" name="shop_supplier_id" class="form-control select2" required style="width: 100%;">
                            <?php $tmp = Request_RequestParams::getParamInt('shop_supplier_id'); ?>
                            <option value="-1" data-id="-1" <?php if($tmp === NULL || $tmp < 0){echo 'selected';} ?>>Выберите значение</option>
                            <?php
                            $tmp = 'data-id="'.$tmp.'"';
                            echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/supplier/list/list']));
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="shop_source_id">Источник</label>
                        <select data-type="select2" id="shop_source_id" name="shop_source_id" class="form-control select2" required style="width: 100%;">
                            <?php $tmp = Request_RequestParams::getParamInt('shop_source_id'); ?>
                            <option value="-1" data-id="-1" <?php if($tmp === NULL || $tmp < 0){echo 'selected';} ?>>Выберите значение</option>
                            <?php
                            $tmp = 'data-id="'.$tmp.'"';
                            echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/source/list/list']));
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="is_receive">Есть накладные</label>
                        <select data-type="select2" id="is_not_receive" name="is_not_receive" class="form-control select2" style="width: 100%;">
                            <?php $tmp = Request_RequestParams::getParamBoolean('is_not_receive'); ?>
                            <option value="" data-id="">Все</option>
                            <option value="1" data-id="1" <?php if($tmp === true){echo 'selected';} ?>>Без накладных</option>
                            <option value="0" data-id="0" <?php if($tmp === false){echo 'selected';} ?>>С накладными</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-8">
                    <div hidden>
                        <?php if($siteData->branchID > 0){ ?>
                            <input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
                        <?php } ?>

                        <?php if(Arr::path($siteData->urlParams, 'is_public', '') == 1){?>
                            <input id="input-status" name="is_public" value="1">
                        <?php }elseif(Arr::path($siteData->urlParams, 'is_not_public', '') == 1){?>
                            <input id="input-status" name="is_not_public" value="1">
                        <?php }elseif(Arr::path($siteData->urlParams, 'is_delete', '') == 1){?>
                            <input id="input-status" name="is_delete" value="1">
                        <?php }else{?>
                            <input id="input-status" name="" value="1">
                        <?php }?>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group pull-right">
                        <label for="input-limit-page">Кол-во записей</label>
                        <div class="input-group" style="min-width: 150px;">
                            <select data-type="select2" id="input-limit-page" name="limit_page" class="form-control select2" style="width: 100%">
                                <?php $tmp = Request_RequestParams::getParamInt('limit_page'); ?>
                                <option value="25" <?php if(($tmp === NULL) || ($tmp == 25)){echo 'selected';} ?>>25</option>
                                <option value="50" <?php if($tmp == 50){echo 'selected';} ?>>50</option>
                                <option value="100" <?php if($tmp == 100){echo 'selected';} ?>>100</option>
                                <option value="200" <?php if($tmp == 200){echo 'selected';} ?>>200</option>
                                <option value="500" <?php if($tmp == 500){echo 'selected';} ?>>500</option>
                                <option value="1000" <?php if($tmp == 1000){echo 'selected';} ?>>1000</option>
                                <option value="5000" <?php if($tmp == 5000){echo 'selected';} ?>>5000</option>
                            </select>
                            <span class="input-group-btn">
                                <button type="submit" class="btn bg-orange btn-flat"><i class="fa fa-fw fa-search"></i> Поиск</button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>