<form id="form-filter" class="box-body no-padding padding-bottom-10px">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
                <div class="col-md-1">
                    <div class="form-group">
                        <label for="name">Номер</label>
                        <input class="form-control" type="text" name="name" data-type="auto-number" value="<?php echo Arr::path($siteData->urlParams, 'name', '');?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group"  style="margin-bottom: 5px">
                        <label for="shop_client_id">Клиент</label>
                        <select data-action="shop_client" data-basic-url="<?php echo $siteData->actionURLName;?>" data-action-select2="1" data-value="<?php echo Request_RequestParams::getParamInt('shop_client_id');?>"
                                id="shop_client_id" name="shop_client_id" class="form-control select2" style="width: 100%">
                        </select>
                    </div>
                </div>
				<div class="col-md-2">
					<div class="form-group">
						<label for="shop_product_id">Продукт</label>
                        <select id="shop_product_id" name="shop_product_id" class="form-control select2" style="width: 100%;">
                            <?php $tmp = Request_RequestParams::getParamInt('shop_product_id'); ?>
                            <option value="-1" data-id="-1" <?php if($tmp === NULL || $tmp < 0){echo 'selected';} ?>></option>
                            <option value="0" data-id="0" <?php if($tmp == 0 && $tmp !== NULL){echo 'selected';} ?>>Без значения</option>
                            <?php
                            $tmp = 'data-id="'.$tmp.'"';
                            echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/product/list/list']));
                            ?>
                        </select>
					</div>
				</div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="shop_turn_place_id">Место погрузки</label>
                        <select id="shop_turn_place_id" name="shop_turn_place_id" class="form-control select2" style="width: 100%;">
                            <?php $tmp = Request_RequestParams::getParamInt('shop_turn_place_id'); ?>
                            <option value="-1" data-id="-1" <?php if($tmp === NULL || $tmp < 0){echo 'selected';} ?>></option>
                            <option value="0" data-id="0" <?php if($tmp == 0 && $tmp !== NULL){echo 'selected';} ?>>Без значения</option>
                            <?php
                            $tmp = 'data-id="'.$tmp.'"';
                            echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/turn/place/list/list']));
                            ?>
                        </select>
                    </div>
                </div>
				<div class="col-md-1-5">
					<div class="form-group">
						<label for="exampleInputEmail1">Время от</label>
						<div class="input-group" style="width: 100%;">
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</div>
								<input class="form-control pull-right" type="datetime" date-type="datetime" name="created_at_from" value="<?php echo Arr::path($siteData->urlParams, 'created_at_from', '');?>">
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-1-5">
					<div class="form-group">
						<label for="exampleInputEmail1">Время до</label>
						<div class="input-group" style="width: 100%;">
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</div>
								<input class="form-control pull-right" type="datetime" date-type="datetime" name="created_at_to" value="<?php echo Arr::path($siteData->urlParams, 'created_at_to', '');?>">
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-1" style="display: none">
					<div hidden>
						<?php if($siteData->branchID > 0){ ?>
							<input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
						<?php } ?>

						<?php if(Arr::path($siteData->urlParams, 'is_public', '') == 1){?>
							<input id="input-status" name="is_public" value="1">
						<?php }elseif(Arr::path($siteData->urlParams, 'is_not_public', '') == 1){?>
							<input id="input-status" name="is_not_public" value="1">
						<?php }elseif(Arr::path($siteData->urlParams, 'is_delete_public_ignore', '') == 1){?>
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