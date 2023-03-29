<div class="col-sm-6">
    <div class="form-group">
        <label>Фамилия <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup></label>
        <input class="form-control" name="shop_client[first_name]" required placeholder="Фамилия" type="text" value="<?php echo Arr::path($data->values, 'first_name', Arr::path($data->values, 'name', '')) ?>">
    </div>
    <div class="form-group">
        <label>Имя <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup></label>
        <input class="form-control" name="shop_client[last_name]" required placeholder="Имя" type="text" value="<?php echo Arr::path($data->values, 'last_name', '') ?>">
    </div>
    <div class="form-group">
        <label>Телефон <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup></label>
        <input id="phone" class="form-control" name="shop_client[phone]" required placeholder="+7 (777) 777 77 77" type="phone" value="<?php echo Arr::path($data->values, 'phone', '') ?>">
    </div>
</div>
<script>
    $('#phone').focusout(function () {
        var s = $(this).val();
        if(s == '+_ (___) ___ __ __'){
            $(this).val('');
        }else {
            s = s.replace(/[_]/gim, '')

            if (s.length != 18) {
                $(this).val('');
            }
        }
    });
</script>
<div class="col-sm-6">
    <div class="form-group">
        <label>E-mail <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup></label>
        <input class="form-control" name="shop_client[email]" placeholder="E-mail" type="text" value="<?php echo Arr::path($data->values, 'email', '') ?>" required>
    </div>
    <input name="is_add_client" value="1" style="display: none;" >
    <input name="shop_client[id]" value="<?php echo $data->id; ?>" style="display: none;" >
