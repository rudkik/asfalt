<div id="dialog-car" class="modal">
    <div class="modal-dialog" style="max-width: 600px; width: 100%">
        <form action="<?php echo Func::getFullURL($siteData, '/shopproductstorage/new', array());?>" method="get" class="modal-content">
            <div class="modal-header" style="background-color: #0097bc;color: #fff;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Добавить машину</h4>
            </div>
            <div class="modal-body">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Номер машины</label>
                                <select id="shop_car_tare_id" name="shop_car_tare_id" class="form-control select2" required style="width: 100%;">
                                    <option value="-1" data-id="-1">Без значения</option>
                                    <?php echo $siteData->globalDatas['view::_shop/car/tare/list/list']; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Тара</label>
                                <input class="form-control text-number" name="tare" placeholder="Тара" type="text" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Кол-во</label>
                                <input class="form-control text-number" name="quantity" placeholder="Кол-во" type="text" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Закрыть</button>
                <button type="submit" class="btn btn-primary pull-right">Зафиксировать</button>
            </div>
        </form>
    </div>
</div>
<script>
    $('#dialog-car #shop_car_tare_id').change(function (e) {
        $('#dialog-car [name="tare"]').attr('value', '').val('');

        var number = $(this).val();
        if(number != '') {
            jQuery.ajax({
                url: '/weighted/shopcartare/json?sort_by[name]=asc&limit=1&_fields[]=weight',
                data: ({
                    'id': number,
                }),
                type: "GET",
                success: function (data) {
                    var obj = jQuery.parseJSON($.trim(data));

                    jQuery.each(obj, function (index, value) {
                        $('#dialog-car [name="tare"]').attr('value', value.weight).val(value.weight);

                        var quantity = $('#dialog-car [name="quantity"]').attrNumber('data-value')
                            - Number(value.weight);
                        $('#dialog-car [name="quantity"]').valNumber(quantity);
                    });
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });
        }
    }).focusout(function(){
        $('#dialog-car [name="tare"]').attr('value', '').val('');

        var number = $(this).val();
        if(number != '') {
            jQuery.ajax({
                url: '/weighted/shopcartare/json?sort_by[name]=asc&limit=1&_fields[]=weight',
                data: ({
                    'id': number,
                }),
                type: "GET",
                success: function (data) {
                    var obj = jQuery.parseJSON($.trim(data));

                    jQuery.each(obj, function (index, value) {
                        $('#dialog-car [name="tare"]').attr('value', value.weight).val(value.weight);

                        var quantity = $('#dialog-car [name="quantity"]').attrNumber('data-value')
                            - Number(value.weight);
                        $('#dialog-car [name="quantity"]').valNumber(quantity);
                    });
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });
        }
    });

    $('#dialog-car').on('shown.bs.modal', function () {
        jQuery.ajax({
            url: '/weighted/data/get',
            data: ({}),
            type: "GET",
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));

                var quantity = Number(obj.weight) - $('#dialog-car [name="tare"]').valNumber();
                $('#dialog-car [name="quantity"]').valNumber(quantity).attr('data-value', obj.weight);
            },
            error: function (data) {
                console.log(data.responseText);
                alert('Ошибка запроса веса и номера машины.');
            }
        });
    });
</script>