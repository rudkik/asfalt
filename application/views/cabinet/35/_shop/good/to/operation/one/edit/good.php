<div class="row">
    <div class="col-md-9">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>
                        Товар
                        <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                    </label>
                    <select name="shop_good_id" class="form-control select2" style="width: 100%;">
                        <option value="0" data-id="0">Без значения</option>
                        <?php echo trim($siteData->globalDatas['view::_shop/good/list/list']); ?>
                    </select>
                </div>
            </div>
        </div>
        <?php echo trim($siteData->globalDatas['view::_shop/operation/list/price/good']); ?>
        <div class="row">
            <div hidden>
                <input name="data_language_id" value="<?php echo $siteData->dataLanguageID; ?>">
                <?php if($siteData->branchID > 0){ ?>
                    <input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
                <?php } ?>
                <?php if($siteData->superUserID > 0){ ?>
                    <input name="shop_id" value="<?php echo $siteData->shopID; ?>">
                <?php } ?>
            </div>

            <div class="modal-footer text-center">
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </div>
    </div>
</div>