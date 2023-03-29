<form id="form-filter" class="box-body no-padding padding-bottom-10px">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
                <div class="col-md-1-5">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Период от</label>
                        <div class="input-group" style="width: 100%;">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input class="form-control pull-right" type="datetime" date-type="date" name="created_at_from_equally" value="<?php echo Arr::path($siteData->urlParams, 'created_at_from', '');?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-1-5">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Период до</label>
                        <div class="input-group" style="width: 100%;">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input class="form-control pull-right" type="datetime" date-type="date" name="created_at_to_equally" value="<?php echo Arr::path($siteData->urlParams, 'created_at_to', '');?>">
                            </div>
                        </div>
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
				<div class="col-md-2">
					<div class="form-group">
						<label for="exampleInputEmail1">№ счета</label>
                        <input id="input-name" class="form-control" name="number" placeholder="№ счета" maxlength="20" value="<?php echo htmlspecialchars(Arr::path($siteData->urlParams, 'number', ''), ENT_QUOTES);?>" type="text">
					</div>
				</div>
                <div class="col-md-2">
                    <div class="form-group">
                        <?php $tmp = Request_RequestParams::getParamInt('shop_cashbox_id'); ?>
                        <label for="shop_cashbox_id">Касса</label>
                        <select id="shop_cashbox_id" name="shop_cashbox_id" class="form-control select2" style="width: 100%;">
                            <option value="0" data-id="0" <?php if($tmp === 0){echo 'selected';} ?>>Без значения</option>
                            <?php
                            $tmp = 'data-id="'.$tmp.'"';
                            echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/cashbox/list/list']));
                            ?>
                        </select>
                    </div>
                </div>
            <div class="col-md-2">
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
								<button type="submit" class="btn bg-orange btn-flat"><i class="fa fa-fw fa-search"></i> Поиск</button>
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>