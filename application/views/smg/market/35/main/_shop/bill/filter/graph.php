<form id="form-filter" class="box-body no-padding padding-bottom-10px">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="date">
                            Дата от
                        </label>
                        <input name="date_from" type="datetime" date-type="date" class="form-control"  value="<?php echo Helpers_DateTime::getDateFormatRus(Arr::path($siteData->urlParams, 'date_from', Helpers_DateTime::minusDays(Helpers_DateTime::getCurrentDatePHP(), 30)));?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="date">
                            Дата до
                        </label>
                        <input name="date_to" type="datetime" date-type="date" class="form-control"  value="<?php echo Helpers_DateTime::getDateFormatRus(Arr::path($siteData->urlParams, 'date_to', Helpers_DateTime::getCurrentDatePHP()));?>">
                    </div>
                </div>
                <div class="col-md-6" style="display: none">
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
                    <div class="form-group pull-left">
                        <div class="input-group" style="margin-top: 24px;">
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