<?php if (((Func::isShopMenu('shopgood/stock_name?type='.Request_RequestParams::getParamInt('type'), $siteData)))){  ?>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    <?php echo SitePageData::setPathReplace('type.form_data.shop_good.fields_title.stock_name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                </label>
                <input name="stock_name" type="text" class="form-control" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_good.fields_title.stock_name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>" value="<?php echo $data->values['stock_name']; ?>">
            </div>
        </div>
    </div>
<?php } ?>
<div class="row">
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>
<?php if (Func::isShopMenu('shopgood/image?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
    <div class="row">
        <div class="col-md-12">
            <?php
            $view = View::factory('stock/write/35/_addition/files');
            $view->siteData = $siteData;
            $view->data = $data;
            $view->columnSize = 12;
            echo Helpers_View::viewToStr($view);
            ?>
        </div>
    </div>
<?php } ?>
<div class="row">
    <div hidden>
        <input name="data_language_id" value="<?php echo $siteData->dataLanguageID; ?>">
        <input name="id" value="<?php echo $data->id; ?>">
        <?php if($siteData->branchID > 0){ ?>
            <input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
        <?php } ?>
        <input name="type" value="<?php echo Request_RequestParams::getParamInt('type');?>">
        <?php if($siteData->superUserID > 0){ ?>
            <input name="shop_id" value="<?php echo $siteData->shopID; ?>">
        <?php } ?>
    </div>

    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>
