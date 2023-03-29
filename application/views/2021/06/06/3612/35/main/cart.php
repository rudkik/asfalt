<section class="row">
    <ul class="titles row col-12">
        <li class="col-sm-5">Товар</li>
        <li class="col-sm-2">Цена</li>
        <li class="col-sm-2">Количество</li>
        <li class="col-sm-2">Итого</li>
        <li class="col-sm-1"></li>
    </ul>
	<?php echo trim($siteData->globalDatas['view::DB_Shop_Goods\-cart-tovary-v-korzine']); ?>
</section>
<section class="totalPrice">
    <div class="discount row" style="display: none">
        <div class="text col-md-9 col-sm-6 col-6">Скидка по промо коду:</div>
        <div class="sum col-md-3 col-sm-6 col-6">
            <span class="disNum">0</span>
            <span id="discount-type">тг</span>
        </div>
    </div>
    <div class="totalSumm row">
        <div class="text col-md-9 col-sm-6 col-6">Общая сумма заказа:</div>
        <div class="sum col-md-3 col-sm-6 col-6">
            <span class="sumNum">0</span>
            <span>тг</span>
        </div>
    </div>
    <form action="/cart/set_coupon" class="promo row">
        <div class="promo__field col-md-9 col-sm-6 col-6">
            <input class="cell__promo col" type="text" name="number" placeholder="Ведите промо-код">
        </div>
        <div class="promo__btn col-md-3 col-sm-6 col-6">
            <button data-action="set-coupon" type="button" class="btn">добавить</button>
        </div>
    </form>
</section>

<section class="checkout">
    <div class="title">Оформите заказ:</div>
    <div class="subtext">
        <p>* Все поля обязательны для заполнения.</p>
        <br>
    </div>
    <?php $options = Api_Shop_Cart::getBillOptions($siteData);?>
    <form id="form-save" action="/cart/save_bill" method="post" class="row bt">
        <div class="otstup col-md-4 col-sm-12">
            <input class="cell col row" type="text" id="name" name="options[name]" placeholder="Имя и фамилия" value="<?php echo Arr::path($options, 'name'); ?>">
            <input class="cell col row" type="email" id="email" name="options[email]" placeholder="E-mail" value="<?php echo Arr::path($options, 'email'); ?>">
            <input data-action="set-person-discount" data-type="mobile" class="cell col row" type="tel" id="phone" name="options[phone]" placeholder="Телефон" value="<?php echo Arr::path($options, 'phone'); ?>">
        </div>
        <div class="otstup col-md-3 col-sm-12 bt">
            <input class="cell col row" type="text" id="city" name="options[city]" placeholder="Город" value="<?php echo Arr::path($options, 'city'); ?>">
            <input class="cell col row" type="text" id="street" name="options[street]" placeholder="Улица" value="<?php echo Arr::path($options, 'street'); ?>">
            <input class="cell col row" type="text" id="house" name="options[house]" placeholder="Дом" value="<?php echo Arr::path($options, 'house'); ?>">
            <input class="cell col row" type="text" id="flat" name="options[flat]" placeholder="Квартира" value="<?php echo Arr::path($options, 'flat'); ?>">
            <input class="cell col row" type="text" id="postcode" name="options[postcode]" placeholder="Индекс" value="<?php echo Arr::path($options, 'postcode'); ?>">
            <div class="deliveryPlace">
                <div class="delivery__field row col">
                    <select class="size" name="shop_delivery_type_id" id="shop_delivery_type_id">
                        <option value="0" selected="selected">Способ доставки</option>
                        <option value="2">Самовывоз</option>
                        <option value="3">Поездом</option>
                        <option value="4">Яндекс (по г. Алматы)</option>
                        <option value="5">Индрайвер</option>
                        <option value="6">Казпочта</option>
                    </select>
                </div>
                <div class="delivery__text row col" id="delivery">
                    <div class="delivery__text-item">Доставка от 1000тг, в зависимости от вашего расположения.</div>
                    <div class="delivery__text-item">Вы можете приехать к нам в питомник и забрать ваш заказ</div>
                    <div class="delivery__text-item">Через проводников в центральные города казахстана. От 2000тг.</div>
                </div>
            </div>
        </div>
        <div class="payment otstup col-md-2 col-sm-6">
            <p>Способ оплаты:</p>
            <div class="payment__item">
                <input type="radio" name="shop_paid_type_id" value="906" id="card">
                <label for="card">Картой</label>
            </div>
        </div>
        <div class="verify col-md-3 col-sm-6">
            <div class="agreement">
                <label class="checkbox">
                    <input type="checkbox" name="verify" value="1">
                    <span>Даю согласие на обработку данных</span>
                </label>
            </div>
            <input name="type" value="4190" style="display: none">
            <button id="checkout" type="button" class="btn">к оплате</button>
        </div>
    </form>
</section>

