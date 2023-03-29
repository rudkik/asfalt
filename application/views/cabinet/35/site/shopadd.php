<form action="" method="POST" role="form">
    <div class="row">
        <div class="col-md-5">
            <img src="dist/img/default-magazin.jpg" alt="">
            <a href="#">Загрузить логотип</a>
        </div>
        <div class="col-md-7">
            <div class="form-group">
                <label for="shop_name">Название магазина</label>
                <input type="text" class="form-control" id="shop_name" placeholder="Название">
            </div>
            <div class="form-group has-error">
                <label for="sub_name">Имя субдомена</label>
                <input type="text" class="form-control" id="sub_name" placeholder="Название">
                <span class="error-message">Неверное значение</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="add_info">Дополнительная информация</label>
                <textarea class="form-control" name="add_info" id="add_info" cols="30" rows="10" placeholder="Ввод текста"></textarea>
            </div>
        </div>
    </div>


    <button type="submit" class="btn btn-primary">Сохранить</button>
    <button type="submit" class="btn btn-success">Перейти дальше</button>
</form>