<?php
foreach ($data['view::_shop/raw/storage/group/one/total']->childs as $value) {
    echo $value->str;
}
?>
<script>
    $(document).ready(function () {
        $('[data-action="add-metering"]').click(function (e) {
            e.preventDefault();

            $('#modal-metering').modal('show');

            $('#modal-metering [name="shop_raw_storage_id"]').val($(this).data('id'));
            $('#modal-metering [name="meter"]').val('');
            $('#title-metering').text($(this).data('name'));
        });

        $('#modal-metering').on('shown.bs.modal', function () {
            $('#modal-metering input').focus()
        })
    });

    $('[data-action="add-drain"]').click(function (e) {
        e.preventDefault();

        var storage = $(this).data('id');
        var isUpload = $(this).data('is_upload');
        $('#modal-add-drain').remove();
        jQuery.ajax({
            url: '<?php echo Func::getFullURL($siteData, '/shoprawstoragedrain/add'); ?>',
            data: {
                'shop_raw_storage_id': (storage),
                'is_upload': (isUpload),
            },
            type: "GET",
            success: function (data) {
                $('body').append(data);
                $('#modal-add-drain').modal('show');
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    });

    function refreshStorage(storage) {
        jQuery.ajax({
            url: '/nbc/shoprawstorage/json?id='+storage+'&_fields=*',
            data: ({}),
            type: "GET",
            success: function (data) {
                var element = $('#storage-'+storage);

                var obj = jQuery.parseJSON($.trim(data))[0];

                var percent = obj.quantity / (obj.size_meter * obj.ton_in_meter) * 100;
                element.find('.progress-bar').css('height', percent + '%');

                element.find('[data-id="percent"]').textNumber(percent, 2);
                element.find('[data-id="quantity"]').textNumber(obj.quantity, 3);
                element.find('[data-id="meter"]').textNumber(obj.meter, 3);

                if(obj.is_up == 1){
                    element.find('.right').addClass('up').removeClass('down');
                }else{
                    element.find('.right').addClass('down').removeClass('up');
                }

                $('#modal-metering').modal('hide');
                $('#modal-add-drain').modal('hide');
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    }

    function saveMetering() {
        var form = $('#modal-metering form');
        var url = form.attr('action');

        var formData = form.serialize();
        formData = formData + '&json=1';

        jQuery.ajax({
            url: url,
            data: formData,
            type: "GET",
            success: function (data) {
                var storage = $('#modal-metering form [name="shop_raw_storage_id"]').val();
                refreshStorage(storage);
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    }

    function saveAddRaw() {
        var form = $('#modal-add-drain form');
        var url = form.attr('action');

        var formData = form.serialize();
        formData = formData + '&json=1';

        jQuery.ajax({
            url: url,
            data: formData,
            type: "GET",
            success: function (data) {
                var storage = $('#modal-add-drain form [name="shop_raw_storage_id"]').val();
                refreshStorage(storage);
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    }

    function saveAddMaterial() {
        var form = $('#modal-add-drain form');
        var url = form.attr('action');

        var formData = form.serialize();
        formData = formData + '&json=1';

        jQuery.ajax({
            url: url,
            data: formData,
            type: "GET",
            success: function (data) {
                var storage = $('#modal-add-drain form [name="shop_raw_storage_id"]').val();
                refreshStorage(storage);
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    }

</script>

<div id="modal-metering" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 id="title-metering" class="modal-title">Изменить влажности</h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo Func::getFullURL($siteData, '/shoprawstoragemetering/save'); ?>" class="modal-fields">
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Кол-во метров
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input name="meter" type="text" class="form-control" placeholder="Кол-во метров">
                        </div>
                    </div>
                    <div class="modal-footer text-center">
                        <input name="shop_raw_storage_id" value="" style="display: none">
                        <button type="button" class="btn btn-primary" onclick="saveMetering();">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>