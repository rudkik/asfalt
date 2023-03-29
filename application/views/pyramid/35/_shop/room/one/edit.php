<div id="room-edit-record" class="modal fade bd-example-modal-lg modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 900px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Редактирование номера</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fa fa-close"></span>
                </button>
            </div>
            <form class="has-validation-callback" action="/pyramid/shoproom/save">
                <div class="modal-body pb0">
                    <div class="container-fluid">
                        <div class="form-group row">
                            <label for="name" class="col-2 col-form-label">Название</label>
                            <div class="col-10">
                                <div class="form-group margin-0">
                                    <input name="name" data-validation="length" data-validation-length="max250" maxlength="250" class="form-control" placeholder="Название" id="name" type="text" value="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="room-edit-shop_building_id" class="col-2 col-form-label">Здание</label>
                            <div class="col-10">
                                <div class="form-group margin-0">
                                    <div class="input-group">
                                        <select name="shop_building_id" id="room-edit-shop_building_id" class="form-control ks-select" data-parent="#room-edit-record" style="width: 100%">
                                            <option value="0" data-id="0">Без здания</option>
                                            <option value="-1" data-id="-1">Новое здание</option>
                                            <?php echo $siteData->globalDatas['view::_shop/building/list/list']; ?>
                                        </select>
                                        <span class="input-group-btn">
                                        <button class="btn btn-primary" type="button" data-select="#room-edit-shop_building_id" data-action="add-new-panel">Добавить</button>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        $view = View::factory('pyramid/35/_shop/building/one/new-panel');
                        $view->siteData = $siteData;
                        $view->data = $data;
                        $view->panelID = 'room-edit-building';
                        $view->selectID = 'room-edit-shop_building_id';
                        echo Helpers_View::viewToStr($view);
                        ?>
                        <div class="form-group row">
                            <label for="room-edit-shop_floor_id" class="col-2 col-form-label">Этаж</label>
                            <div class="col-10">
                                <div class="form-group margin-0">
                                    <div class="input-group">
                                        <select name="shop_floor_id" id="room-edit-shop_floor_id" class="form-control ks-select" data-parent="#room-edit-record" style="width: 100%">
                                            <option value="0" data-id="0">Без этажа</option>
                                            <option value="-1" data-id="-1">Новый этаж</option>
                                            <?php echo $siteData->globalDatas['view::_shop/floor/list/list']; ?>
                                        </select>
                                        <span class="input-group-btn">
                                        <button class="btn btn-primary" type="button" data-select="#room-edit-shop_floor_id" data-action="add-new-panel">Добавить</button>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        $view = View::factory('pyramid/35/_shop/floor/one/new-panel');
                        $view->siteData = $siteData;
                        $view->data = $data;
                        $view->panelID = 'room-edit-floor';
                        $view->selectID = 'room-edit-shop_floor_id';
                        echo Helpers_View::viewToStr($view);
                        ?>
                        <div class="form-group row">
                            <label for="room-edit-shop_room_type_id" class="col-2 col-form-label">Группа</label>
                            <div class="col-10">
                                <div class="form-group margin-0">
                                    <div class="input-group">
                                        <select name="shop_room_type_id" id="room-edit-shop_room_type_id" class="form-control ks-select" data-parent="#room-edit-record" style="width: 100%">
                                            <option value="0" data-id="0">Без группы</option>
                                            <option value="-1" data-id="-1">Новая группа</option>
                                            <?php echo $siteData->globalDatas['view::_shop/room/type/list/list']; ?>
                                        </select>
                                        <span class="input-group-btn">
                                        <button class="btn btn-primary" type="button" data-select="#room-edit-shop_room_type_id" data-action="add-new-panel">Добавить</button>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        $view = View::factory('pyramid/35/_shop/room/type/one/new-panel');
                        $view->siteData = $siteData;
                        $view->data = $data;
                        $view->panelID = 'room-edit-room_type';
                        $view->selectID = 'room-edit-shop_room_type_id';
                        echo Helpers_View::viewToStr($view);
                        ?>
                        <div class="row">
                            <label for="price" class="col-2 col-form-label">Стоимость номера</label>
                            <div class="col-10">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group margin-0">
                                            <input name="price" class="form-control money-format" placeholder="Стоимость номера" id="price" type="text" value="<?php echo Func::getNumberStr($data->values['price'], FALSE); ?>">
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="row">
                                            <label for="price_feast" class="col-4 col-form-label">Стоимость номера в выходные дни</label>
                                            <div class="col-8">
                                                <div class="form-group margin-0">
                                                    <input name="price_feast" class="form-control money-format" placeholder="Стоимость номера в выходные и праздничные дни" id="price" type="text" value="<?php echo Func::getNumberStr($data->values['price_feast'], FALSE); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label for="number" class="col-2 col-form-label">Кол-во мест</label>
                            <div class="col-10">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group margin-0">
                                            <input name="human" class="form-control money-format valid" placeholder="Кол-во мест" id="human" type="text" value="<?php echo $data->values['human']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="row">
                                            <label for="number_extra" class="col-4 col-form-label">Кол-во доп. мест</label>
                                            <div class="col-8">
                                                <div class="form-group margin-0">
                                                    <input name="human_extra" class="form-control money-format valid" placeholder="Кол-во дополнительных мест" id="human_extra" type="text" value="<?php echo $data->values['human_extra']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label for="price_extra" class="col-2 col-form-label">Стоимость одного доп. <b>взрослого</b></label>
                            <div class="col-10">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group margin-0">
                                            <input name="price_extra" class="form-control money-format" placeholder="Стоимость одного дополнительного взрослого места" id="price_extra" type="text" value="<?php echo Func::getNumberStr($data->values['price_extra'], FALSE); ?>">
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="row">
                                            <label for="price_child" class="col-4 col-form-label money-format">Стоимость одного доп. <b>детского</b></label>
                                            <div class="col-8">
                                                <div class="form-group margin-0">
                                                    <input name="price_child" class="form-control" placeholder="Стоимость одного дополнительного детского места" id="price_child" type="text" value="<?php echo Func::getNumberStr($data->values['price_child'], FALSE); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label for="bedroom" class="col-2 col-form-label">Кол-во односпальных кроватей</b></label>
                            <div class="col-10">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group margin-0">
                                            <input name="bedroom" class="form-control money-format" placeholder="Кол-во односпальных кроватей" id="bedroom" type="text" value="<?php echo Func::getNumberStr($data->values['bedroom'], FALSE); ?>">
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="row">
                                            <label for="two_bedroom" class="col-4 col-form-label money-format">Кол-во двухспальных кроватей</b></label>
                                            <div class="col-8">
                                                <div class="form-group margin-0">
                                                    <input name="two_bedroom" class="form-control money-format" placeholder="Кол-во двухспальных кроватей" id="two_bedroom" type="text" value="<?php echo Func::getNumberStr($data->values['two_bedroom'], FALSE); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="sofa" class="col-2 col-form-label">Кол-во диванов</label>
                            <div class="col-10">
                                <div class="form-group margin-0">
                                    <input name="sofa" class="form-control money-format" placeholder="Кол-во диванов" id="sofa" type="text" value="<?php echo Func::getNumberStr($data->values['sofa'], FALSE); ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input name="data_language_id" value="<?php echo $data->values['language_id']; ?>" style="display: none1">
                    <input name="id" value="<?php echo $data->id; ?>" style="display: none">
                    <button type="button" class="btn btn-primary-outline ks-light" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        __initTable();

        $('#room-edit-record form').on('submit', function(e){
            e.preventDefault();
            var $that = $(this),
                formData = new FormData($that.get(0)); // создаем новый экземпляр объекта и передаем ему нашу форму (*)
            url = $(this).attr('action')+'?json=1';

            jQuery.ajax({
                url: url,
                data: formData,
                type: "POST",
                contentType: false, // важно - убираем форматирование данных по умолчанию
                processData: false, // важно - убираем преобразование строк по умолчанию
                success: function (data) {
                    var obj = jQuery.parseJSON($.trim(data));
                    if (!obj.error) {
                        $('#room-edit-record').modal('hide');
                        $('#room-data-table').bootstrapTable('updateByUniqueId', {
                            id: obj.values.id,
                            row: obj.values
                        });

                        $that.find('input[type="text"], textarea').val('');
                        $that.find('input[type="checkbox"]').removeAttr("checked");

                        $.notify("Запись сохранена");
                    }
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });

            return false;
        });

        $('#room-edit-record form select[name="shop_building_id"]').change(function () {
            var id = $(this).val();

            if (id > 0) {
                jQuery.ajax({
                    url: '/pyramid/shopfloor/list',
                    data: ({
                        'shop_building_id': (id),
                    }),
                    type: "POST",
                    success: function (data) {
                        var tmp = $('#room-edit-record form select[name="shop_floor_id"]');
                        var s = tmp.val();
                        tmp.html('<option value="0" data-id="0">Без этажа</option><option value="-1" data-id="1">Новый этаж</option>' + data);

                        if (s >= 0) {
                            tmp.val(0).trigger('change');
                        }else{
                            tmp.val(-1);
                        }
                    },
                    error: function (data) {
                        console.log(data.responseText);
                    }
                });
            }else{

                var tmp = $('#room-edit-record form select[name="shop_floor_id"]');
                if (tmp.val() > 0) {
                    tmp.html('<option value="0" data-id="0">Без этажа</option><option value="-1" data-id="1">Новый этаж</option>');
                    tmp.val(0).trigger('change');
                }
            }


            if(id < 0){
                var tmp = $('#room-edit-building');
                tmp.css('display', 'block');
                tmp.find('input[name="is_add_building"]').attr('value', 1);
            }else{
                var tmp = $('#room-edit-building');
                tmp.css('display', 'none');
                tmp.find('input[name="is_add_building"]').attr('value', 0);
            }
        });

        $('#room-edit-record form select[name="shop_floor_id"]').change(function () {
            var id = $(this).val();

            if(id < 0){
                var tmp = $('#room-edit-floor');
                tmp.css('display', 'block');
                tmp.find('input[name="is_add_floor"]').attr('value', 1);
            }else{
                var tmp = $('#room-edit-floor');
                tmp.css('display', 'none');
                tmp.find('input[name="is_add_floor"]').attr('value', 0);
            }
        });

        $('#room-edit-record form select[name="shop_room_type_id"]').change(function () {
            var id = $(this).val();

            if(id < 0){
                var tmp = $('#room-edit-room_type');
                tmp.css('display', 'block');
                tmp.find('input[name="is_add_room_type"]').attr('value', 1);
            }else{
                var tmp = $('#room-edit-room_type');
                tmp.css('display', 'none');
                tmp.find('input[name="is_add_room_type"]').attr('value', 0);
            }
        });
    });
</script>