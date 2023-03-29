<div class="container">
    <div class="row justify-content-center no-gutters">
        <div class="col-sm-10">
            <nav class="breadcrumbs">
                <a href="<?php echo $siteData->urlBasic;?>/account" class="breadcrumbs__link">Мой аккаунт</a>
                <span class="breadcrumbs__link">Редактировать профиль</span>
            </nav>
        </div>
        <?php if(Request_RequestParams::getParamStr('save') == 'ok'){ ?>
            <div class="col-sm-11 offset-sm-1">
                <div class="alert">
                    <button class="alert__close"></button>
                    <span class="text--title alert--success">Данные успешно сохранены</span>
                </div>
            </div>
        <?php } ?>
        <div id="message-error" class="col-sm-11 offset-sm-1" style="display: none">
            <div class="alert">
                <button class="alert__close"></button>
                <span data-id="message" class="text--title alert--error">Данные успешно сохранены</span>
            </div>
        </div>
        <?php if(! Arr::path($siteData->user->getOptionsArray(), 'is_filled', FALSE)){ ?>
        <div class="col-sm-11 offset-sm-1">
            <div class="alert">
                <button class="alert__close"></button>
                <span class="text--title alert--error">
                    Для продолжения работы, необходимо заполнить все поля ниже.
                </span>
            </div>
        </div>
        <?php } ?>
        <?php if(Arr::path($siteData->user->getOptionsArray(), 'is_load_passport', FALSE)){ ?>
            <div class="col-sm-11 offset-sm-1">
                <div class="alert">
                    <button class="alert__close"></button>
                    <span class="text--title alert--error">
                    Пожалуйста, повторно загрузите удостоверение личности.
                </span>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<main>
    <form id="form-save" class="container" action="<?php echo $siteData->urlBasic;?>/adsgs/save_client" method="post" enctype="multipart/form-data">
        <input name="url_error" value="<?php echo $siteData->urlBasic;?>/account/profile/edit?save=ok" style="display: none">
        <input name="url" value="<?php echo $siteData->urlBasic;?>/account" style="display: none">
        <div class="row no-gutters justify-content-center justify-content-lg-start">
            <div class="offset-lg-1 col-lg-5 col-sm-auto">
                <div class="form">
                    <span class="form__title form__title--nobottom text--title--big">
                        Контактные данные
                    </span>
                    <input id="first_name" data-action="english" type="text" class="field" placeholder="Ваше имя*" name="first_name" value="<?php echo htmlspecialchars($data->values['first_name'], ENT_QUOTES); ?>" data-required="true">
                    <input id="last_name" data-action="english" type="text" class="field" placeholder="Ваша фалимия*" name="options[last_name]" value="<?php echo htmlspecialchars($data->values['last_name'], ENT_QUOTES); ?>" data-required="true">
                    <input type="text" class="field" placeholder="Ваш e-mail*" name="email" value="<?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.user_id.email', ''); ?>" data-required="true" autocomplete="off">
                    <input type="text" class="field" placeholder="Ваш номер телефона*" name="phone" value="<?php echo htmlspecialchars($data->values['phone'], ENT_QUOTES); ?>" data-required="true">
                </div>
            </div>
            <div class="offset-lg-1 col-lg-5 col-sm-auto">
                <div class="form">
                    <span class="form__title form__title--nobottom text--title--big">
                        Адрес доставки
                    </span>
                    <?php $addresses = $data->values['addresses']; ?>
                    <div class="dropdown field dropdown--full dropdown--invert">
                        <select id="addresses" data-index="<?php echo count($addresses); ?>"  class="dropdown__current__wrap" data-required="true">
                            <?php if (count($addresses) > 0){  ?>
                                <?php $i = 0; foreach ($addresses as $address){ $i++; ?>
                                    <option value="<?php echo $i; ?>">Адрес <?php echo $i; ?></option>
                                <?php } ?>
                            <?php } else{ ?>
                                <option value="1">Адрес 1</option>
                            <?php } ?>
                        </select>
                    </div>
                    <div id="box-addresses" style="width: 100%;">
                        <?php if (count($addresses) > 0){  ?>
                            <?php $i = 0; foreach ($addresses as $address){ $i++; ?>
                                <div data-id="box-address" id="box-address_<?php echo $i; ?>" <?php if($i != 1){echo 'style="display: none;"';} ?>>
                                    <div class="dropdown field dropdown--full dropdown--invert">
                                        <select id="land_id_<?php echo $i; ?>" data-id="land_id" data-index="<?php echo $i; ?>" name="addresses[<?php echo $i; ?>][land_id]" class="dropdown__current__wrap" data-required="true">
                                            <option disabled>Страна</option>
                                            <?php
                                            $s = 'data-id="'.Arr::path($address, 'land_id', 0).'"';
                                            echo str_replace($s, $s.'selected', $siteData->replaceDatas['view::View_Lands\-account-profile-edit-strany']);
                                            ?>
                                        </select>
                                    </div>
                                    <div class="dropdown field dropdown--full dropdown--invert">
                                        <select id="city_id_<?php echo $i; ?>" data-id="city_id" data-index="<?php echo $i; ?>" data-value="<?php echo Arr::path($address, 'city_id', 0); ?>" name="addresses[<?php echo $i; ?>][city_id]" class="dropdown__current__wrap" data-required="true">
                                            <option disabled selected>Город</option>
                                        </select>
                                    </div>
                                    <input data-id="address" name="addresses[<?php echo $i; ?>][address]" type="text" class="field" placeholder="Адрес" value="<?php echo Arr::path($address, 'address', ''); ?>">
                                </div>
                            <?php } ?>
                        <?php }else{ ?>
                            <div id="box-address_1" data-id="box-address">
                                <div class="dropdown field dropdown--full dropdown--invert">
                                    <select id="land_id_1" data-id="land_id" data-index="1" name="addresses[1][land_id]" data-value="0" class="dropdown__current__wrap" data-required="true">
                                        <option disabled selected>Страна</option>
                                        <?php echo $siteData->globalDatas['view::View_Lands\-account-profile-edit-strany'];?>
                                    </select>
                                </div>
                                <div class="dropdown field dropdown--full dropdown--invert">
                                    <select id="city_id_1" data-id="city_id" data-index="1" name="addresses[1][city_id]" data-value="0" class="dropdown__current__wrap" data-required="true">
                                        <option disabled selected>Город</option>
                                    </select>
                                </div>
                                <input data-id="address" name="addresses[1][address]" type="text" class="field" placeholder="Адрес" data-required="true">
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <a data-id="add-address" href="#" class="link">
                    Добавить еще один адрес
                </a>
                <br class="d-lg-none">
                <a data-id="del-address" href="#" class="link link--right">
                    Удалить адрес
                </a>
            </div>
            <div class="offset-lg-1 col-lg-5 col-sm-auto">
                <div class="form">
                    <span class="form__title form__title--nobottom text--title--big">
                        Удостоверение личности
                    </span>
                    <?php if (Func::_empty(Arr::path($data->values['options'], 'file_passport_1.name', ''))){ ?>
                        <input name="options[file_passport_1]" type="file" id="file-1" class="field--download" data-required="true">
                        <label class="field field--download__label" for="file-1" data-file="0">
                            Загрузить фотографию 1 стороны
                        </label>
                    <?php }else{ ?>
                        <input name="options[file_passport_1]" type="file" id="file-1" data-file="1" class="field--download" data-required="true">
                        <label class="field field--download__label" for="file-1" data-file="1">
                            Файл загружен
                        </label>
                    <?php }?>
                    <?php if (Func::_empty(Arr::path($data->values['options'], 'file_passport_1.name', ''))){ ?>
                        <input name="options[file_passport_2]" type="file" id="file-2" class="field--download" data-required="true">
                        <label class="field field--download__label" for="file-2" data-file="0">
                            Загрузить фотографию 2 стороны
                        </label>
                    <?php }else{ ?>
                        <input name="options[file_passport_2]" type="file" id="file-2" data-file="1" class="field--download" data-required="true">
                        <label class="field field--download__label" for="file-2" data-file="1">
                            Файл загружен
                        </label>
                    <?php }?>
                </div>
            </div>
            <div class="offset-lg-1 col-lg-5 col-sm-auto">
                <div class="form">
                    <span class="form__title form__title--nobottom text--title--big">
                        Смена пароля
                    </span>
                    <input name="password" type="password" class="field" placeholder="Новый пароль" autocomplete="off">
                    <input type="password" class="field" placeholder="Повторите новый пароль" autocomplete="off">
                </div>
            </div>
        </div>
        <div class="row align-items-center align-items-lg-stretch flex-column flex-lg-row no-gutters margin-tb-2">
            <div class="offset-lg-1 col-lg-5 col-sm-auto">
                <input id="form-save-button" type="submit" class="btn" value="Сохранить">
            </div>
        </div>
    </form>
</main>

<script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/input-mask/jquery.inputmask.js"></script>
<script>
    $('input[name="phone"]').inputmask({
        mask: "+9-999-999-99-99"
    });

    function changeLand(list) {
        list.change(function () {
            var id = $(this).val();
            var index = $(this).data('index');

            if (id > 0) {
                jQuery.ajax({
                    url: '/cities',
                    data: ({
                        'land_id': (id),
                    }),
                    type: "POST",
                    success: function (data) {
                        var tmp = $('#city_id_'+index);
                        tmp.html('<option value="0" data-id="0">Город</option>' + data);
                        tmp.val(tmp.data('value'));
                    },
                    error: function (data) {
                        console.log(data.responseText);
                    }
                });
            }else{
                var tmp = $('#city_id_'+index);
                tmp.html('<option value="0" data-id="0">Город</option>');
                tmp.val(0);
            }
        });
    }

    changeLand($('select[data-id="land_id"]'));
    $('select[data-id="land_id"]').trigger('change');

    $('a[data-id="add-address"]').click(function () {
        var addresses = $('#addresses');

        var index = Number(addresses.data('index')) + 1;

        var html = $('#from-address').html().replace('<!--', '').replace('-->', '').replace(/#index#/g, index);
        changeLand($('#box-addresses').append(html).find(('select[data-id="land_id"]')));

        addresses.data('index', index);
        addresses.append('<option value="'+index+'">Адрес '+index+'</option>');
        addresses.val(index).trigger('change');

        return false;
    });


    $('a[data-id="del-address"]').click(function () {
        var addresses = $('#addresses');
        var index = addresses.val();
        $('#box-address_'+index).remove();

        addresses.find('option[value="'+index+'"]').remove();
        addresses.find('option:first').attr('selected', '');
        addresses.trigger('change');
        if (addresses.find('option').length == 0){
            $('a[data-id="add-address"]').trigger('click');
        }

        return false;
    });

    $('#addresses').change(function () {
        $('div[data-id="box-address"]').css('display', 'none');

        var index = $(this).val();
        $('#box-address_'+index).css('display', 'block');

    });

    $('#form-save').on('submit', function(e){
        e.preventDefault();
        var $that = $('#form-save'),
            formData = new FormData($that.get(0)); // создаем новый экземпляр объекта и передаем ему нашу форму (*)

        var messagePanel = $('#message-error');

        var isOK = true;

        el = $that.find('[name="first_name"]');
        var s = el.val();
        $that.find('[data="'+el.attr('name')+'"]').remove();
        if ((s == '') || (!(/^[a-zA-Z]+$/.test(s)))){
            el.after('<span data="'+el.attr('name')+'" class="text--title alert--error">Заполните "Ваше имя" латинскими буквами</span>');
            isOK = false;
        }

        el = $that.find('[id="last_name"]');
        var s = el.val();
        $that.find('[data="'+el.attr('id')+'"]').remove();
        if ((s == '') || (!(/^[a-zA-Z]+$/.test(s)))){
            el.after('<span data="'+el.attr('id')+'" class="text--title alert--error">Заполните "Ваша фалимия" латинскими буквами</span>');
            isOK = false;
        }

        el = $that.find('[name="email"]');
        var s = el.val();
        $that.find('[data="'+el.attr('name')+'"]').remove();
        if ((s == '') || (!(/^[\.a-zA-Z0-9_-]+@[a-zA-Z0-9-]+\.[a-zA-Z]{2,6}$/i.test(s)))){
            el.after('<span data="'+el.attr('name')+'" class="text--title alert--error">Введите корректный "E-mail"</span>');
            isOK = false;
        }

        el = $that.find('[name="phone"]');
        var s = el.val();
        $that.find('[data="'+el.attr('name')+'"]').remove();
        if ((s == '') || (!(/^\+7-[0-9]{3}-[0-9]{3}-[0-9]{2}-[0-9]{2}$/.test(s)))){
            el.after('<span data="'+el.attr('name')+'" class="text--title alert--error">Заполните корректно "Ваш номер телефона"</span>');
            isOK = false;
        }

        el = $that.find('[id="file-1"]');
        $that.find('[data="'+el.attr('id')+'"]').remove();
        if ((el.val() == '') && (el.data('file') != 1)){
            el.after('<span data="'+el.attr('id')+'" class="text--title alert--error">Загрузите лицевую сторону удостоверения личности </span>');
            isOK = false;
        }

        el = $that.find('[id="file-2"]');
        $that.find('[data="'+el.attr('id')+'"]').remove();
        if ((el.val() == '') && (el.data('file') != 1)){
            el.after('<span data="'+el.attr('id')+'" class="text--title alert--error">Загрузите заднюю сторону удостоверения личности </span>');
            isOK = false;
        }

        $.each($that.find('[data-id="land_id"]'), function(index, value){
            s = $.trim($(value).val());
            $that.find('[data="'+$(value).attr('data-id')+index+'"]').remove();
            if (s < 1){
                $(value).parent().after('<span data="'+$(value).attr('data-id')+index+'" class="text--title alert--error">Заполните поле: "Страна"</span>');
                isOK = false;
            }
        });
        $.each($that.find('[data-id="city_id"]'), function(index, value){
            s = $.trim($(value).val());
            $that.find('[data="'+$(value).attr('data-id')+index+'"]').remove();
            if (s < 1){
                $(value).parent().after('<span data="'+$(value).attr('data-id')+index+'" class="text--title alert--error">Заполните поле: "Город"</span>');
                isOK = false;
            }
        });
        $.each($that.find('[data-id="address"]'), function(index, value){
            s = $.trim($(value).val());
            $that.find('[data="'+$(value).attr('data-id')+index+'"]').remove();
            if (s == ''){
                $(value).after('<span data="'+$(value).attr('data-id')+index+'" class="text--title alert--error">Заполните поле: "Адрес"</span>');
                isOK = false;
            }
        });

        if (isOK){
            url = $(this).attr('action');

            jQuery.ajax({
                url: url,
                data: formData,
                type: "POST",
                contentType: false, // важно - убираем форматирование данных по умолчанию
                processData: false, // важно - убираем преобразование строк по умолчанию
                success: function (data) {
                    window.location.href = '/account';
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });
        }

        return false;
    });
</script>
<div id="from-address">
    <!--
    <div id="box-address_#index#" data-id="box-address">
        <div class="dropdown field dropdown--full dropdown--invert">
            <select id="land_id_#index#" data-id="land_id" data-index="#index#" name="addresses[#index#][land_id]" data-value="0" class="dropdown__current__wrap">
                <option disabled selected>Страна</option>
                <?php echo $siteData->globalDatas['view::View_Lands\-account-profile-edit-strany'];?>
            </select>
        </div>
        <div class="dropdown field dropdown--full dropdown--invert">
            <select id="city_id_#index#" data-id="city_id" data-index="#index#" name="addresses[#index#][city_id]" data-value="0" class="dropdown__current__wrap">
                <option disabled selected>Город</option>
            </select>
        </div>
        <input data-id="address" name="addresses[#index#][address]" type="text" class="field" placeholder="Адрес">
    </div>
    -->
</div>