<div class="box box-success">
	<div class="box-header with-border">
		<h3 class="box-title">Фильтр</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div>
	<form id="form-filter" class="box-body no-padding padding-b-10">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-4 filter-input">
					<div class="form-group">
						<span for="input-rubric" class="col-md-4 control-label">Товар</span>
						<div class="col-md-8">
							<div class="input-group input-group-select">
								<select id="input-rubric" name="shop_good_id" class="form-control select2" style="width: 100%;">
									<?php $tmp = Request_RequestParams::getParamInt('shop_good_id'); ?>
									<option value="-1" data-id="-1" <?php if($tmp === NULL){echo 'selected';} ?>></option>
									<option value="0" data-id="0" <?php if($tmp === 0){echo 'selected';} ?>>Без значения</option>
									<?php
									$tmp = 'data-id="'.$tmp.'"';
									echo trim(str_replace($tmp, $tmp . ' selected', $siteData->replaceDatas['view::_shop/good/list/list']));
									?>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4 filter-input">
					<div class="form-group">
						<span for="input-rubric" class="col-md-4 control-label">Менеджер</span>
						<div class="col-md-8">
							<div class="input-group input-group-select">
								<select id="input-rubric" name="shop_operation_id" class="form-control select2" style="width: 100%;">
									<?php $tmp = Request_RequestParams::getParamInt('shop_operation_id'); ?>
									<option value="-1" data-id="-1" <?php if($tmp === NULL){echo 'selected';} ?>></option>
									<option value="0" data-id="0" <?php if($tmp === 0){echo 'selected';} ?>>Без значения</option>
									<?php
									$tmp = 'data-id="'.$tmp.'"';
									echo trim(str_replace($tmp, $tmp . ' selected', $siteData->replaceDatas['view::_shop/operation/list/list']));
									?>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12 margin-t-15">
			<div class="row filter-search">
				<div class="col-md-7 filter-input filter-limit">
					<div class="form-group">
						<span for="input-limit-page"  class="col-md-7 control-label">Кол-во записей</span>
						<div class="col-md-5">
							<div class="input-group">
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
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-1">
					<div hidden>
						<?php if($siteData->branchID > 0){ ?>
							<input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
						<?php } ?>

						<?php if(Arr::path($siteData->urlParams, 'is_delete', '') == 1){?>
							<input id="input-status" name="is_delete" value="1">
						<?php }else{?>
							<input id="input-status" name="" value="1">
						<?php }?>
					</div>

					<button id="search-button" type="submit" class="btn btn-primary"><i class="fa fa-fw fa-search"></i> Поиск</button>
				</div>
			</div>
		</div>
	</form>
</div>