<div id="dialog-product" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Добавить продукт</h4>
            </div>
            <form action="<?php echo Func::getFullURL($siteData, '/shopproduct/save'); ?>" method="post" >
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
                                Штрих-код
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input  name="barcode" type="tel" class="form-control" placeholder="Штрих-код" maxlength="13">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-primary" onclick="addNewProduct('<?php echo $url; ?>')">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function addNewProduct(url){
        var formData = $('#dialog-product form').serialize();
        formData = formData + '&json=1';
        jQuery.ajax({
            url: url,
            data: formData,
            type: "POST",
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));
                if(!obj.error){
                    var tr = addElement('new-product', 'products', false);
                    tr.find('[data-id="shop_product_name"]').text(obj.values.name);
                    tr.find('[data-id="shop_product_id"]').val(obj.values.id).attr('value', obj.values.id);

                    $('#dialog-product').modal('hide');
                }
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    }
</script>