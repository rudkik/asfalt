<table class="table table-striped table-bordered table-hover">
    <tr>
        <th>Рубрика</th>
        <th>Название</th>
        <th>Значение</th>
        <th></th>
    </tr>
    <tbody id="products">
    <?php
    foreach ($data['view::_shop/product/attribute/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>
    </tbody>
</table>
<div class="modal-footer text-center">
    <button type="button" class="btn btn-danger" onclick="addProduct('new-product', 'products', true);">Добавить атрибут</button>
</div>
<div id="new-product" data-index="0">
    <!--
    <tr>
        <td data-id="rubric">

        </td>
        <td>
            <select data-type="select2" data-action="attribute_type" name="shop_product_attributes[_#index#][shop_attribute_type_id]" class="form-control select2" required style="width: 100%;" >
                <option value="0" data-id="0" data-rubric="">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/attribute/type/list/list']; ?>
            </select>
        </td>
        <td>
            <select data-type="select2" data-id="shop_attribute_id" name="shop_product_attributes[_#index#][shop_attribute_id]" class="form-control select2" required style="width: 100%;" >
                <option value="0" data-id="0" >Без значения</option>
            </select>
        </td>
        <td>
             <ul class="list-inline tr-button delete">
                <li class="tr-remove"><a data-action="remove-tr" data-parent-count="4" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            </ul>
        </td>
    </tr>
    -->
</div>
<script>
    function getAttributeType() {
        $('[data-action="attribute_type"]:not([data-select="1"])').change(function () {
            var parent = $(this).closest('tr');
            var shopAttribute = parent.find('[data-id="shop_attribute_id"]');
            var shopAttributeTypeID = $(this).val();
            var rubric = $(this).find('[value="' + shopAttributeTypeID + '"]').data('rubric');
            console.log(rubric);
            parent.find('[data-id="rubric"]').text(rubric);
            // контракт
            jQuery.ajax({
                url: '/market/shopproduct/select_options',
                data: ({
                    'shop_attribute_type_id': (shopAttributeTypeID),
                }),
                type: "POST",
                success: function (data) {
                    $(shopAttribute).empty().html('<option value="0" data-id="0">Без значения</option>' + data).select2().val(0);
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });
        }).attr('data-select', '1');
    }

    function addProduct(from, to, isLast) {
        addElement(from, to, isLast);
        getAttributeType();
    }
    $(document).ready(function () {
        getAttributeType();
    });
</script>