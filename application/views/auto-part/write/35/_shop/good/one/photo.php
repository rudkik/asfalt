<?php if (((Func::isShopMenu('shopgood/stock_name?type='.Request_RequestParams::getParamInt('type'), $siteData)))){  ?>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    <?php echo SitePageData::setPathReplace('type.form_data.shop_good.fields_title.stock_name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
                </label>
                <input autofocus autocomplete="off" name="stock_name" type="text" class="form-control" placeholder="<?php echo SitePageData::setPathReplace('type.form_data.shop_good.fields_title.stock_name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>" >
            </div>
        </div>
    </div>
<?php } ?>
<div id="panel-save" style="display: none">
    <div class="row">
        <div class="modal-footer text-center">
            <button type="button" class="btn btn-primary" onclick="$('#form-save').submit();">Сохранить</button>
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
            <?php if($siteData->branchID > 0){ ?>
                <input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
            <?php } ?>
            <input name="url" value="/stock_write/shopgood/photo">
            <input name="type" value="<?php echo Request_RequestParams::getParamInt('type');?>">
            <?php if($siteData->superUserID > 0){ ?>
                <input name="shop_id" value="<?php echo $siteData->shopID; ?>">
            <?php } ?>
        </div>

        <div class="modal-footer text-center">
            <button type="button" onclick="$('#form-save').submit();" class="btn btn-primary">Сохранить</button>
        </div>
    </div>
</div>
<script>
    $('input[name="stock_name"]').keyup(function (event) {
        if ((event.ctrlKey == false) && (event.altKey == false)) {
            if ((event.which == '13') || (event.which == '10')) {
                var s = $(this).val();
                if (s != '') {
                    var element = $(this);
                    jQuery.ajax({
                        url: '/stock_write/shopgood/is_get',
                        data: ({
                            stock_name_full: (s),
                            work_type_id: (-1),
                        }),
                        type: "POST",
                        success: function (data) {
                            var obj = jQuery.parseJSON($.trim(data));
                            if (!obj.result) {
                                $('#panel-save').css('display', 'block');
                                element.attr('readonly', 'readonly');
                            } else {
                                $('#panel-save').css('display', 'none');
                                element.removeAttr('readonly');
                            }
                        },
                        error: function (data) {
                            console.log(data.responseText);
                        }
                    });
                }else{
                    $('#panel-save').css('display', 'none');
                }
            }
        }
    });
</script>
