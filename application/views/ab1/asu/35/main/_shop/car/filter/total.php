<form id="form-filter" class="box-body no-padding padding-bottom-10px">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="date_from">Время от</label>
                        <div class="input-group" style="width: 100%;">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input class="form-control pull-right" type="datetime" date-type="date" name="date_from" value="<?php echo Helpers_DateTime::getDateFormatRus(Request_RequestParams::getParamDate('date_from'));?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="date_to">Время до</label>
                        <div class="input-group" style="width: 100%;">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input class="form-control pull-right" type="datetime" date-type="date" name="date_to" value="<?php echo Helpers_DateTime::getDateFormatRus(Request_RequestParams::getParamDate('date_to'));?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
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
                        <input name="is_sum" value="0">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group pull-right">
                        <label for="input-limit-page" style="color: #fff">_</label>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <button type="submit" class="btn bg-orange btn-flat" style="margin-right: 5px"><i class="fa fa-fw fa-search"></i> Поиск</button>
                              </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>