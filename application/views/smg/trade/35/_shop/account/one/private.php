<div class="col-md-12">
    <div class="row">
        <div class="col-md-6" style="margin-bottom: 40px;">
            <form id="form-login" action="/trade/shopuser/update_login" method="post">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>ФИО</label>
                            <input name="name" class="form-control" type="text" placeholder="Иванов Иван" required value="<?php echo $data->values['name'];?>" >
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>E-mail/Логин</label>
                            <input name="email" class="form-control" type="email" placeholder="info@ab1.kz" required value="<?php echo $data->values['email'];?>" >
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Старый пароль</label>
                            <input name="old_password" class="form-control" type="password" placeholder="Пароль">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Новый пороль пароль</label>
                            <input name="new_password" class="form-control" type="password" placeholder="Пароль">
                        </div>
                    </div>
                </div>
                <div hidden>
                            <input name="error_url" value="/users/create-error">
                            <input name="url" value="<?php echo $siteData->urlBasic . $_SERVER['REDIRECT_URL']?>">
                        </div>
                        <button type="submit" class="btn btn-primary pull-left margin-b-40">Сохранить</button>
            </form>
        </div>
    </div>
</div>