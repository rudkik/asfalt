<div class="col-md-12 padding-top-15px">
    <div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/weighted/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
            <div class="tab-pane active">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="pull-left" style="margin-right: 20px;">Очередь на выезд</h3>
                        <button data-action="car-new" type="button" class="btn bg-purple btn-flat"><i class="fa fa-fw fa-plus"></i> Добавить машину</button>
                    </div>
                    <div class="col-md-4 pull-right">
                        <div class="input-group">
                        <input id="find_number" type="text" data-type="auto-number" class="form-control text-number" placeholder="Номер авто">
                        <span class="input-group-btn">
                            <a href="<?php echo $siteData->urlBasic; ?>/weighted/shopcar/exit_all" class="btn bg-blue btn-flat">Все машины</a>
                        </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="body-table">
                <div class="box-body table-responsive" style="padding-top: 0px;">
                    <?php echo trim($data['view::_shop/car/list/exit']); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('[data-action="car-new"]').click(function (e) {
        e.preventDefault();
        jQuery.ajax({
            url: '/weighted/data/get',
            data: ({
                'is_tarra': true,
            }),
            type: "GET",
            success: function (dataTarra) {
                var obj = jQuery.parseJSON($.trim(dataTarra));
                $('#dialog-exit-car [name="number"]').attr('value', obj.number).val(obj.number);
                $('#dialog-exit-car [name="tare"]').attr('value', obj.tarra).val(obj.tarra);
                $('#dialog-exit-car').modal('show');
            },
            error: function (data) {
                console.log(data.responseText);
                alert('Ошибка запроса веса и номера машины.');
            }
        });
    }).trigger('change');

    function sendBruttoForm(id) {
        var name = $('tr[id="'+id+'"]').data('name');
        var tarra = $('tr[id="'+id+'"]').data('tarra');
        var client = $('tr[id="'+id+'"]').data('client');
        var quantity = $('tr[id="'+id+'"]').data('quantity');
        var is_not_overload = $('tr[id="'+id+'"]').data('is_not_overload');
        var type = $('tr[id="'+id+'"]').data('type');
        var driver = $('tr[id="'+id+'"]').data('driver');
        var shop_transport_company_id = $('tr[id="'+id+'"]').data('shop_transport_company_id');
        var is_packed= $('tr[id="'+id+'"]').data('is-packed');
        var packed_tare= $('tr[id="'+id+'"]').data('packed-tare');
        var coefficient_weight_quantity = $('tr[id="'+id+'"]').data('coefficient-weight-quantity');

        jQuery.ajax({
            url: '/weighted/data/get_car_driver',
            data: ({
                'number':(name),
            }),
            type: "GET",
            success: function (dataBrutto) {
                var objBrutto = jQuery.parseJSON($.trim(dataBrutto));
                var brutto = objBrutto.weight;

                try {
                    $('#dialog-exit-finish').data('test', objBrutto.is_test);
                } catch (err) {
                }

                $('#dialog-exit-finish input[name="spill"]').val('');
                $('#dialog-exit-finish [name="shop_transport_company_id"]').val(objBrutto.car.shop_transport_company_id).trigger("change");

                $('#dialog-exit-finish input[name="packed_count"]').val('');
                $('#dialog-exit-finish input[name="packed_count"]').attr('value', '');
                if (is_packed == 1){
                    $('#dialog-exit-finish #packed-tare').css('display', 'block');
                    $('#dialog-exit-finish #packed-tare input[name="packed_count"]').data('tare', packed_tare);
                }else{
                    $('#dialog-exit-finish #packed-tare').css('display', 'none');
                }

                if(driver != '') {
                    $('#dialog-exit-finish input[name="shop_driver_name"]').val(driver);
                }else{
                    $('#dialog-exit-finish input[name="shop_driver_name"]').val(objBrutto.car.shop_driver_name);
                }

                $('#dialog-exit-finish input[name="shop_transport_company_id"]').val(shop_transport_company_id);
                $('#dialog-exit-finish input[name="name"]').val(name);
                $('#dialog-exit-finish input[name="id"]').val(id);
                $('#dialog-exit-finish input[name="id"]').attr('value', id);
                $('#dialog-exit-finish input[name="tarra"]').val(tarra);
                $('#dialog-exit-finish input[name="brutto"]').val(brutto);
                $('#dialog-exit-finish input[name="client-name"]').val(client);
                $('#dialog-exit-finish input[name="netto"]').val(((brutto - tarra) * coefficient_weight_quantity).toFixed(3));
                $('#dialog-exit-finish').data('type', type);

                if (is_not_overload == 1) {
                    $('#dialog-exit-finish [name="quantity"]').text(quantity + ' т');
                    $('#dialog-exit-finish #is_not_overload').css('display', 'block');
                }else{
                    $('#dialog-exit-finish #is_not_overload').css('display', 'none');
                }
                $('#dialog-exit-finish').modal('show');
            },
            error: function (data) {
                console.log(data.responseText);
                alert('Ошибка запроса веса и номера машины.');
            }
        });
    }

    function sendBrutto() {
        var id = $('#dialog-exit-finish input[name="id"]').val();
        var brutto = $('#dialog-exit-finish input[name="brutto"]').val();
        var driver = $('#dialog-exit-finish input[name="shop_driver_name"]').val();
        var transportCompany = $('#dialog-exit-finish select[name="shop_transport_company_id"]').val();
        var type = $('#dialog-exit-finish').data('type');
        var packed_count = $('#dialog-exit-finish input[name="packed_count"]').val();
        var is_test = $('#dialog-exit-finish').data('test');
        var spill = $('#dialog-exit-finish input[name="spill"]').val();

        var url = '/weighted/shopcar/send_brutto';
        if (type == <?php echo Model_Ab1_Shop_Move_Car::TABLE_ID; ?>){
            url = '/weighted/shopmovecar/send_brutto';
        }else if (type == <?php echo Model_Ab1_Shop_Defect_Car::TABLE_ID; ?>){
            url = '/weighted/shopdefectcar/send_brutto';
        }

        jQuery.ajax({
            url: url,
            data: ({
                id: (id),
                brutto: (brutto),
                shop_driver_name: (driver),
                packed_count: (packed_count),
                shop_transport_company_id: (transportCompany),
                is_test: (is_test),
                spill: (spill),
                json: (1),
            }),
            type: "POST",
            success: function (data) {
                $('#dialog-exit-finish').modal('hide');

                var obj = jQuery.parseJSON($.trim(data));
                $('#dialog-exit-ok').data('id', id);
                $('#dialog-exit-ok').data('type', type);
                if(obj.error == 0){
                    if(obj.is_exit){
                        $('#html-exit-ok div[data-status="ok"]').attr('style', '');
                        $('#html-exit-ok div[data-status="error"]').attr('style', 'display: none');
                    }else{
                        $('#html-exit-ok div[data-status="ok"]').attr('style', 'display: none');
                        $('#html-exit-ok div[data-status="error"]').attr('style', '');
                        $('#html-exit-ok div[data-status="error"] h3').text('Долг: ' + obj.amount_str);
                    }
                    $('#dialog-exit-ok').modal('show');
                }else{
                    alert(obj.msg);
                }
            },
            error: function (data) {
                $('#dialog-exit-finish').modal('hide');
                $('#dialog-exit-error').modal('show');

                console.log(data.responseText);
            }
        });
    }

    var findCar=function(){
        jQuery.ajax({
            url: '/weighted/data/get',
            data: ({}),
            type: "GET",
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));
                var number = obj.number;
                tr = $('tr[data-name="'+number+'"]');
                if(tr.length > 0){
                    if (tr.attr('scroll') != 1) {
                        tr.removeAttr('style');
                        tr.removeAttr('scroll');

                        if (obj.coefficient > 89.9) {
                            tr.css('background-color', '#cbf7ab');
                        }else{
                            tr.css('background-color', '#fae873');
                        }
                        $('html, body').animate({ scrollTop: $(tr).offset().top }, 500);
                        tr.attr('scroll', 1);
                    }
                }else{
                    tr.removeAttr('style');
                    tr.removeAttr('scroll');
                }
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
        setTimeout(arguments.callee, 3000);
    }

    setTimeout(findCar, 3000);

    $(document).ready(function () {
        $('#find_number').keyup(function (e) {
            $('tr[data-name]').removeClass('tr-select');

            var number = $(this).val().toUpperCase();
            if (number != '') {
                trs = $('tr[data-name*="' + number + '"]');
                if (trs.length > 0) {
                    trs.addClass('tr-select');

                    if (e.keyCode == 13) {
                        $('html, body').animate({scrollTop: trs.children(0).offset().top}, 500);
                    }
                }
            }
        })
    });
</script>
<?php
$view = View::factory('ab1/weighted/35/_shop/car/modal/exit-error');
$view->siteData = $siteData;
$view->data = $data;
$view->url = '/weighted/shopclient/save';
echo Helpers_View::viewToStr($view);
?>
<?php
$view = View::factory('ab1/weighted/35/_shop/car/modal/exit-ok');
$view->siteData = $siteData;
$view->data = $data;
$view->url = '/weighted/shopclient/save';
echo Helpers_View::viewToStr($view);
?>
<?php
$view = View::factory('ab1/weighted/35/_shop/car/modal/exit-finish');
$view->siteData = $siteData;
$view->data = $data;
$view->url = '/weighted/shopclient/save';
echo Helpers_View::viewToStr($view);
?>
<?php
$view = View::factory('ab1/weighted/35/_shop/car/modal/exit-car');
$view->siteData = $siteData;
$view->data = $data;
$view->url = '/weighted/shopclient/save';
echo Helpers_View::viewToStr($view);
?>

