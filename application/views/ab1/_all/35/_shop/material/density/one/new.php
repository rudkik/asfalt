<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Дата испытания
        </label>
    </div>
    <div class="col-md-3">
        <input name="date" type="datetime" data-date="date" class="form-control" required>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Срок действия от
        </label>
    </div>
    <div class="col-md-3">
        <input name="date_from" type="datetime" data-date="date" class="form-control" required>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Срок действия до
        </label>
    </div>
    <div class="col-md-3">
        <input name="date_to" type="datetime" data-date="date" class="form-control" required>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Материал
        </label>
    </div>
    <div class="col-md-3">
        <div class="input-group">
            <select id="shop_material_id" name="shop_material_id" class="form-control select2" required style="width: 100%;">
                <option value="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/material/list/list']; ?>
            </select>
        </div>
    </div>
    <div class="col-md-3 record-title">
        <label>
            Сырье
        </label>
    </div>
    <div class="col-md-3">
        <div class="input-group">
            <select id="shop_raw_id" name="shop_raw_id" class="form-control select2" required style="width: 100%;">
                <option value="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/raw/list/list']; ?>
            </select>
        </div>
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
            Плотность
        </label>
    </div>
    <div class="col-md-3">
        <input data-type="money" name="density" type="text" class="form-control" placeholder="Плотность">
    </div>
</div>
<div class="row">
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
