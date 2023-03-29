<form id="form-filter" class="box-body no-padding padding-bottom-10px">
	<div class="col-md-12">
		<div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="shop_branch_id">Филиал</label>
                    <select id="shop_branch_id" name="shop_branch_id" class="form-control select2" style="width: 100%;">
                        <?php
                        $tmp = 'data-id="'.$siteData->shopID.'"';
                        echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/branch/list/list']));
                        ?>
                    </select>
                </div>
            </div>
            <?php
            $shopClientID = Request_RequestParams::getParamInt('shop_client_id');
            if($shopClientID !== NULL){?>
                <div class="col-md-3">
                    <div class="form-group"  style="margin-bottom: 5px">
                    </div>
                </div>
            <?php }?>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="shop_product_rubric_id">Рубрика</label>
                    <select id="shop_product_rubric_id" name="shop_product_rubric_id" class="form-control select2" style="width: 100%;">
                        <?php $tmp = Request_RequestParams::getParamInt('shop_product_rubric_id'); ?>
                        <option value="-1" data-id="-1" <?php if($tmp === NULL){echo 'selected';} ?>></option>
                        <option value="0" data-id="0" <?php if($tmp === 0){echo 'selected';} ?>>Без значения</option>
                        <?php
                        $tmp = 'data-id="'.$tmp.'"';
                        echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/product/rubric/list/list']));
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-<?php if($shopClientID === NULL){echo '4';}else{echo '1';}?>">
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
                    <button type="submit" class="btn bg-orange btn-flat" style="margin-top: 25px;"><i class="fa fa-fw fa-search"></i> Найти</button>
                </div>
            </div>
		</div>
	</div>
</form>