<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-9">
        <label class="span-checkbox">
            <input name="is_public" value="0" style="display: none;">
            <input name="is_public" value="1" checked type="checkbox" class="minimal">
            Показать
        </label>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Название
        </label>
    </div>
    <div class="col-md-9">
        <input name="name" type="text" class="form-control" placeholder="Название" required>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Подразделение
        </label>
    </div>
    <div class="col-md-9">
        <select id="shop_subdivision_id" name="shop_subdivision_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo trim($siteData->globalDatas['view::_shop/subdivision/list/list']); ?>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Склад забора продукции
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_storage_id" name="shop_storage_id" class="form-control select2" style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
        </select>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Место забора материала
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_heap_id" name="shop_heap_id" class="form-control select2" style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Вид очереди
        </label>
    </div>
    <div class="col-md-9">
        <select id="shop_turn_type_id" name="shop_turn_type_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo trim($siteData->globalDatas['view::_shop/turn/type/list/list']); ?>
        </select>
    </div>
</div>
<div class="row">
    <div hidden>
        <input id="is_close" name="is_close" value="1" style="display: none">
    </div>
    <div class="modal-footer text-center">
        <button type="submit" class="btn bg-green" data-action="form-apply">Применить</button>
        <button type="submit" class="btn btn-primary" data-action="form-save">Сохранить</button>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#shop_subdivision_id').change(function () {
            var subdivision = $(this).val();
            if (subdivision > 0){
                jQuery.ajax({
                    url: '/<?php echo $siteData->actionURLName; ?>/shopstorage/select_options',
                    data: ({
                        'shop_subdivision_id': (subdivision)
                    }),
                    type: "GET",
                    success: function (data) {
                        $('#shop_storage_id').select2('destroy').empty().html(data).select2().val(-1);
                    },
                    error: function (data) {
                        console.log(data.responseText);
                    }
                });

                jQuery.ajax({
                    url: '/<?php echo $siteData->actionURLName; ?>/shopheap/select_options',
                    data: ({
                        'shop_subdivision_id': (subdivision)
                    }),
                    type: "GET",
                    success: function (data) {
                        $('#shop_heap_id').select2('destroy').empty().html(data).select2().val(-1);
                    },
                    error: function (data) {
                        console.log(data.responseText);
                    }
                });

            }else{
                $('#shop_storage_id').select2('destroy').empty().html('<option value="0" data-id="0">Без значения</option>').select2().val(-1);
            }
        });
    });
</script>
