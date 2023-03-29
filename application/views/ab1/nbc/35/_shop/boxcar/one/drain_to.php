<div class="row">
    <div class="col-md-9">
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Поставщик
                </label>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control"value="<?php echo htmlspecialchars($data->getElementValue('shop_boxcar_client_id'), ENT_QUOTES);?>" readonly>
            </div>
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Сырье
                </label>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control"value="<?php echo htmlspecialchars($data->getElementValue('shop_raw_id'), ENT_QUOTES);?>" readonly>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    № вагона
                </label>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" placeholder="№ вагона" value="<?php echo htmlspecialchars(Arr::path($data->values, 'number', ''), ENT_QUOTES);?>" readonly>
            </div>
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Тоннаж
                </label>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" placeholder="Тоннаж" value="<?php echo htmlspecialchars(Arr::path($data->values, 'quantity', ''), ENT_QUOTES);?>" readonly>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    № пломбы
                </label>
            </div>
            <div class="col-md-3">
                <input name="stamp" type="text" class="form-control" placeholder="№ пломбы" value="<?php echo htmlspecialchars(Arr::path($data->values, 'stamp', ''), ENT_QUOTES);?>" >
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Окончания разгрузки
                </label>
            </div>
            <div class="col-md-3">
                <input name="date_drain_to" type="datetime" date-type="datetime" class="form-control" value="<?php echo Helpers_DateTime::getDateTimeFormatRus(Arr::path($data->values, 'date_drain_to', ''));?>" >
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Товарный оператор 1
                </label>
            </div>
            <div class="col-md-3">
                <select id="drain_to_shop_operation_id_1" name="drain_to_shop_operation_id_1" class="form-control select2" style="width: 100%">
                    <option data-id="0" value="0">Без значения</option>
                    <?php echo $siteData->globalDatas['view::_shop/operation/list/list_1'];?>
                </select>
            </div>
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Товарный оператор 2
                </label>
            </div>
            <div class="col-md-3">
                <select id="drain_to_shop_operation_id_2" name="drain_to_shop_operation_id_2" class="form-control select2" style="width: 100%">
                    <option data-id="0" value="0">Без значения</option>
                    <?php echo $siteData->globalDatas['view::_shop/operation/list/list_2'];?>
                </select>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                    Оператор ТУ НБЦ (Бригадир)
                </label>
            </div>
            <div class="col-md-3">
                <select id="brigadier_drain_to_shop_operation_id" name="brigadier_drain_to_shop_operation_id" class="form-control select2" style="width: 100%">
                    <option data-id="0" value="0">Без значения</option>
                    <?php echo $siteData->globalDatas['view::_shop/operation/list/brigadier'];?>
                </select>
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    Остаток в цистерне по замеру глубины Метроштоком №135 МШ 4.5 мм
                </label>
            </div>
            <div class="col-md-3">
                <input name="residue" type="text" class="form-control" placeholder="Остаток в цистерне по замеру глубины Метроштоком №135 МШ 4.5 мм" value="<?php echo htmlspecialchars(Arr::path($data->values, 'residue', ''), ENT_QUOTES);?>" >
            </div>
        </div>
        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    Примечание
                </label>
            </div>
            <div class="col-md-9">
                <textarea name="text" class="form-control" placeholder="Примечание"><?php echo htmlspecialchars(Arr::path($data->values, 'text', ''), ENT_QUOTES);?></textarea>
            </div>
        </div>

        <div class="row record-input record-list">
            <div class="col-md-3 record-title">
                <label>
                    Дополнительные файлы
                </label>
            </div>
            <div class="col-md-9">
                <input name="options[files][]" value="" style="display: none">
                <table class="table table-hover table-db table-tr-line" >
                    <tr>
                        <th>Файлы</th>
                        <th class="width-90"></th>
                    </tr>
                    <tbody id="files">
                    <?php
                    $i = -1;
                    foreach (Arr::path($data->values['options'], 'files', array()) as $file){
                        $i++;
                        if(empty($file)){
                            continue;
                        }
                        ?>
                        <tr>
                            <td>
                                <a target="_blank" href="<?php echo Arr::path($file, 'file', ''); ?>"><?php echo Arr::path($file, 'name', ''); ?></a>
                                <input name="options[files][<?php echo $i; ?>][file]" value="<?php echo Arr::path($file, 'file', ''); ?>" style="display: none">
                                <input name="options[files][<?php echo $i; ?>][name]" value="<?php echo Arr::path($file, 'name', ''); ?>" style="display: none">
                                <input name="options[files][<?php echo $i; ?>][size]" value="<?php echo Arr::path($file, 'size', ''); ?>" style="display: none">
                            </td>
                            <td>
                                <ul class="list-inline tr-button ">
                                    <li class="tr-remove"><a href="#" data-action="remove-tr" data-parent-count="4"  class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                                </ul>
                            </td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
                    <div class="modal-footer text-center">
                        <button type="button" class="btn btn-danger" onclick="addElement('new-file', 'files', true);">Добавить файл</button>
                    </div>
                    <div id="new-file" data-index="0">
                        <!--
                        <tr>
                            <td>
                                <div class="file-upload" data-text="Выберите файл" placeholder="Выберите файл">
                                    <input type="file" name="options[files][_#index#]" >
                                </div>
                            </td>
                            <td>
                                <ul class="list-inline tr-button delete">
                                    <li class="tr-remove"><a data-action="remove-tr" data-parent-count="4" href="#" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                                </ul>
                            </td>
                        </tr>
                        -->
                    </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <?php
        $view = View::factory('ab1/35/_addition/files');
        $view->siteData = $siteData;
        $view->data = $data;
        $view->columnSize = 12;
        echo Helpers_View::viewToStr($view);
        ?>
    </div>
</div>
<div class="row">
    <div hidden>
        <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
    </div>
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>