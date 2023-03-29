<div class="body-bills">
    <div class="container">
        <h1>Менеджеры</h1>
    </div>
</div>
<div class="body-bills">
    <div class="container">
        <form method="get">
            <div class="row filter">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>ФИО</label>
                        <input id="input-name" class="form-control" name="name" placeholder="ФИО" value="<?php echo Arr::path($siteData->urlParams, 'name', '');?>" type="text">
                    </div>
                </div>
                <div class="col-md-9 margin-top-25px">
                    <div class="row filter-search">
                        <div class="col-md-7 filter-input filter-limit">
                            <div class="form-group">
                                <span for="input-limit-page"  class="col-md-7 control-label">Кол-во записей</span>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <select id="input-limit-page" name="limit_page" class="form-control select2" style="width: 100%">
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                            <option value="200">200</option>
                                            <option value="500">500</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div hidden>
                                <?php if($siteData->branchID > 0){ ?>
                                    <input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
                                <?php } ?>
                                <input name="type" value="<?php echo intval(Request_RequestParams::getParamInt('type')); ?>">
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
                            <button id="search-button" type="submit" class="btn btn-primary"><i class="fa fa-fw fa-search"></i> Поиск</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <?php echo trim($data['view::shopoperations/index']); ?>
    </div>
</div>
