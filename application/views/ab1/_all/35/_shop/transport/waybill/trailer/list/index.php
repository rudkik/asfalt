<?php $isShow = (Request_RequestParams::getParamBoolean('is_show')) && !$siteData->operation->getIsAdmin(); ?>
<input name="shop_transport_waybill_trailers[_zero_]" value="" style="display: none">
<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th>Прицеп/механизм</th>
        <?php if(!$isShow){ ?>
        <th class="width-90"></th>
        <?php } ?>
    </tr>
    <tbody id="trailers">
    <?php
    foreach ($data['view::_shop/transport/waybill/trailer/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>
    </tbody>
</table>
<?php if(!$isShow){ ?>
<div class="modal-footer">
    <button type="button" class="btn btn-danger pull-left" onclick="addTrailer('new-trailer', 'trailers', true);">Добавить строчку</button>
</div>
<div id="new-trailer" data-index="0">
    <!--
    <tr data-id="trailer-n#index#">
        <td>
            <select data-id="shop_transport_id" name="shop_transport_waybill_trailers[_#index#][shop_transport_id]" class="form-control select2" style="width: 100%" required>
                <option value="0" data-id="0">Выберите значение</option>
                <?php echo $siteData->globalDatas['view::_shop/transport/list/trailer'];?>
            </select>
        </td>
        <td>
            <ul class="list-inline tr-button delete">
                <li><a href="#" data-action="remove-tr" data-parent-count="4" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            </ul>
        </td>  
    </tr>
    -->
</div>
    <script>
        function addTrailer(from, to, isLast) {
            addElement(from, to, isLast);
            var tr = $('#'+to+' > *').last();

            _initDeleteTrailer(tr.find('[data-action="remove-tr"]'));
            _initCalcTrailer(tr.find('[data-id="shop_transport_id"]'));

            tr.find('[data-id="shop_transport_id"]').trigger('change');

            __init();
        }

        function _initCalcTrailer(elements) {
            elements.on('change', function(){
                $('[name="shop_transport_id"]').trigger('change');
            });
        }

        function _initDeleteTrailer(elements) {
            // удаление записи в таблицы
            elements.click(function () {
                var tr = $(this).closest('tr');
                $('#transports [data-id="'+tr.data('id')+'"]').remove();
            });
        }

        $(document).ready(function () {
            _initCalcTrailer($('#trailers select[data-id="shop_transport_id"]'));
            _initDeleteTrailer($('#trailers [data-action="remove-tr"]'));
        });
    </script>
<?php } ?>