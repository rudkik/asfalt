<div id="dialog-supplier" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Добавить поставщика</h4>
            </div>
            <form action="<?php echo Func::getFullURL($siteData, '/shopsupplier/save'); ?>" method="post" >
                <div class="modal-body">
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Название
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input name="name" type="text" class="form-control" required placeholder="Название">
                        </div>
                    </div>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                БИН
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input  name="bin" type="tel" class="form-control" placeholder="БИН" maxlength="12">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-primary" onclick="addNewSupplier('<?php echo $url; ?>')">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function addSupplier() {
        var form = $('#dialog-supplier');

        form.find('[name="name"]').val('');
        form.find('[name="bin"]').val('');
        form.modal('show');
    }

    function addNewSupplier(url){
        var formData = $('#dialog-supplier form').serialize();
        formData = formData + '&json=1';
        jQuery.ajax({
            url: url,
            data: formData,
            type: "POST",
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));
                if(!obj.error){
                    var option = new Option(obj.values.name, obj.values.id);
                    option.selected = true;

                    $('#shop_supplier_id').append(option).trigger('change');
                    $('#dialog-supplier').modal('hide');
                }
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    }
</script>