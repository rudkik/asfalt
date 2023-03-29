<form id="form-filter" class="box-body no-padding padding-bottom-10px">
	<div class="row">
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-2">
                <div class="form-group">
                    <label for="date">Дата</label>
                    <input id="date" class="form-control" name="date" value="<?php echo Helpers_DateTime::getDateTimeFormatRus(Arr::path($siteData->urlParams, 'date', ''));?>" type="datetime" date-type="date">
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