<form id="form-filter" class="box-body no-padding padding-bottom-10px">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="name">Название</label>
                        <input id="name" class="form-control" name="name" placeholder="Название" value="<?php echo htmlspecialchars(Arr::path($siteData->urlParams, 'name', ''), ENT_QUOTES);?>" type="text">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="barcode_full">Штрих-код</label>
                        <input id="barcode_full" class="form-control" name="barcode_full" placeholder="Штрих-код" value="<?php echo htmlspecialchars(Arr::path($siteData->urlParams, 'barcode_full', ''), ENT_QUOTES);?>" type="text">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="shop_production_rubric_id">Рубрика</label>
                        <select data-type="select2" id="shop_production_rubric_id" name="shop_production_rubric_id" class="form-control select2" style="width: 100%;">
                            <?php $tmp = Request_RequestParams::getParamInt('shop_production_rubric_id'); ?>
                            <option value="-1" data-id="-1" <?php if($tmp === NULL){echo 'selected';} ?>></option>
                            <option value="0" data-id="0" <?php if($tmp === 0){echo 'selected';} ?>>Без значения</option>
                            <?php
                            $tmp = 'data-id="'.$tmp.'"';
                            echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/production/rubric/list/list']));
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="shop_product_barcode_full">Штрих-код продукта</label>
                        <input id="shop_product_barcode_full" class="form-control" name="shop_product_barcode_full" placeholder="Штрих-код продукта" value="<?php echo htmlspecialchars(Arr::path($siteData->urlParams, 'shop_product_barcode_full', ''), ENT_QUOTES);?>" type="text">
                    </div>
                </div>
                <div class="col-md-1" style="display: none">
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
            <div class="row">
                <div class="col-md-3">
                    <label class="span-checkbox">
                        <input name="is_special" <?php if (Request_RequestParams::getParamBoolean('is_special')) { echo ' value="1" checked'; }else{echo 'value="-1"';} ?> data-id="1" type="checkbox" class="minimal">
                        Спецпродукт
                    </label>
                </div>
            </div>
        </div>
    </div>
</form>