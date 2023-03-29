<form id="form-filter" class="box-body no-padding padding-bottom-10px">
		<div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <label for="shop_branch_id">Филиал</label>
                    <select id="shop_branch_id" name="shop_branch_id" class="form-control select2" style="width: 100%;">
                        <?php
                        $tmp = 'data-id="'.Request_RequestParams::getParamInt('shop_branch_id').'"';
                        echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/branch/list/list']));
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="is_own">Машины</label>
                    <select id="is_own" name="is_own" class="form-control select2" style="width: 100%;">
                        <option data-id="" value="">Выберите значение</option>
                        <option data-id="0" value="0" <?php if(Request_RequestParams::getParamBoolean('is_own') === false){ ?> selected<?php } ?>>Наемные</option>
                        <option data-id="1" value="1" <?php if(Request_RequestParams::getParamBoolean('is_own') === true){ ?> selected<?php } ?>>Собственные </option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="shop_branch_daughter_id">Отправитель</label>
                    <select id="shop_branch_daughter_id" name="shop_branch_daughter_id" class="form-control select2" style="width: 100%;">
                        <option data-id="0" value="0">Выберите значение</option>
                        <?php
                        $tmp = 'data-id="'.Request_RequestParams::getParamInt('shop_branch_daughter_id').'"';
                        echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/branch/list/list']));
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="shop_daughter_id">Поставщик</label>
                    <select id="shop_daughter_id" name="shop_daughter_id" class="form-control select2" style="width: 100%;">
                        <option data-id="0" value="0">Выберите значение</option>
                        <?php
                        $tmp = 'data-id="'.Request_RequestParams::getParamInt('shop_daughter_id').'"';
                        echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/daughter/list/list']));
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-1">
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
</form>
<script>
    function _initDaughter(elements) {
        elements.on('change', function(){
            if($(this).val() > 0) {
                $('#shop_branch_daughter_id').val(0).trigger('change');
            }
        });
    }

    function _initBranchDaughter(elements) {
        elements.on('change', function(){
            if($(this).val() > 0) {
                $('#shop_daughter_id').val(0).trigger('change');
            }
        });
    }

    $(document).ready(function () {
        _initDaughter($('#shop_daughter_id'));
        _initBranchDaughter($('#shop_branch_daughter_id'));
    });
</script>