<div class="form-group">
    <label class="span-checkbox">
        <input name="is_public" value="1" checked type="checkbox" class="minimal">
        Активный пользователь
    </label>
</div>
<div class="form-group">
    <label for="name" class="block">ФИО</label>
    <input id="name" name="name" type="text" class="form-control" placeholder="ФИО" required>
</div>
<div class="form-group">
    <label for="shop_table_rubric_id" class="block">Вид оператора</label>
    <select name="shop_table_rubric_id" id="shop_table_rubric_id" class="js-example-basic-single" data-type="select2" style="width: 100%">
        <option>Выберите вид оператора</option>
        <?php echo $siteData->globalDatas['view::_shop/_table/rubric/list/list']; ?>
    </select>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="name" class="block">E-mail</label>
            <input name="email" data-validation="length" data-validation-length="max250" maxlength="250" class="form-control" placeholder="E-mail" id="email" type="email">
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="name" class="block">Пароль</label>
            <input name="password" class="form-control" placeholder="Пароль" id="password" type="password">
        </div>
    </div>
</div>
<div class="text-center" style="width: 100%">
    <button type="submit" class="btn btn-primary" style="margin-right: 10px;">Сохранить</button>
    <a href="/nur-bookkeeping/shopoperation/index" class="btn btn-danger">Отменить</a>
</div>