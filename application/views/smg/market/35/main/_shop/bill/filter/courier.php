<form id="form-filter" class="box-body no-padding padding-bottom-10px">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="old_id">Номер</label>
                        <input id="old_id" class="form-control" name="old_id" placeholder="Номер" value="<?php echo Request_RequestParams::getParamStr('old_id');?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <?php if($siteData->operation->getShopPositionID() == 0){ ?>
                    <div class="form-group">
                        <label for="shop_source_id">Источник</label>
                        <select data-type="select2" id="shop_source_id" name="shop_source_id" class="form-control select2" required style="width: 100%;">
                            <?php $tmp = Request_RequestParams::getParamInt('shop_source_id'); ?>
                            <option value="-1" data-id="-1" <?php if($tmp === NULL || $tmp < 0){echo 'selected';} ?>>Выберите значение</option>
                            <?php
                            $tmp = 'data-id="'.$tmp.'"';
                            echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/source/list/list']));
                            ?>
                        </select>
                    </div>
                    <?php } ?>
                </div>
                <div class="col-md-3">
                    <?php if($siteData->operation->getShopPositionID() == 0){ ?>
                        <div class="form-group">
                            <label for="shop_courier_id">Курьер</label>
                            <select data-type="select2" id="shop_courier_id" name="shop_courier_id" class="form-control select2" required style="width: 100%;">
                                <?php $tmp = Request_RequestParams::getParamInt('shop_courier_id'); ?>
                                <option value="-1" data-id="-1" <?php if($tmp === NULL || $tmp < 0){echo 'selected';} ?>>Выберите значение</option>
                                <option value="0" data-id="0" <?php if($tmp === 0 || $tmp === '0'){echo 'selected';} ?>>Без значения</option>
                                <?php
                                $tmp = 'data-id="'.$tmp.'"';
                                echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/courier/list/list']));
                                ?>
                            </select>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-md-3">
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
                <div class="col-md-2 text-right">
                    <button type="submit" class="btn bg-orange btn-flat mt" style=""><i class="fa fa-fw fa-search"></i> Поиск</button>
                </div>
            </div>
        </div>
    </div>
</form>
<style>
    @media (min-width: 770px) {
        .mt {
            margin-top: 23px;
        }
    }
</style>