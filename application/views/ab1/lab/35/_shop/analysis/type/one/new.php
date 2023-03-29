<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-9">
        <label class="span-checkbox">
            <input name="is_public" value="0" style="display: none;">
            <input name="is_public" value="1" checked type="checkbox" class="minimal">
            Показать
        </label>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Название
        </label>
    </div>
    <div class="col-md-9">
        <input name="name" type="text" class="form-control" placeholder="Название" required>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Поля испытания
        </label>
    </div>
    <div class="col-md-9">
        <table class="table table-hover table-db table-tr-line" >
            <tr>
                <th>Заголовок</th>
                <th>Название поля</th>
                <th>Тип поля</th>
                <th class="width-120">По умолчанию</th>
                <th class="width-100">Переменная</th>
                <th class="width-100">Количество значений</th>
                <th>Формула</th>
                <th>Список</th>
                <th class="width-90"></th>
            </tr>
            <tbody id="options">
            </tbody>
        </table>
        <div id="new-option" data-index="0">
            <!--
            <tr>
                <td>
                    <input name="options[fields][_#index#][title]" type="text" class="form-control" placeholder="Название" value="">
                </td>
                <td>
                    <input name="options[fields][_#index#][name]" type="text" class="form-control" placeholder="Название" required>
                </td>
                <td>
                    <select name="options[fields][_#index#][type]" class="form-control select2" required style="width: 100%;">
                        <option value="0" data-id="0">Без значения</option>
                        <option value="1" data-id="1">Целое число</option>
                        <option value="2" data-id="2">Вещественное число</option>
                        <option value="3" data-id="3">Многострочное значение</option>
                        <option value="4" data-id="4">Текстовое значение</option>
                        <option value="5" data-id="5">Дата</option>
                        <option value="6" data-id="6">Время</option>
                        <option value="8" data-id="8">Список</option>
                    </select>
                </td>
                <td>
                    <input name="options[fields][_#index#][default_value]" type="text" class="form-control" placeholder="Значение" >
                </td>
                <td>
                    <input name="options[fields][_#index#][variable]" type="text" class="form-control" placeholder="Переменная" >
                </td>
                <td>
                    <input name="options[fields][_#index#][quantity_value]" type="text" class="form-control" placeholder="Количество значений" >
                </td>
                <td>
                    <input name="options[fields][_#index#][formula]" type="text" class="form-control" placeholder="Формула" >
                </td>
                <td>
                    <select name="options[_#index#][table_id]" class="form-control select2">
                        <option value="0" data-id="0">Без значения</option>
                        <?php echo $siteData->globalDatas['view::table/list/list']; ?>
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
        <div class="modal-footer text-center">
            <button type="button" class="btn btn-danger" onclick="addElement('new-option', 'options', true);">Добавить поле</button>
        </div>
    </div>
</div>
<div class="row">
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>