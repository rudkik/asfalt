<div class="form-group">
    <label class="col-sm-4 control-label">ФИО</label>
    <div class="col-sm-8">
        <input name="name" class="form-control" placeholder="ФИО" type="text" value="<?php echo htmlspecialchars($data->values['name']);?>">
    </div>
</div>
<div class="form-group">
    <label class="col-sm-4 control-label">E-mail</label>
    <div class="col-sm-8">
        <input name="email" class="form-control" placeholder="E-mail" type="email" value="<?php echo htmlspecialchars($data->values['email']);?>">
    </div>
</div>
<div class="form-group">
    <label class="col-sm-4 control-label">Пароль</label>
    <div class="col-sm-8">
        <input name="password" class="form-control" placeholder="Пароль" type="password" value="">
    </div>
</div>
<div class="form-group">
    <label class="col-sm-4 control-label">Телефон</label>
    <div class="col-sm-8">
        <input name="options[phone]" class="form-control" placeholder="+7 777 777 77 77" type="phone" value="<?php echo htmlspecialchars(Arr::path($data->values, 'options.phone', ''));?>">
    </div>
</div>
<div class="col-md-12">
    <div class="btn-save">
        <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>" hidden>
        <button class="btn btn-success" type="submit">Сохранить</button>
    </div>
</div>