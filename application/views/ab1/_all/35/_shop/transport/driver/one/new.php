<div class="callout callout-danger" id="previous-driver" style="display: none">
    <h4>Найден данный водитель.</h4>
    <p><a target="_blank" href=""></a></p>
</div>
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
            Код 1С (табельный номер)
        </label>
    </div>
    <div class="col-md-3">
        <input name="number" type="text" class="form-control" placeholder="Код 1С">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Водитель
        </label>
    </div>
    <div class="col-md-3">
        <input id="name" name="name" type="text" class="form-control" placeholder="Водитель" required>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Работник
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_worker_id" name="shop_worker_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/worker/list/list']; ?>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Филиал
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_branch_from_id" name="shop_branch_from_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/branch/list/list']; ?>
        </select>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw"></i></sup>
            Классность
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_transport_class_id" name="shop_transport_class_id" class="form-control select2"  style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/transport/class/list/list']; ?>
        </select>
    </div>
</div>
<div class="row">
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>
<script>
    function getPreviousDriver(worker) {
        jQuery.ajax({
            url: '/<?php echo $siteData->actionURLName; ?>/shoptransportdriver/json?_fields[]=id',
            data: ({
                'shop_worker_id': (worker),
            }),
            type: "POST",
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));
                if(obj.length > 0){
                    $('#previous-driver').css('display', 'block');

                    obj = obj[0];
                    var a = $('#previous-driver').find('a');
                    a.text('Открыть').attr('href', '/<?php echo $siteData->actionURLName; ?>/shoptransportdriver/edit?id=' + obj.id);
                }else{
                    $('#previous-driver').css('display', 'none');
                }

            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    }
    $(document).ready(function () {
        $('#shop_worker_id').change(function () {
            if($(this).val() > 0){
                $('#name').val($.trim($(this).find('option:selected').text()));
            }
        });

        $('#shop_worker_id').change(function () {
            if($(this).val() > 0){
                getPreviousDriver($(this).val());
            }
        });
    });
</script>