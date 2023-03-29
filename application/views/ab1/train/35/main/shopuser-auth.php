<div class="container">
    <div class="login-wrapepr">
        <div
            class="col-lg-5 col-md-5 col-sm-9 col-xs-9 col-lg-offset-3 col-md-offset-3 col-sm-offset-2 col-xs-offset-2">
            <div class="login-block">
                <form action="<?php echo $siteData->urlBasic; ?>/train/shopuser/login" method="get" role="form">
                    <span class="enter-form-error<?php if (Arr::path($siteData->urlParams, 's') != 1) {
                        echo ' hidden';
                    } ?>">Неправильно введен логин или пароль</span>
                    <legend class="login-title">Вход</legend>
                    <div class="form-group">
                        <input type="text" name="email" class="form-control login-input" id="" placeholder="Логин">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control login-input" id=""
                               placeholder="Пароль">
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="is_save" class="login-checkbox" id="remember-me"><label
                            for="remember-me">Запомнить
                            меня</label>
                        <button type="submit" class="btn btn-primary login-btn pull-right">Войти</button>
                        <div class="clearfix"></div>
                        <a href="#" onclick="showResetPasswordField()" class="pull-right login-forgot">Забыли
                            пароль?</a>
                    </div>
                    <div id="reset-password" class="form-group login-reset-pass" style="display: none">
                        <label for="resetpass">Восстановить пароль от личного кабинета</label>
                        <input id="resetpass" type="text" class="form-control" placeholder="Пароль">
                    </div>
                    <button id="reset-password-button" type="submit" class="btn btn-primary pull-right"
                            style="display: none">Сброс пароля
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function showResetPasswordField() {
        $('#reset-password').css('display', 'block');
        $('#reset-password-button').css('display', 'block');
    }
</script>
