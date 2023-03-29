<?php $isAllBranch = Request_RequestParams::getParamBoolean('is_all_branch'); ?>
<form id="form-filter" class="box-body no-padding padding-bottom-10px">
	<div class="col-md-12">
		<div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <label for="shop_branch_id">Филиал</label>
                    <select id="shop_branch_id" name="shop_branch_id" class="form-control select2" style="width: 100%;">
                        <?php
                        $tmp = 'data-id="' . Request_RequestParams::getParamInt('shop_branch_id') . '"';
                        echo trim(str_replace($tmp, $tmp . ' selected', $siteData->replaceDatas['view::_shop/branch/list/list'].'<option value="-1" data-id="-1">Все филиалы</option>'));
                        ?>
                    </select>
                </div>
            </div>
            <?php
            $shopClientID = Request_RequestParams::getParamInt('shop_client_id');
            if($shopClientID !== NULL){?>
                <div class="col-md-3">
                    <div class="form-group"  style="margin-bottom: 5px">
                        <label for="shop_client_id">Клиент</label>
                        <select data-action="shop_client" data-basic-url="owner" data-action-select2="1" data-value="<?php echo Request_RequestParams::getParamInt('shop_client_id');?>"
                                id="shop_client_id" name="shop_client_id" class="form-control select2" style="width: 100%">
                        </select>
                    </div>
                </div>
            <?php }?>
            <?php
            $shopStorageID = Request_RequestParams::getParamInt('shop_storage_id');
            if($shopStorageID !== NULL){?>
                <div class="col-md-3">
                    <div class="form-group"  style="margin-bottom: 5px">
                        <label for="shop_storage_id">Склад</label>
                        <select id="shop_storage_id" name="shop_storage_id" class="form-control select2" style="width: 100%;" onchange="this.form.submit()">
                            <?php $tmp = $shopStorageID; ?>
                            <option value="-1" data-id="-1" <?php if($tmp === NULL || $tmp < 0){echo 'selected';} ?>></option>
                            <option value="0" data-id="0" <?php if($tmp == 0 && $tmp !== NULL){echo 'selected';} ?>>Без значения</option>
                            <?php
                            $tmp = 'data-id="'.$tmp.'"';
                            echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/storage/list/list']));
                            ?>
                        </select>
                    </div>
                </div>
            <?php }?>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="shop_product_rubric_id">Рубрика</label>
                    <select id="shop_product_rubric_id" name="shop_product_rubric_id" class="form-control select2" style="width: 100%;">
                        <?php $tmp = Request_RequestParams::getParamInt('shop_product_rubric_id'); ?>
                        <option value="-1" data-id="-1" <?php if($tmp === NULL || $tmp < 0){echo 'selected';} ?>></option>
                        <option value="0" data-id="0" <?php if($tmp == 0 && $tmp !== NULL){echo 'selected';} ?>>Без значения</option>
                        <?php
                        $tmp = 'data-id="'.$tmp.'"';
                        echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/product/rubric/list/list']));
                        ?>
                    </select>
                </div>
            </div>
            <?php
            if($shopClientID === NULL && $shopStorageID === NULL) {
                $class = 'class="col-md-6"';
            }elseif($shopClientID !== NULL || $shopStorageID !== NULL) {
                $class = 'class="col-md-3"';
            }else{
                $class = 'style="display: none;"';
            }
            ?>
            <div <?php echo $class; ?>>
                <div hidden>
                    <?php if($siteData->branchID > 0){ ?>
                        <input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
                    <?php } ?>
                    <input name="is_charity" value="<?php echo Request_RequestParams::getParamBoolean('is_charity'); ?>">

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
                    <button type="submit" class="btn bg-orange btn-flat" style="margin-top: 25px;"><i class="fa fa-fw fa-search"></i> Найти</button>
                </div>
            </div>
		</div>
	</div>
</form>