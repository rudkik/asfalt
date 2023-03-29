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
                    <div class="col-md-3">
                        <h3 class="pull-left" style="margin-right: 20px;">Очередь на выезд</h3>
                    </div>
                    <div class="col-md-3 pull-right">
                        <input id="find_number" type="text" data-type="auto-number" class="form-control text-number" placeholder="Номер авто">
                    </div>
                </div>
            </div>
            <div class="body-table">
                <div class="box-body table-responsive" style="padding-top: 0px;">
                    <?php echo trim($data['view::_shop/car/list/exit-empty']); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function showAutoAdd(id, type) {
        jQuery.ajax({
            url: '/weighted/data/get',
            data: ({}),
            type: "GET",
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));

                var url = '/weighted/shopcar/edit';
                if (type == <?php echo Model_Ab1_Shop_Move_Car::TABLE_ID; ?>){
                    url = '/weighted/shopmovecar/edit';
                }else if (type == <?php echo Model_Ab1_Shop_Defect_Car::TABLE_ID; ?>){
                    url = '/weighted/shopdefectcar/edit';
                }else if (type == <?php echo Model_Ab1_Shop_Lessee_Car::TABLE_ID; ?>){
                    url = '/weighted/shoplesseecar/edit';
                }

                jQuery.ajax({
                    url: url,
                    data: ({
                        id: (id),
                        weight: (obj.weight),
                    }),
                    type: "GET",
                    success: function (data) {
                        $('#dialog-car-edit').remove();
                        $('body').append(data);
                        $('#dialog-car-edit').modal('show');
                    },
                    error: function (data) {
                        console.log(data.responseText);
                    }
                });
            },
            error: function (data) {
                console.log(data.responseText);
                alert('Ошибка запроса веса и номера машины.');
            }
        });
    }
    function sendBruttoForm(id) {
        var name = $('tr[id="'+id+'"]').data('name');
        var tarra = $('tr[id="'+id+'"]').data('tarra');
        var client = $('tr[id="'+id+'"]').data('client');
        var quantity = $('tr[id="'+id+'"]').data('quantity');
        var is_not_overload = $('tr[id="'+id+'"]').data('is_not_overload');
        var is_packed = $('tr[id="'+id+'"]').data('is-packed');
        var packed_tare = $('tr[id="'+id+'"]').data('packed-tare');
        var coefficient_weight_quantity = $('tr[id="'+id+'"]').data('coefficient-weight-quantity');

        jQuery.ajax({
            url: '/weighted/data/get',
            data: ({}),
            type: "GET",
            success: function (dataBrutto) {
                var objBrutto = jQuery.parseJSON($.trim(dataBrutto));
                var brutto = objBrutto.weight;

                try {
                    $('#dialog-exit-finish').data('test', objBrutto.is_test);
                } catch (err) {
                }

                $('#dialog-exit-finish input[name="packed_count"]').val('');
                $('#dialog-exit-finish input[name="packed_count"]').attr('value', '');
                if (is_packed == 1){
                    $('#dialog-exit-finish #packed-tare').css('display', 'block');
                    $('#dialog-exit-finish #packed-tare input[name="packed_count"]').data('tare', packed_tare);
                }else{
                    $('#dialog-exit-finish #packed-tare').css('display', 'none');
                }

                $('#dialog-exit-finish input[name="spill"]').val('');
                $('#dialog-exit-finish input[name="name"]').val(name);
                $('#dialog-exit-finish input[name="id"]').val(id);
                $('#dialog-exit-finish input[name="id"]').attr('value', id);
                $('#dialog-exit-finish input[name="tarra"]').val(tarra);
                $('#dialog-exit-finish input[name="brutto"]').val(brutto);
                $('#dialog-exit-finish input[name="client-name"]').val(client);
                $('#dialog-exit-finish input[name="netto"]').val(((brutto - tarra) * coefficient_weight_quantity).toFixed(3));

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
        var is_test = $('#dialog-exit-finish').data('test');

        jQuery.ajax({
            url: '/weighted/shopcar/send_brutto',
            data: ({
                id: (id),
                brutto: (brutto),
                is_test: (is_test),
                is_empty: (1),
                json: (1),
            }),
            type: "POST",
            success: function (data) {
                $('#dialog-exit-finish').modal('hide');

                var obj = jQuery.parseJSON($.trim(data));
                $('#dialog-exit-ok').data('id', id);
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
        });

        $('[data-action="auto-transfer"]').click(function() {
            var href = $(this).attr('href');
            jQuery.ajax({
                url: href,
                data: ({
                    json: (1),
                }),
                type: "GET",
                success: function (data) {
                    window.location.reload();
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });

            return false;
        });
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
