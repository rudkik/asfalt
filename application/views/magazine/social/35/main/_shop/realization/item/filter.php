<?php $isAllBranch = Request_RequestParams::getParamBoolean('is_all_branch'); ?>
<form id="form-filter" class="box-body no-padding padding-bottom-10px">
	<div class="col-md-12">
		<div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <label for="shop_branch_id">Точка реализации</label>
                    <select id="shop_branch_id" name="shop_branch_id" class="form-control select2" style="width: 100%;">
                        <?php
                        $tmp = 'data-id="' . Request_RequestParams::getParamInt('shop_branch_id') . '"';
                        echo trim(str_replace($tmp, $tmp . ' selected', $siteData->replaceDatas['view::_shop/branch/list/list'].'<option value="-1" data-id="-1">Все точки</option>'));
                        ?>
                    </select>
                </div>
            </div>
            <?php
            $shopWorkerID = Request_RequestParams::getParamInt('shop_worker_id');
            if($shopWorkerID !== NULL){?>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="shop_worker_id">Сотрудник</label>
                        <select data-type="select2" id="shop_worker_id" name="shop_worker_id" class="form-control select2" required style="width: 100%;">
                            <option value="-1" data-id="-1" <?php if($shopWorkerID === NULL || $shopWorkerID < 0){echo 'selected';} ?>>Выберите сотрудника</option>
                            <option value="0" data-id="0" <?php if($shopWorkerID == 0 && $shopWorkerID !== NULL){echo 'selected';} ?>>Без сотрудника</option>
                            <?php
                            $tmp = 'data-id="' . $shopWorkerID . '"';
                            echo trim(str_replace($tmp, $tmp . ' selected', $siteData->replaceDatas['view::_shop/worker/list/list']));
                            ?>
                        </select>
                    </div>
                </div>
            <?php }?>
            <?php
            $shopProductionRubricID = Request_RequestParams::getParamInt('shop_production_rubric_id');
            if($shopProductionRubricID !== NULL){?>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="shop_production_rubric_id">Выбор рубрики</label>
                        <select data-type="select2" id="shop_production_rubric_id" name="shop_production_rubric_id" class="form-control select2" required style="width: 100%;">
                            <option value="-1" data-id="-1" <?php if($shopProductionRubricID === NULL || $shopProductionRubricID < 0){echo 'selected';} ?>>Выберите рубрики</option>
                            <option value="0" data-id="0" <?php if($shopProductionRubricID == 0 && $shopProductionRubricID !== NULL){echo 'selected';} ?>>Без рубрики</option>
                            <?php
                            $tmp = 'data-id="' . $shopProductionRubricID . '"';
                            echo trim(str_replace($tmp, $tmp . ' selected', $siteData->replaceDatas['view::_shop/production/rubric/list/list']));
                            ?>
                        </select>
                    </div>
                </div>
            <?php }?>
            <?php
            if($shopWorkerID === NULL && $shopProductionRubricID === NULL) {
                $class = 'class="col-md-8"';
            }elseif($shopWorkerID !== NULL || $shopProductionRubricID !== NULL) {
                $class = 'class="col-md-5"';
            }else{
                $class = 'class="col-md-2"';
            }
            ?>
            <div <?php echo $class; ?>>
                <div hidden>
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