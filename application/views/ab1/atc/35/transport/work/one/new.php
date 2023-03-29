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
            Код 1С
        </label>
    </div>
    <div class="col-md-3">
        <input name="number" type="phone" class="form-control" placeholder="Код 1С">
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
            <sup><i class="fa fa-fw"></i></sup>
            Оклад
        </label>
    </div>
    <div class="col-md-3">
        <input name="salary" type="phone" data-type="money"  data-fractional-length="2" class="form-control" placeholder="Оклад" >
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw"></i></sup>
            Тариф в час
        </label>
    </div>
    <div class="col-md-3">
        <input name="salary_hour" type="phone" data-type="money" data-fractional-length="2" class="form-control" placeholder="Тариф в час">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-9">
        <h4 class="text-blue">Показатели водителя для расчета зарплаты</h4>
        <table class="table table-hover table-db table-tr-line" >
            <tr>
                <th>Параметр выработки</th>
                <th class="width-90"></th>
            </tr>
            <tbody id="to-work-drivers">
            </tbody>
        </table>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger pull-left" onclick="addElement('new-to-work-driver', 'to-work-drivers', true);">Добавить строчку</button>
        </div>
        <div id="new-to-work-driver" data-index="0">
            <!--
            <tr>
                <td>
                    <select name="shop_transport_work_ids[]" class="form-control select2" style="width: 100%">
                        <option value="0" data-id="0">Выберите значение</option>
                        <?php echo $siteData->globalDatas['view::_shop/transport/work/list/list'];?>
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
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Формула расчета зарплаты
        </label>
    </div>
    <div class="col-md-9">
        <textarea name="formula" class="form-control" placeholder="Формула"></textarea>
        <p>
            <b>Параметры для формулы:</b>
            <a href="#" data-action="add-formula">Рейсы</a>
            <a href="#" data-action="add-formula">Расстояние</a>
            <a href="#" data-action="add-formula">Масса</a>
            <a href="#" data-action="add-formula">Расценка</a>
            <a href="#" data-action="add-formula">Коэффициент</a>
        </p>
    </div>
</div>
<div class="row">
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('[data-action="add-formula"]').click(function (e) {
            e.preventDefault();

            var el = $('[name="formula"]');
            el.val(el.val() + '' + $(this).text() + '');
        });
    });
</script>