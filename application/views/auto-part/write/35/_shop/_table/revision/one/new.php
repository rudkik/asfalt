<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="exampleInputEmail1">
                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                <?php echo SitePageData::setPathReplace('type.form_data.shop_table_revision.fields_title.name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
            </label>
            <input name="name" type="text" class="form-control" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_table_revision.fields_title.name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>">
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label for="exampleInputEmail1">
                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                <?php echo SitePageData::setPathReplace('type.form_data.shop_table_revision.fields_title.shop_table_stock_id', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
            </label>
            <select id="input-rubric" name="shop_table_stock_id" class="form-control select2" style="width: 100%;">
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->replaceDatas['view::_shop/_table/stock/list/list']; ?>
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div hidden>
        <input name="data_language_id" value="<?php echo $siteData->dataLanguageID; ?>">
        <input name="id" value="<?php echo $data->id; ?>">
        <input name="goods-type" value="<?php echo intval(Request_RequestParams::getParamInt('goods-type')); ?>">
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
