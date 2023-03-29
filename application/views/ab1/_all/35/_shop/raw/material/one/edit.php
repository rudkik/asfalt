<?php $isShow = !$siteData->operation->getIsAdmin() && Request_RequestParams::getParamBoolean('is_show'); ?>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                Дата
            </label>
        </div>
        <div class="col-md-3">
            <input id="date" name="date" type="datetime" date-type="date" class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus($data->values['date']); ?>" required <?php if($isShow){ ?>readonly<?php } ?>>
        </div>
        <div class="col-md-3 record-title">
            <label>
                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                Кол-во сырья
            </label>
        </div>
        <div class="col-md-3">
            <input data-type="money" data-fractional-length="3" id="quantity" name="quantity" type="phone" class="form-control" placeholder="Кол-во сырья" value="<?php echo $data->values['quantity']; ?>" required>
        </div>
    </div>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                Сырье
            </label>
        </div>
        <div class="col-md-3">
            <?php if($isShow){ ?>
                <input id="shop_raw_id" name="shop_raw_id" value="<?php echo $data->values['shop_raw_id']; ?>" style="display: none">
                <select class="form-control select2" required style="width: 100%;" <?php if($isShow){ ?>disabled<?php } ?>>
                    <option value="0" data-id="0">Без значения</option>
                    <?php
                    $tmp = 'data-id="'.$data->values['shop_raw_id'].'"';
                    echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/raw/list/list']));
                    ?>
                </select>
            <?php }else{ ?>
                <select id="shop_raw_id" name="shop_raw_id" class="form-control select2" required style="width: 100%;" <?php if($isShow){ ?>disabled<?php } ?>>
                    <option value="0" data-id="0">Без значения</option>
                    <?php
                    $tmp = 'data-id="'.$data->values['shop_raw_id'].'"';
                    echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/raw/list/list']));
                    ?>
                </select>
            <?php } ?>
        </div>
        <div class="col-md-3 record-title">
            <label>
                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                Дробилка
            </label>
        </div>
        <div class="col-md-3">
            <?php if($isShow){ ?>
                <input id="shop_ballast_crusher_id" name="shop_ballast_crusher_id" value="<?php echo $data->values['shop_ballast_crusher_id']; ?>" style="display: none">
                <select name="shop_ballast_crusher_id" class="form-control select2" required style="width: 100%;" <?php if($isShow){ ?>disabled<?php } ?>>
                    <option value="0" data-id="0">Без значения</option>
                    <?php
                    $tmp = 'data-id="'.$data->values['shop_ballast_crusher_id'].'"';
                    echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/ballast/crusher/list/list']));
                    ?>
                </select>
            <?php }else{ ?>
                <select id="shop_ballast_crusher_id" name="shop_ballast_crusher_id" class="form-control select2" required style="width: 100%;" <?php if($isShow){ ?>disabled<?php } ?>>
                    <option value="0" data-id="0">Без значения</option>
                    <?php
                    $tmp = 'data-id="'.$data->values['shop_ballast_crusher_id'].'"';
                    echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/ballast/crusher/list/list']));
                    ?>
                </select>
            <?php } ?>

        </div>
    </div>
    <div id="material-items">
        <?php echo $siteData->globalDatas['view::_shop/raw/material/item/list/index'];?>
    </div>
<?php if(!$isShow){ ?>
<div class="row">
    <div hidden>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php } ?>
        <input id="is_close" name="is_close" value="1">
    </div>
    <div class="modal-footer text-center">
        <button type="button" class="btn btn-primary" onclick="submitSave('shoprawmaterial');">Сохранить</button>
        <button type="button" class="btn btn-primary" onclick="$('#is_close').val(0); submitSave('shoprawmaterial');">Применить</button>
    </div>
</div>
<script>
    function submitSave(id) {
        var isError = false;

        if(!isError) {
            $('#'+id).submit();
        }
    }


    $('#shop_raw_id, #shop_ballast_crusher_id, #date').change(function () {
        var rawID = $('#shop_raw_id').val();
        var crusherID = $('#shop_ballast_crusher_id').val();
        var date = $('#date').val();

        jQuery.ajax({
            url: '/crusher/shopballast/sum_quantity',
            data: ({
                'shop_raw_id': rawID,
                'shop_ballast_crusher_id': crusherID,
                'date': date,
            }),
            type: "POST",
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));
                if(obj.quantity > 0){
                    $('#quantity').val(obj.quantity);
                }
                jQuery.ajax({
                    url: '/crusher/shoprawmaterialitem/index',
                    data: ({
                        'shop_raw_id': rawID,
                        'shop_ballast_crusher_id': crusherID,
                        'date': date,
                    }),
                    type: "POST",
                    success: function (data) {
                        $('#material-items').html(data);
                        __initRawMaterial();
                        $('[data-id="norm"]').trigger('change');
                    },
                    error: function (data) {
                        console.log(data.responseText);
                    }
                });
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    });
    $('#quantity').change(function () {
        $('[data-id="norm"]').trigger('change');
    }).trigger('change');
</script>
<?php } ?>