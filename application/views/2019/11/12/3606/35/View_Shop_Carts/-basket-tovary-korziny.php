<header class="header-basket">
    <div class="container">
        <h1 itemprop="headline">Оформить заказ</h1>
        <?php
        foreach ($data['view::View_Shop_Cart\-basket-tovary-korziny']->childs as $value){
            echo $value->str;
        }
        ?>
        <?php if(count($data['view::View_Shop_Cart\-basket-tovary-korziny']->childs) == 0){ ?>
            <h2 class="text-red text-center">Ваша корзина пуста</h2>
        <?php } ?>
    </div>
</header>
<?php if(count($data['view::View_Shop_Cart\-basket-tovary-korziny']->childs) > 0){ ?>
    <header class="header-delivery">
        <div class="container">
            <h1>Информация о доставке</h1>
            <form id="save-bill" action="<?php echo $siteData->urlBasic;?>/cart/save_bill" method="POST" class="form-group">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Имя</label>
                            <div class="input-group hyper-input-group">
                                <input type="text" class="form-control" name="options[name]" placeholder="Имя">
                                <span class="input-group-btn">
                                    <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/user-r.png">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Телефон</label>
                            <div class="input-group hyper-input-group">
                                <input type="text" class="form-control" name="options[phone]" placeholder="Телефон">
                                <span class="input-group-btn">
                                    <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/phone-r.png">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>E-mail</label>
                            <div class="input-group hyper-input-group">
                                <input type="text" class="form-control" name="options[email]" placeholder="E-mail">
                                <span class="input-group-btn">
                                    <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/email-r.png">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Город</label>
                            <div class="input-group hyper-input-group">
                                <input type="text" class="form-control" name="options[city]" placeholder="Город">
                                <span class="input-group-btn">
                                    <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/point-r.png">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Улица</label>
                            <div class="input-group hyper-input-group">
                                <input type="text" class="form-control" name="options[street]" placeholder="Улица">
                                <span class="input-group-btn">
                                    <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/home-r.png">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Способ доставки</label>
                            <div class="hyper-input-group">
                                <select class="form-control select2" name="shop_delivery_type_id" style="width: 100%;">
                                    <option value="1" selected="selected">Курьером (только в г. Алматы)</option>
                                    <option value="2">КазПочтой</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Способ оплаты</label>
                            <div class="hyper-input-group">
                                <select class="form-control select2" name="shop_paid_type_id" style="width: 100%;">
                                    <option value="1" selected="selected">Банковской карточкой</option>
                                    <option value="2">Наличными курьеру (только в г. Алматы)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Индекс</label>
                            <div class="input-group hyper-input-group">
                                <input type="text" class="form-control" name="options[index]" placeholder="Индекс">
                                <span class="input-group-btn">
                                    <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/home-r.png">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if(count($data['view::View_Shop_Cart\-basket-tovary-korziny']->childs) > 0){ ?>
                    <div class="text-center">
                        <input name="url" value="" style="display: none">
                        <input name="shop_branch_id" value="3606" style="display: none">
                        <input name="type" value="8320" style="display: none">
                        <button id="" type="button" class="btn btn-flat btn-red btn-img btn-sale bth-finish" onclick="submitSave()">Оформить заказ</button>
                    </div>
                <?php } ?>
            </form>
        </div>
    </header>
    <script>
        function submitSave() {
            if($('[name="shop_paid_type_id"]').val() == 1){
                $('[name="url"]').val('/payment-card');
            }else{
                if($('[name="shop_paid_type_id"]').val() == 2){
                    $('[name="url"]').val('/payment-cash');
                }
            }

            $('#save-bill').submit();
        }
    </script>
<?php } ?>