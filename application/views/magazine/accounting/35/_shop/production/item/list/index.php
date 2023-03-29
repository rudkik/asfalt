<input name="shop_production_items[]" style="display: none" value="">
<table class="table table-hover table-db table-tr-line" data-action="table-select">
    <tr class="bg-light-blue-active">
        <th class="width-30 text-right">№</th>
        <th style="width: 50%">Продукт</th>
        <th style="width: 50%">Продукция</th>
        <th class="tr-header-amount text-right" style="width: 108px;">Коэффициент</th>
        <th style="width: 64px;"></th>
    </tr>
    <tbody id="products">
    <?php
    $i = 0;
    foreach ($data['view::_shop/production/item/one/index']->childs as $value) {
        $i++;
        echo str_replace('$index$', $i, $value->str);
    }
    ?>
    </tbody>
</table>
<div id="new-product" data-index="0">
    <!--
    <tr>
        <td data-id="index" class="text-right"></td>
        <td>
             <select data-id="shop_product_id" data-type="select2" name="shop_production_items[#index#][shop_product_id]" class="form-control select2" required style="width: 100%;">
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/product/list/list']; ?>
            </select>
        </td>
        <td>
             <select data-id="shop_production_id" data-type="select2" name="shop_production_items[#index#][shop_production_id]" class="form-control select2" required style="width: 100%;">
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::_shop/production/list/list']; ?>
            </select>
        </td>
        <td class="text-right">
        <input data-id="shop_production_id" data-type="select2" name="shop_production_items[#index#][coefficient]" type="text" class="form-control" placeholder="Коэффициент" required value="1">
        </td>
        <td class="text-center">
            <ul class="list-inline tr-button delete">
                <li class="tr-remove"><a data-action="remove-tr" data-parent-count="4" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            </ul>
        </td>
    </tr>
    -->
</div>

<script>
    function _initProduct(elements) {
        elements.on('change', function(){
            var parent = $(this).parent().parent();
            if($(this).val() > 0) {
                parent.find('select[data-id="shop_production_id"]').val(0).trigger('change');
            }
        });
    }

    function _initProduction(elements) {
        elements.on('change', function(){
            var parent = $(this).parent().parent();
            if($(this).val() > 0) {
                parent.find('select[data-id="shop_product_id"]').val(0).trigger('change');
            }
        });
    }

    function addProduction(from, to, isLast) {
        addElement(from, to, isLast);

        var tr = $('#products').last();
        _initProduct(tr.find('select[data-id="shop_product_id"]'));
        _initProduction(tr.find('select[data-id="shop_production_id"]'));
    }
</script>