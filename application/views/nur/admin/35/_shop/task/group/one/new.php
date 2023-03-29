<div class="form-group">
    <label class="span-checkbox">
        <input name="is_public" value="1" checked type="checkbox" class="minimal">
        Активная группа
    </label>
</div>
<div class="form-group">
    <label for="name" class="block">Название</label>
    <input id="name" name="name" type="text" class="form-control" placeholder="Название" required>
</div>
<div class="form-group">
    <label for="shop_task_group_items" class="block">Список задач</label>
    <select name="shop_task_group_items[]" id="shop_task_group_items" class="js-example-basic-multiple" data-type="select2" multiple="multiple" style="width: 100%">
        <?php echo $siteData->globalDatas['view::_shop/task/list/list']; ?>
    </select>
</div>
<div class="text-center" style="width: 100%;">
    <button type="submit" class="btn btn-primary" style="margin-right: 10px;">Сохранить</button>
    <a href="/nur-admin/shoptaskgroup/index" class="btn btn-danger">Отменить</a>
</div>