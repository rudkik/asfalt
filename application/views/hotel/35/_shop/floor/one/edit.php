<div id="floor-edit-record" class="modal fade bd-example-modal-lg modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 900px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Редактирование этажа</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fa fa-close"></span>
                </button>
            </div>
            <form class="has-validation-callback" action="/hotel/shopfloor/save">
                <div class="modal-body pb0">
                    <div class="container-fluid">
                        <div class="form-group row">
                            <label for="name" class="col-3 col-form-label">Название</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <input name="name" data-validation="length" data-validation-length="max250" maxlength="250" class="form-control" placeholder="Название" id="name" type="text" value="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="floor-edit-shop_building_id" class="col-3 col-form-label">Здание</label>
                            <div class="col-9">
                                <div class="form-group margin-0">
                                    <div class="input-group">
                                        <select name="shop_building_id" id="floor-edit-shop_building_id" class="form-control ks-select" data-parent="#floor-edit-record" style="width: 100%">
                                            <option value="0" data-id="0">Без здания</option>
                                            <option value="-1" data-id="-1">Новое здание</option>
                                            <?php echo $siteData->globalDatas['view::_shop/building/list/list']; ?>
                                        </select>
                                        <span class="input-group-btn">
                                        <button class="btn btn-primary" type="button" data-select="#floor-edit-shop_building_id" data-action="add-new-panel">Добавить</button>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        $view = View::factory('hotel/35/_shop/building/one/new-panel');
                        $view->siteData = $siteData;
                        $view->data = $data;
                        $view->panelID = 'floor-edit-building';
                        $view->selectID = 'floor-edit-shop_building_id';
                        echo Helpers_View::viewToStr($view);
                        ?>                        
                    </div>
                </div>
                <div class="modal-footer">
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

        $('#floor-edit-record form').on('submit', function(e){
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
                        $('#floor-edit-record').modal('hide');
                        $('#floor-data-table').bootstrapTable('updateByUniqueId', {
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

        $('#floor-edit-record form select[name="shop_building_id"]').change(function () {
            var id = $(this).val();

            if(id < 0){
                var tmp = $('#floor-edit-building');
                tmp.css('display', 'block');
                tmp.find('input[name="is_add_building"]').attr('value', 1);
            }else{
                var tmp = $('#floor-edit-building');
                tmp.css('display', 'none');
                tmp.find('input[name="is_add_building"]').attr('value', 0);
            }
        });
    });
</script>