<script src="https://widget.cloudpayments.ru/bundles/cloudpayments"></script>
<script>
    function isCheckout(e) {
        var delivery = $('#shop_delivery_type_id').val();

        $('#checkout').attr('disabled', '');

        if($('[name="shop_delivery_type_id"]').val() < 1){
            return false;
        }
        if($('[name="shop_paid_type_id"]').val() < 1){
            return false;
        }
        if($('#city').val() == '' && delivery != 4 && delivery != 2){
            return false;
        }
        if($('#street').val() == '' && delivery == 6){
            return false;
        }
        if($('#name').val() == ''){
            return false;
        }
        if($('#email').val() == ''){
            return false;
        }else{
            var pattern = /^[a-z0-9_-]+@[a-z0-9-]+\.[a-z]{2,6}$/i;

            if($('#email').val().search(pattern) == 0){
                $('#email').removeClass("cell-required");
                $(".err").remove();
            }else{
                $(".err").remove();
                $('#email').addClass("cell-required");
                var err = '<div class="err" style="position: relative; top: -10px; left: 0px; font-size: 11px; color: rgb(255, 255, 255); background-color: rgb(216, 81, 81); padding: 2px 2px 2px 5px;">Необходимо корректно заполнить</div>';
                $('#email').after(err);

                if(e != undefined) {
                    e.preventDefault();
                }
                return false;
            }
        }

        if($('#phone').val() == ''){
            return false;
        }
        if($('[name="verify"]').val() < 1){
            return false;
        }

        $('#checkout').removeAttr('disabled');

        return true;
    }

    $('[name="shop_delivery_type_id"], [name="shop_paid_type_id"], #address, #name, #email, #phone, #street, #house, #flat, #postcode, #city').change(function (e) {
        isCheckout(e);
    });

    function payment(billID, amount) {
        var widget = new cp.CloudPayments();
        widget.pay('auth', // или 'charge'
            { //options
                publicId: 'pk_0c8a418e963b996c4777278f3e909', //id из личного кабинета
                description: 'Оплата товаров в dzungla.kz', //назначение
                amount: (Number(amount)), //сумма
                currency: 'KZT', //валюта
                invoiceId: (billID), //номер заказа  (необязательно)
                skin: "classic", //дизайн виджета (необязательно)
                email: ($('#email').val()),
                data: {
                    myProp: 'myProp value'
                }
            },
            {
                onSuccess: function (options) {
                    window.location.href = '/cart-success';
                },
                onFail: function (reason, options) {
                    window.location.href = '/cart-fail';
                },
                onComplete: function (paymentResult, options) {
                }
            }
        )
    }
    
    this.pay = function () {
        if(!isCheckout()){
            return;
        }

        var form = $('#form-save');

        if(form.data('bill') != undefined) {
            payment(form.data('bill'), form.data('amount'));
            return true;
        }

        var url = form.attr('action');
        var formData = form.serialize();
        formData = formData + '&json=1';

        form.find('input').attr('disabled', '');
        jQuery.ajax({
            url: url,
            data: formData,
            type: "GET",
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));
                form.data('amount', obj.values.amount);
                form.data('bill', obj.id);
                payment(obj.id, obj.values.amount);
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
        
        return true;
    };
    $('#checkout').click(pay);

    $('[data-action="set-coupon"]').click(function (e){
        var form = $(this).closest('form');

        var url = form.attr('action');
        var formData = form.serialize();
        formData = formData + '&json=1';
        jQuery.ajax({
            url: url,
            data: formData,
            type: "GET",
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));
                if(obj.error == false){
                    window.location.href = '/cart';
                }
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    });

    $('[data-action="set-person-discount"]').change(function (e){
        var url = '/cart/set_person_discount';
        jQuery.ajax({
            url: url,
            data: ({
                'phone': ($(this).val())
            }),
            type: "GET",
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));
                if(obj.error == false){
                    var form = $('#form-save');

                    var formData = form.serialize();
                    formData = formData + '&json=1';

                    form.find('input').attr('disabled', '');
                    jQuery.ajax({
                        url: '/cart/set_bill_data',
                        data: formData,
                        type: "GET",
                        success: function (data) {
                            window.location.href = '/cart';
                        },
                        error: function (data) {
                            console.log(data.responseText);
                        }
                    });
                }
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    });
    $('#shop_delivery_type_id').change(function (e){
        var delivery = $(this).val();

        if(delivery == 6){
            $('#city').css('display', 'block');
            $('#street').css('display', 'block');
            $('#house').css('display', 'block');
            $('#flat').css('display', 'block');
            $('#postcode').css('display', 'block');
        }else{
            if(delivery == 4 || delivery == 2) {
                $('#city').css('display', 'none');
            }else{
                $('#city').css('display', 'block');
            }
            $('#street').css('display', 'none');
            $('#house').css('display', 'none');
            $('#flat').css('display', 'none');
            $('#postcode').css('display', 'none');
        }
    });
</script>