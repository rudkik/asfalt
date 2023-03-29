<table class="table table-hover table-db table-tr-line" >
    <tr>
        <th class="text-right" style="width: 40px">№</th>
        <th class="tr-header-photo">Фото</th>
        <th>№ вагона</th>
        <th>Вес (т)</th>
        <th>Дата подачи</th>
        <th>Начала разгрузки</th>
        <th>Конец разгрузки</th>
        <th>№ пломбы</th>
        <th>Дата уборки</th>
        <th>№ отправки</th>
        <th style="width: 89px;"></th>
    </tr>
    <tbody id="boxcars">
    <?php
    $i = 0;
    foreach ($data['view::_shop/boxcar/one/item']->childs as $value) {
        $i++;
        echo str_replace('$index$', $i, $value->str);
    }
    ?>
    </tbody>
</table>
<div id="new-boxcar" data-index="0">
    <!--
    <tr>
        <td rowspan="3"></td>
        <td></td>
        <td>
            <input name="shop_boxcars[_#index#][number]" type="text" class="form-control" placeholder="№ вагона">
        </td>
        <td>
            <input data-type="money" data-fractional-length="3" data-id="quantity" name="shop_boxcars[_#index#][quantity]" type="text" class="form-control" placeholder="Тоннаж">
        </td>
        <td>
            <input name="shop_boxcars[_#index#][date_arrival]" type="datetime" date-type="datetime" class="form-control" placeholder="Дата подачи">
        </td>
        <td>
            <input name="shop_boxcars[_#index#][date_drain_from]" type="datetime" date-type="datetime" class="form-control" placeholder="Начало разгрузки">
        </td>
        <td>
            <input name="shop_boxcars[_#index#][date_drain_to]" type="datetime" date-type="datetime" class="form-control" placeholder="Окончания слива">
        </td>
        <td>
            <input name="shop_boxcars[_#index#][stamp]" type="text" class="form-control" placeholder="№ пломбы">
        </td>
        <td>
            <input name="shop_boxcars[_#index#][date_departure]" type="datetime" date-type="datetime" class="form-control" placeholder="Дата уборки">
        </td>
        <td>
            <input name="shop_boxcars[_#index#][sending]" type="text" class="form-control" placeholder="№ отправки">
        </td>
        <td rowspan="2">
            <ul class="list-inline tr-button delete">
                <li class="tr-remove"><a data-action="remove-tr" data-parent-count="4"  data-row="2" href="#" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            </ul>
        </td>
    </tr>
    <tr>
        <td colspan="9">
            <textarea name="shop_boxcars[_#index#][text]" class="form-control" placeholder="Примечание"></textarea>
        </td>
    </tr>
    -->
</div>
<script>
    function addBoxcar() {
        addElement('new-boxcar', 'boxcars', true);

        var tr = $('#boxcars').last();
        _initCalc(tr.find('input[data-id="quantity"]'));

        _initDelete(tr.find('li.tr-remove a'));
    }

    function _initCalc(elements) {
        elements.on('change', function(){
            var quantity = 0;
            $('#boxcars input[data-id="quantity"]').each(function (i) {
                quantity = quantity + $(this).valNumber();
            });

            $('#quantity_total').val(quantity);
        });
    }

    function _initDelete(elements) {
        // удаление записи в таблицы
        elements.click(function () {
            var element = $(this).parent().parent().parent().parent().find('input[data-id="quantity"]').attr('name');

            var quantity = 0;
            $('#boxcars input[data-id="quantity"]').each(function (i) {
                if(element != $(this).attr('name')) {
                    quantity = quantity + $(this).valNumber();
                }
            });

            $('#quantity_total').val(quantity);
        });
    }

    _initCalc($('input[data-id="quantity"]'));
    _initDelete($('#boxcars td li.tr-remove a'));

    function setOperations(trFrom, trTo) {
        var tmp = trFrom.find('[data-id="drain_zhdc_from_shop_operation_id"]').val();
        trTo.find('[data-id="drain_zhdc_from_shop_operation_id"]').val(tmp).trigger('change');

        var tmp = trFrom.find('[data-id="drain_from_shop_operation_id_1"]').val();
        trTo.find('[data-id="drain_from_shop_operation_id_1"]').val(tmp).trigger('change');

        var tmp = trFrom.find('[data-id="drain_from_shop_operation_id_2"]').val();
        trTo.find('[data-id="drain_from_shop_operation_id_2"]').val(tmp).trigger('change');

        var tmp = trFrom.find('[data-id="brigadier_drain_from_shop_operation_id"]').val();
        trTo.find('[data-id="brigadier_drain_from_shop_operation_id"]').val(tmp).trigger('change');

        var tmp = trFrom.find('[data-id="residue"]').val();
        trTo.find('[data-id="residue"]').val(tmp).trigger('change');

        var tmp = trFrom.find('[data-id="drain_to_shop_operation_id_2"]').val();
        trTo.find('[data-id="drain_to_shop_operation_id_2"]').val(tmp).trigger('change');

        var tmp = trFrom.find('[data-id="brigadier_drain_to_shop_operation_id"]').val();
        trTo.find('[data-id="brigadier_drain_to_shop_operation_id"]').val(tmp).trigger('change');

        var tmp = trFrom.find('[data-id="drain_zhdc_to_shop_operation_id"]').val();
        trTo.find('[data-id="drain_zhdc_to_shop_operation_id"]').val(tmp).trigger('change');

        var tmp = trFrom.find('[data-id="zhdc_shop_operation_id"]').val();
        trTo.find('[data-id="zhdc_shop_operation_id"]').val(tmp).trigger('change');

        var tmp = trFrom.find('[data-id="drain_to_shop_operation_id_1"]').val();
        trTo.find('[data-id="drain_to_shop_operation_id_1"]').val(tmp).trigger('change');

        var tmp = trFrom.find('[data-id="drain_to_shop_operation_id_2"]').val();
        trTo.find('[data-id="drain_to_shop_operation_id_2"]').val(tmp).trigger('change');
    }

    $('[data-action="copy-operation"]').click(function (e) {
        e.preventDefault();
        var tr = $(this).closest('tr');

        setOperations(tr, $('body'));
    });

    $('[data-action="copy-one-operation"]').click(function (e) {
        e.preventDefault();
        var tr = $(this).closest('tr');

        $('body').data('copy-tr', tr.data('index'));
    });

    $('[data-action="paste-operation"]').click(function (e) {
        e.preventDefault();

        var trFrom = $('tr[data-index="' + $('body').data('copy-tr') + '"]');
        var trTo = $(this).closest('tr');

        setOperations(trFrom, trTo);
    });
</script>