<?php
$time2 = Request_RequestParams::getParamDateTime('date_to');
if(empty($time2)) {
    $time2 = date('d.m.Y', strtotime('+1 day')) . ' 06:00';
}else{
    $time2 = Helpers_DateTime::getDateTimeFormatRus($time2);
}

$time1 = Request_RequestParams::getParamDateTime('date_from');
if(empty($time1)) {
    $time1 = date('d.m.Y') . ' 06:00';
}else{
    $time1 = Helpers_DateTime::getDateTimeFormatRus($time1);
}
?>
<form id="form-filter" class="box-body no-padding padding-bottom-10px">
	<div class="row">
	<div class="col-md-12">
		<div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <label for="date_from">Период от</label>
                    <div class="input-group">
                        <div class="input-group-btn">
                            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/ttn', array(),
                                array(
                                    'date_from' => date('Y-m-d', strtotime($time1 . ' -1 day')).' 06:00:00',
                                    'date_to' => date('Y-m-d', strtotime($time2 . ' -1 day')).' 06:00:00',
                                )); ?>" class="btn btn-success btn-flat"><i class="fa  fa-angle-left"></i></a>
                        </div>
                        <input id="date_from" class="form-control" name="date_from" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="date_to">Период до</label>
                    <div class="input-group">
                        <input id="date_to" class="form-control" name="date_to" type="datetime" date-type="datetime" value="<?php echo $time2; ?>">
                        <div class="input-group-btn">
                            <a href="<?php echo Func::getFullURL($siteData, '/shopcar/ttn', array(),
                                array(
                                    'date_from' => date('Y-m-d', strtotime($time1 . ' +1 day')).' 06:00:00',
                                    'date_to' => date('Y-m-d', strtotime($time2 . ' +1 day')).' 06:00:00',
                                )); ?>" class="btn btn-success btn-flat"><i class="fa  fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group"  style="margin-bottom: 5px">
                    <label for="shop_client_id">Клиент</label>
                    <select data-action="shop_client" data-basic-url="<?php echo $siteData->actionURLName;?>" data-action-select2="1" data-value="<?php echo Request_RequestParams::getParamInt('shop_client_id');?>"
                            id="shop_client_id" name="shop_client_id" class="form-control select2" style="width: 100%">
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group" style="margin-bottom: 5px">
                    <label for="shop_branch_daughter_receiver_id">Филиал</label>
                    <select id="shop_branch_daughter_receiver_id" name="shop_branch_daughter_receiver_id" class="form-control select2" style="width: 100%;">
                        <?php $tmp = Request_RequestParams::getParamInt('shop_branch_daughter_receiver_id'); ?>
                        <option value="-1" data-id="-1" <?php if($tmp === NULL || $tmp < 0){echo 'selected';} ?>>Выберите значение</option>
                        <?php
                        $tmp = 'data-id="'.$tmp.'"';
                        echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/branch/list/list']));
                        ?>
                    </select>
                </div>
            </div>
			<div class="col-md-2" style="display: none">
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