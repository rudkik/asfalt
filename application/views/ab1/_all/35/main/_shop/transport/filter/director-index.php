<form id="form-filter" class="box-body no-padding padding-bottom-10px">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="shop_branch_id">Филиал</label>
                        <select id="shop_branch_id" name="shop_branch_id" class="form-control select2" style="width: 100%;">
                            <?php
                            $tmp = 'data-id="' . Request_RequestParams::getParamInt('shop_branch_id') . '"';
                            echo trim(str_replace($tmp, $tmp . ' selected', $siteData->replaceDatas['view::_shop/branch/list/list'].'<option value="-1" data-id="-1">Все филиалы</option>'));
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="transport_view_id">Вид транспорта</label>
                        <select id="transport_view_id" name="shop_transport_mark_id/transport_view_id" class="form-control select2" required style="width: 100%;">
                            <?php $tmp = Request_RequestParams::getParamInt('shop_transport_mark_id/transport_view_id'); ?>
                            <option value="-1" data-id="-1" <?php if($tmp === NULL || $tmp < 0){echo 'selected';} ?>>Выберите значение</option>
                            <?php
                            $tmp = 'data-id="'.$tmp.'"';
                            echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::transport/view/list/list']));
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="transport_work_id">Вид работ</label>
                        <select id="transport_work_id" name="shop_transport_mark_id/transport_work_id" class="form-control select2" required style="width: 100%;">
                            <?php $tmp = Request_RequestParams::getParamInt('shop_transport_mark_id/transport_work_id'); ?>
                            <option value="-1" data-id="-1" <?php if($tmp === NULL || $tmp < 0){echo 'selected';} ?>>Выберите значение</option>
                            <?php
                            $tmp = 'data-id="'.$tmp.'"';
                            echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::transport/work/list/list']));
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div hidden>
                        <input id="is_all" name="is_all" value="<?php echo Request_RequestParams::getParamBoolean('is_all');?>">
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
    </div>
</form>