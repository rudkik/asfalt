<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="exampleInputEmail1">
                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                Место
            </label>
            <input tabindex="0" autofocus autocomplete="off" data-action="focus-enter" data-index="1" name="shop_table_stock_barcode" type="text" class="form-control" placeholder="Место" >
        </div>
    </div>
</div>
<?php if (((Func::isShopMenu('shopgood/stock_name?type='.Request_RequestParams::getParamInt('type'), $siteData)))){  ?>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">
                    <?php echo SitePageData::setPathReplace('type.form_data.shop_good.fields_title.stock_name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                </label>
                <div class="input-group">
                    <input tabindex="1" autocomplete="off" data-action="focus-enter" data-index="2" name="stock_names[]" type="text" class="form-control" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_good.fields_title.stock_name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>" >
                    <div class="input-group-btn">
                        <button tabindex="31" type="button" class="btn btn-primary" onclick="$('#form-save').submit();">Сохранить</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <div class="input-group">
                    <input tabindex="2" autocomplete="off" data-action="focus-enter" data-index="3" name="stock_names[]" type="text" class="form-control" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_good.fields_title.stock_name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>" >
                    <div class="input-group-btn">
                        <button tabindex="32" type="button" class="btn btn-primary" onclick="$('#form-save').submit();">Сохранить</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <div class="input-group">
                    <input tabindex="3" autocomplete="off" data-action="focus-enter" data-index="4" name="stock_names[]" type="text" class="form-control" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_good.fields_title.stock_name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>" >
                    <div class="input-group-btn">
                        <button tabindex="33" type="button" class="btn btn-primary" onclick="$('#form-save').submit();">Сохранить</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <div class="input-group">
                    <input tabindex="4" autocomplete="off" data-action="focus-enter" data-index="5" name="stock_names[]" type="text" class="form-control" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_good.fields_title.stock_name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>" >
                    <div class="input-group-btn">
                        <button tabindex="34" type="button" class="btn btn-primary" onclick="$('#form-save').submit();">Сохранить</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <div class="input-group">
                    <input tabindex="5" autocomplete="off" data-action="focus-enter" data-index="6" name="stock_names[]" type="text" class="form-control" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_good.fields_title.stock_name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>" >
                    <div class="input-group-btn">
                        <button tabindex="35" type="button" class="btn btn-primary" onclick="$('#form-save').submit();">Сохранить</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <div class="input-group">
                    <input tabindex="6" autocomplete="off" data-action="focus-enter" data-index="7" name="stock_names[]" type="text" class="form-control" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_good.fields_title.stock_name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>" >
                    <div class="input-group-btn">
                        <button tabindex="36" type="button" class="btn btn-primary" onclick="$('#form-save').submit();">Сохранить</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <div class="input-group">
                    <input tabindex="7" autocomplete="off" data-action="focus-enter" data-index="8" name="stock_names[]" type="text" class="form-control" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_good.fields_title.stock_name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>" >
                    <div class="input-group-btn">
                        <button tabindex="37" type="button" class="btn btn-primary" onclick="$('#form-save').submit();">Сохранить</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <div class="input-group">
                    <input tabindex="8" autocomplete="off" data-action="focus-enter" data-index="9" name="stock_names[]" type="text" class="form-control" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_good.fields_title.stock_name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>" >
                    <div class="input-group-btn">
                        <button tabindex="37" type="button" class="btn btn-primary" onclick="$('#form-save').submit();">Сохранить</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <div class="input-group">
                    <input tabindex="9" autocomplete="off" data-action="focus-enter" data-index="10" name="stock_names[]" type="text" class="form-control" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_good.fields_title.stock_name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>" >
                    <div class="input-group-btn">
                        <button tabindex="39" type="button" class="btn btn-primary" onclick="$('#form-save').submit();">Сохранить</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <div class="input-group">
                    <input tabindex="10" autocomplete="off" data-action="focus-enter" data-index="11" name="stock_names[]" type="text" class="form-control" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_good.fields_title.stock_name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>" >
                    <div class="input-group-btn">
                        <button tabindex="40" type="button" class="btn btn-primary" onclick="$('#form-save').submit();">Сохранить</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <div class="input-group">
                    <input tabindex="11" autocomplete="off" data-action="focus-enter" data-index="12" name="stock_names[]" type="text" class="form-control" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_good.fields_title.stock_name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>" >
                    <div class="input-group-btn">
                        <button tabindex="41" type="button" class="btn btn-primary" onclick="$('#form-save').submit();">Сохранить</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<div class="row">
    <div hidden>
        <input name="data_language_id" value="<?php echo $siteData->dataLanguageID; ?>">
        <?php if($siteData->branchID > 0){ ?>
            <input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
        <?php } ?>
        <input name="url" value="/stock_write/shopgood/stock">
        <input name="type" value="<?php echo Request_RequestParams::getParamInt('type');?>">
        <?php if($siteData->superUserID > 0){ ?>
            <input name="shop_id" value="<?php echo $siteData->shopID; ?>">
        <?php } ?>
    </div>

    <div class="modal-footer text-center">
        <button tabindex="42" type="button" class="btn btn-primary" onclick="$('#form-save').submit();">Сохранить</button>
    </div>
</div>
<script>
    $('input[data-action="focus-enter"]').keyup(function (event) {
        if ((event.which == '13') || (event.which == '10')) {
            event.preventDefault();
            $('input[data-index="'+($(this).data('index') * 1 + 1)+'"]').focus();
        }
    });
</script>