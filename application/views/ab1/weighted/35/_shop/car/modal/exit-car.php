<div id="dialog-exit-car" class="modal">
    <div class="modal-dialog" style="max-width: 600px; width: 100%">
        <form action="<?php echo Func::getFullURL($siteData, '/shopcar/new', array());?>" method="get" class="modal-content">
            <div class="modal-header" style="background-color: #0097bc;color: #fff;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Добавить машину на выезд</h4>
            </div>
            <div class="modal-body">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="shop_turn_place_id">Место погрузки</label>
                                <select id="shop_turn_place_id" name="shop_turn_place_id" class="form-control select2" required style="width: 100%;">
                                    <option value="-1" data-id="-1">Без значения</option>
                                    <?php echo $siteData->globalDatas['view::_shop/turn/place/list/list']; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Номер машины</label>
                                <input class="form-control text-number" data-type="auto-number" name="number" placeholder="Номер машины" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Тара</label>
                                <input class="form-control text-number" name="tare" placeholder="Тара" type="text" readonly>
                            </div>
                        </div>
                    </div>
                    <input name="id" style="display: none">
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
    $('#dialog-exit-car [name="number"]').change(function (e) {
        $('#dialog-exit-car [name="tare"]').attr('value', '').val('');

        var number = $(this).val();
        if(number != '') {
            jQuery.ajax({
                url: '/weighted/shopcartare/json?sort_by[name]=asc&limit=1&_fields[]=weight',
                data: ({
                    'name': number,
                }),
                type: "GET",
                success: function (data) {
                    var obj = jQuery.parseJSON($.trim(data));

                    jQuery.each(obj, function (index, value) {
                        $('#dialog-exit-car [name="tare"]').attr('value', value.weight).val(value.weight);
                    });
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });
        }
    }).focusout(function(){
        $('#dialog-exit-car [name="tare"]').attr('value', '').val('');

        var number = $(this).val();
        if(number != '') {
            jQuery.ajax({
                url: '/weighted/shopcartare/json?sort_by[name]=asc&limit=1&_fields[]=weight',
                data: ({
                    'name': number,
                }),
                type: "GET",
                success: function (data) {
                    var obj = jQuery.parseJSON($.trim(data));

                    jQuery.each(obj, function (index, value) {
                        $('#dialog-exit-car [name="tare"]').attr('value', value.weight).val(value.weight);
                    });
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });
        }
    });
</script>