<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Работник
        </label>
    </div>
    <div class="col-md-3">
        <select data-type="select2" id="shop_worker_id" name="shop_worker_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/worker/list/list']; ?>
        </select>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Лимит
        </label>
    </div>
    <div class="col-md-3">
        <input name="amount" type="text" class="form-control" placeholder="Лимит">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Месяц
        </label>
    </div>
    <div class="col-md-3">
        <select id="month" name="month" class="form-control select2" data-type="select2" style="width: 100%" required>
            <option value="1" data-id="1" selected>Январь</option>
            <option value="2" data-id="2">Февраль</option>
            <option value="3" data-id="3">Март</option>
            <option value="4" data-id="4">Апрель</option>
            <option value="5" data-id="5">Май</option>
            <option value="6" data-id="6">Июнь</option>
            <option value="7" data-id="7">Июль</option>
            <option value="8" data-id="8">Август</option>
            <option value="9" data-id="9">Сентябрь</option>
            <option value="10" data-id="10">Октябрь</option>
            <option value="11" data-id="11">Ноябрь</option>
            <option value="12" data-id="12">Декабрь</option>
        </select>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Год
        </label>
    </div>
    <div class="col-md-3">
        <input name="year" type="text" class="form-control" placeholder="Год" value="<?php echo date('Y');?>" required>
    </div>
</div>
<div class="row">
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>
