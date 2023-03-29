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
                            <input name="name" type="text" class="form-control" placeholder="Название" required>
                        </div>
                    </div>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                БИН
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input name="bin" type="text" class="form-control" placeholder="БИН" maxlength="12">
                        </div>
                    </div>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                Адрес
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input name="address" type="text" class="form-control" placeholder="Адрес">
                        </div>
                    </div>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                № счета
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input name="account" type="text" class="form-control" placeholder="№ счета" maxlength="20">
                        </div>
                    </div>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                БИК
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input name="bik" type="text" class="form-control" placeholder="БИК" maxlength="12">
                        </div>
                    </div>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                Банк
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input name="bank" type="text" class="form-control" placeholder="Банк">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-primary" onclick="addNewClient('<?php echo $url; ?>')">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function addNewClient(url){
        formData = $('#dialog-supplier form').serialize();
        formData = formData + '&json=1';
        jQuery.ajax({
            url: url,
            data: formData,
            type: "POST",
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));
                if(!obj.error){
                    var name = obj.values.name;
                    if(obj.values.bin != ''){
                        name = name+' - '+obj.values.bin;
                    }

                    supplier = $('#shop_supplier_id');
                    supplier.data('amount', 0);
                    supplier.val(obj.values.id);
                    supplier.attr('value', obj.values.id).trigger("change");
                    $('#shop_supplier_name').val(obj.values.name + ' - '+obj.values.bin);
                    $('#shop_supplier_name').attr('value', obj.values.name + ' - '+obj.values.bin);
                    $('#dialog-supplier').modal('hide');
                }
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    }
</script>