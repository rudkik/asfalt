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
            <div class="col-md-3">
                <label for="shop_worker_id">Сотрудник</label>
                <select data-type="select2" id="shop_worker_id" name="shop_worker_id" class="form-control select2" required style="width: 100%;">
                    <option value="-1" data-id="-1">Выберите сотрудника</option>
                    <?php
                    $tmp = 'data-id="' . Request_RequestParams::getParamInt('shop_worker_id') . '"';
                    echo trim(str_replace($tmp, $tmp . ' selected', $siteData->replaceDatas['view::_shop/worker/list/list']));
                    ?>
                </select>
            </div>
            <div class="col-md-5">
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