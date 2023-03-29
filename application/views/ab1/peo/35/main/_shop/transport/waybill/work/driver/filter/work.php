<form id="form-filter" class="box-body no-padding padding-bottom-10px">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="shop_transport_company_id">Водитель</label>
                        <select id="shop_transport_driver_id" name="shop_transport_driver_id" class="form-control select2" required style="width: 100%;">
                            <?php $tmp = Request_RequestParams::getParamInt('shop_transport_driver_id'); ?>
                            <option value="-1" data-id="-1" <?php if($tmp === NULL || $tmp < 0){echo 'selected';} ?>>Выберите значение</option>
                            <?php
                            $tmp = 'data-id="'.$tmp.'"';
                            echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/transport/driver/list/list']));
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-1-5">
                    <div class="form-group">
                        <label for="date_from_equally">Дата въезда от</label>
                        <input name="shop_transport_waybill_id/to_at_from_equally" type="datetime"  date-type="date"  class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus(Request_RequestParams::getParamStr('shop_transport_waybill_id/to_at_from_equally'));?>">
                    </div>
                </div>
                <div class="col-md-1-5">
                    <div class="form-group">
                        <label for="date_to">Дата въезда до</label>
                        <input name="shop_transport_waybill_id/to_at_to" type="datetime"  date-type="date"  class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus(Request_RequestParams::getParamStr('shop_transport_waybill_id/to_at_to'));?>">
                    </div>
                </div>
                <div class="col-md-5">
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
                        <label for="input-limit-page"></label>
                        <div class="input-group">
                            <button type="submit" class="btn bg-orange btn-flat"><i class="fa fa-fw fa-search"></i> Поиск</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>