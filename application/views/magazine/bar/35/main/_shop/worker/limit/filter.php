<form id="form-filter" class="box-body no-padding padding-bottom-10px">
	<div class="row">
	<div class="col-md-12">
		<div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="shop_worker_id">Сотрудник</label>
                    <select data-type="select2" id="shop_worker_id" name="shop_worker_id" class="form-control select2" style="width: 100%;">
                        <?php $tmp = Request_RequestParams::getParamInt('shop_worker_id'); ?>
                        <option value="-1" data-id="-1" <?php if($tmp === NULL){echo 'selected';} ?>></option>
                        <option value="0" data-id="0" <?php if($tmp === 0){echo 'selected';} ?>>Без значения</option>
                        <?php
                        $tmp = 'data-id="'.$tmp.'"';
                        echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/worker/list/list']));
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="month">Месяц</label>
                    <select id="month" name="month" class="form-control select2" data-type="select2" style="width: 100%">
                        <?php $month = Request_RequestParams::getParamInt('month'); ?>
                        <option value="" data-id="">Выберите месяц</option>
                        <option value="1" data-id="1" <?php if($month == 1){echo 'selected';} ?>>Январь</option>
                        <option value="2" data-id="2" <?php if($month == 2){echo 'selected';} ?>>Февраль</option>
                        <option value="3" data-id="3" <?php if($month == 3){echo 'selected';} ?>>Март</option>
                        <option value="4" data-id="4" <?php if($month == 4){echo 'selected';} ?>>Апрель</option>
                        <option value="5" data-id="5" <?php if($month == 5){echo 'selected';} ?>>Май</option>
                        <option value="6" data-id="6" <?php if($month == 6){echo 'selected';} ?>>Июнь</option>
                        <option value="7" data-id="7" <?php if($month == 7){echo 'selected';} ?>>Июль</option>
                        <option value="8" data-id="8" <?php if($month == 8){echo 'selected';} ?>>Август</option>
                        <option value="9" data-id="9" <?php if($month == 9){echo 'selected';} ?>>Сентябрь</option>
                        <option value="10" data-id="10" <?php if($month == 10){echo 'selected';} ?>>Октябрь</option>
                        <option value="11" data-id="11" <?php if($month == 11){echo 'selected';} ?>>Ноябрь</option>
                        <option value="12" data-id="12" <?php if($month == 12){echo 'selected';} ?>>Декабрь</option>
                    </select>
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <label for="year">Год</label>
                    <input id="year" class="form-control" name="year" placeholder="Год" value="<?php echo date('Y');?>" type="text">
                </div>
            </div>
            <div class="col-md-4">
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
                    <div class="input-group" style="min-width: 150px;">
                        <select data-type="select2" id="input-limit-page" name="limit_page" class="form-control select2" style="width: 100%">
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