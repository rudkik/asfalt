<?php
$i = 0;
foreach ($data['view::_shop/invoice/item/one/invoice']->childs as $value) {
    $i++;
    echo str_replace('#index#', $i, $value->str);
}
?>
<script>
    $('[data-action="save-invoice-price"]').on('change', function(){
        var price = Number($(this).val().replace(/[^0-9,\.]/gim,''));
        var quantity = Number($(this).data('quantity'));
        $(this).closest('tr').find('[data-id="amount"]').text(Intl.NumberFormat('ru-RU', {maximumFractionDigits: 2}).format(price * quantity).replace(',', '.'))
        jQuery.ajax({
            url: '/accounting/shopinvoice/save_item_price',
            data: ({
                shop_invoice_id: (<?php echo Request_RequestParams::getParamInt('id');?>),
                shop_invoice_item_id: ($(this).data('shop_invoice_item_id')),
                shop_production_id: ($(this).data('shop_production_id')),
                shop_product_id: ($(this).data('shop_product_id')),
                price: (price),
            }),
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
    });
</script>
