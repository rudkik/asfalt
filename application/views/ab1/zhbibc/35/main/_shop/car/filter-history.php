<form id="form-filter" class="box-body no-padding padding-bottom-10px">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-1-5">
                    <div class="form-group">
                        <label for="created_at_from">Период создания от</label>
                         <input id="created_at_from" class="form-control pull-right" type="datetime" date-type="datetime" name="created_at_from" value="<?php echo Arr::path($siteData->urlParams, 'created_at_from', '');?>">
                    </div>
                </div>
                <div class="col-md-1-5">
                    <div class="form-group">
                        <label for="created_at_to">Период создания до</label>
                        <input id="created_at_to" class="form-control pull-right" type="datetime" date-type="datetime" name="created_at_to" value="<?php echo Arr::path($siteData->urlParams, 'created_at_to', '');?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="name">Номер машины</label>
                        <input id="name" class="form-control" type="text" name="name" value="<?php echo Arr::path($siteData->urlParams, 'ticket', '');?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="ticket">Талон клиента</label>
                        <input id="ticket" class="form-control" type="text" name="ticket" value="<?php echo Arr::path($siteData->urlParams, 'ticket', '');?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="shop_product_id">Продукт</label>
                        <select id="shop_product_id" name="shop_product_id" class="form-control select2" style="width: 100%;">
                            <?php $tmp = Request_RequestParams::getParamInt('shop_product_id'); ?>
                            <option value="-1" data-id="-1" <?php if($tmp === NULL){echo 'selected';} ?>></option>
                            <option value="0" data-id="0" <?php if($tmp === 0){echo 'selected';} ?>>Без значения</option>
                            <?php
                            $tmp = 'data-id="'.$tmp.'"';
                            echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/product/list/list']));
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="is_delivery">Доставка</label>
                        <select id="is_delivery" name="is_delivery" class="form-control select2" style="width: 100%;">
                            <?php $tmp = Request_RequestParams::getParamInt('is_delivery'); ?>
                            <option value="-1" data-id="-1" <?php if($tmp === NULL){echo 'selected';} ?>>Выберите доставку</option>
                            <option value="0" data-id="0" <?php if($tmp === 0){echo 'selected';} ?>>Без доставки</option>
                            <option value="1" data-id="1" <?php if($tmp === 1){echo 'selected';} ?>>С доставкой</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="shop_transport_company_id">Транспортная компания</label>
                        <select id="shop_transport_company_id" name="shop_transport_company_id" class="form-control select2" style="width: 100%;">
                            <?php $tmp = Request_RequestParams::getParamInt('shop_transport_company_id'); ?>
                            <option value="-1" data-id="-1" <?php if($tmp === NULL || $tmp < 0){echo 'selected';} ?>>Выберите компанию</option>
                            <option value="0" data-id="0" <?php if($tmp == 0 && $tmp !== NULL){echo 'selected';} ?>>Без значения</option>
                            <?php
                            $tmp = 'data-id="'.$tmp.'"';
                            echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/transport/company/list/list']));
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="shop_client_id">Клиент</label>
                        <select data-action="shop_client" data-basic-url="<?php echo $siteData->actionURLName;?>" data-action-select2="1" data-value="<?php echo Request_RequestParams::getParamInt('shop_client_id');?>"
                                id="shop_client_id" name="shop_client_id" class="form-control select2" style="width: 100%">
                        </select>
                    </div>
                </div>
                <div class="col-md-5">
                    <?php if($siteData->operation->getIsAdmin()){ ?>
                        <div class="form-group">
                            <label for="cash_operation_id">Оператор</label>
                            <select id="cash_operation_id" name="cash_operation_id" class="form-control select2" style="width: 100%;">
                                <?php $tmp = Request_RequestParams::getParamInt('cash_operation_id'); ?>
                                <option value="-1" data-id="-1" <?php if($tmp === NULL){echo 'selected';} ?>></option>
                                <option value="0" data-id="0" <?php if($tmp === 0){echo 'selected';} ?>>Без значения</option>
                                <?php
                                $tmp = 'data-id="'.$tmp.'"';
                                echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/operation/list/list']));
                                ?>
                            </select>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-md-2">
                    <div class="form-group pull-right">
                        <label for="input-limit-page">Кол-во записей</label>
                        <div class="input-group" style="width: 145px;">
                            <select id="input-limit-page" name="limit_page" class="form-control select2" style="width: 100%">
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
								<button type="submit" class="btn bg-orange btn-flat">Поиск</button>
							</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>