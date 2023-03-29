<form id="form-filter" class="box-body no-padding padding-bottom-10px">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
                        <label for="shop_client_id">Клиент</label>
                        <select data-action="shop_client" data-basic-url="<?php echo $siteData->actionURLName;?>" data-action-select2="1" data-value="<?php echo Request_RequestParams::getParamInt('shop_client_id');?>"
                                id="shop_client_id" name="shop_client_id" class="form-control select2" style="width: 100%">
                        </select>
					</div>
				</div>
                <div class="col-md-1-5">
                    <div class="form-group">
                        <label for="date_from">Период от</label>
                        <input id="date_from" class="form-control" name="date_from_equally" type="datetime" date-type="date" value="<?php echo Helpers_DateTime::getDateTimeFormatRus(Request_RequestParams::getParamDate('date_from_equally'));?>">
                    </div>
                </div>
                <div class="col-md-1-5">
                    <div class="form-group">
                        <label for="date_to">Период до</label>
                        <input id="date_to" class="form-control" name="date_to" type="datetime" date-type="date" value="<?php echo Helpers_DateTime::getDateTimeFormatRus(Request_RequestParams::getParamDate('date_to'));?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="check_type_id">Статус</label>
                        <select id="check_type_id" name="check_type_id" class="form-control select2" style="width: 100%;">
                            <option value="-1" data-id="-1">Все</option>
                            <option value="0" data-id="0">Не проверенные</option>
                            <?php echo $siteData->globalDatas['view::check-type/list/list']; ?>
                        </select>
                    </div>
                </div>
                <?php $date = Request_RequestParams::getParamDate('date'); ?>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="date">До сдачи ЭСФ</label>
                        <select id="date" name="date" class="form-control select2" style="width: 100%;">
                            <option value="">Все</option>
                            <option value="<?php echo date('Y-m-d', strtotime('-9 days')); ?>" <?php if($date == date('Y-m-d', strtotime('-9 days'))){echo 'selected';}?>>1 день</option>
                            <option value="<?php echo date('Y-m-d', strtotime('-8 days')); ?>" <?php if($date == date('Y-m-d', strtotime('-8 days'))){echo 'selected';}?>>2 дня</option>
                            <option value="<?php echo date('Y-m-d', strtotime('-7 days')); ?>" <?php if($date == date('Y-m-d', strtotime('-7 days'))){echo 'selected';}?>>3 дня</option>
                            <option value="<?php echo date('Y-m-d', strtotime('-6 days')); ?>" <?php if($date == date('Y-m-d', strtotime('-6 days'))){echo 'selected';}?>>4 дня</option>
                            <option value="<?php echo date('Y-m-d', strtotime('-5 days')); ?>" <?php if($date == date('Y-m-d', strtotime('-5 days'))){echo 'selected';}?>>5 дней</option>
                            <option value="<?php echo date('Y-m-d', strtotime('-4 days')); ?>" <?php if($date == date('Y-m-d', strtotime('-4 days'))){echo 'selected';}?>>6 дней</option>
                            <option value="<?php echo date('Y-m-d', strtotime('-3 days')); ?>" <?php if($date == date('Y-m-d', strtotime('-3 days'))){echo 'selected';}?>>7 дней</option>
                            <option value="<?php echo date('Y-m-d', strtotime('-2 days')); ?>" <?php if($date == date('Y-m-d', strtotime('-2 days'))){echo 'selected';}?>>8 дней</option>
                            <option value="<?php echo date('Y-m-d', strtotime('-1 days')); ?>" <?php if($date == date('Y-m-d', strtotime('-1 days'))){echo 'selected';}?>>9 дней</option>
                        </select>
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