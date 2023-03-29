<form id="form-filter" class="box-body no-padding padding-bottom-10px">
	<div class="row">
	<div class="col-md-12">
		<div class="row">
            <div class="col-md-4">
                <div class="form-group"  style="margin-bottom: 5px">
                    <label for="shop_client_id">Клиент</label>
                    <select data-action="shop_client" data-basic-url="<?php echo $siteData->actionURLName;?>" data-action-select2="1" data-value="<?php echo Request_RequestParams::getParamInt('shop_client_id');?>"
                            id="shop_client_id" name="shop_client_id" class="form-control select2" style="width: 100%">
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="create_user_id">Кто создал?</label>
                    <select id="create_user_id" name="create_user_id" class="form-control select2" style="width: 100%;">
                        <?php $tmp = Request_RequestParams::getParamInt('create_user_id'); ?>
                        <option value="-1" data-id="-1" <?php if($tmp === NULL || $tmp < 0){echo 'selected';} ?>></option>
                        <option value="0" data-id="0" <?php if($tmp == 0 && $tmp !== NULL){echo 'selected';} ?>>Без значения</option>
                        <?php
                        $tmp = 'data-id="'.$tmp.'"';
                        echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/operation/list/user']));
                        ?>
                    </select>
                </div>
            </div>
			<div class="col-md-3">
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
                    <button type="submit" class="btn bg-orange btn-flat" style="margin-top: 28px;"><i class="fa fa-fw fa-search"></i> Поиск</button>
				</div>
			</div>
		</div>
	</div>
	</div>
</form>