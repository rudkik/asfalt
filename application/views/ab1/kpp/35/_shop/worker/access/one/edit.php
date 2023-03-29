<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Доступ
        </label>
    </div>
    <div class="col-md-3">
        <label class="span-checkbox">
            <input name="access" <?php if ($data->values['access'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
        </label>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            № карточки
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_card_id" name="shop_card_id" class="form-control select2" style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
           <?php echo $siteData->globalDatas['view::_shop/card/list/list']; ?>
        </select>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Работник
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_worker_id" name="shop_worker_id" class="form-control select2" style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/worker/list/list']; ?>
        </select>
    </div>
</div>
<div class="row">
    <div hidden>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php } ?>
    </div>
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>

<script type="text/javascript">
    $('#shop_card_id').change(function () {
        if($(this).val() != 0){
            $('#shop_worker_id').val(0).trigger('change');
        }
    });
    $('#shop_worker_id').change(function () {
        if($(this).val() != 0){
            $('#shop_card_id').val(0).trigger('change');
        }
    });
</script>