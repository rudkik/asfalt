<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Дата
        </label>
    </div>
    <div class="col-md-3">
        <input name="date" type="datetime" data-date="date" class="form-control" value="<?php echo Helpers_DateTime::getDateFormatRus($data->values['date']); ?>" required>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Сырье
        </label>
    </div>
    <div class="col-md-3">
            <select id="shop_raw_id" name="shop_raw_id" class="form-control select2" required style="width: 100%;">
                <option value="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/raw/list/list']; ?>
            </select>
    </div>
    <div class="col-md-3 record-title">
        <label>
            Материал
        </label>
    </div>
    <div class="col-md-3">
            <select id="shop_material_id" name="shop_material_id" class="form-control select2" required style="width: 100%;">
                <option value="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/material/list/list']; ?>
            </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Филиал
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_branch_daughter_id" name="shop_branch_daughter_id" class="form-control select2" required style="width: 100%;">
            <option value="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/branch/list/list']; ?>
        </select>
    </div>
    <div class="col-md-3 record-title">
        <label>
            Поставщик
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_daughter_id" name="shop_daughter_id" class="form-control select2" required style="width: 100%;">
            <option value="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/daughter/list/list']; ?>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Влажность
        </label>
    </div>
    <div class="col-md-3">
        <input data-type="money" name="moisture" type="text" class="form-control" placeholder="Влажность" required value="<?php echo htmlspecialchars(Arr::path($data->values, 'moisture', ''), ENT_QUOTES);?>">
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
<script>
    $(document).ready(function () {
        $('#shop_branch_daughter_id').change(function () {
            var shop = $(this).val();
            if (shop > 0){
                $('#shop_daughter_id').val(0).trigger('change');
            }
        });

        $('#shop_daughter_id').change(function () {
            var shop = $(this).val();
            if (shop > 0){
                $('#shop_branch_daughter_id').val(0).trigger('change');
            }
        });

        $('#shop_raw_id').change(function () {
            if(Number($(this).val()) > 0) {
                $('#shop_material_id').val(0).trigger('change');
            }
        });

        $('#shop_material_id').change(function () {
            if(Number($(this).val()) > 0) {
                $('#shop_raw_id').val(0).trigger('change');
            }
        });
    });
</script>