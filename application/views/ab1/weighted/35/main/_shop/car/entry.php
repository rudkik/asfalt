<div class="col-md-12 padding-top-15px">
	<div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/weighted/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <?php
        $nubmer = Request_RequestParams::getParamStr('a_number');
        if(!empty($nubmer)){?>
        <div class="callout callout-info">
            <p>Машина <b><?php echo $nubmer;?></b> поставлена в очередь</p>
        </div>
        <?php } ?>
        <div class="tab-content">
            <div class="tab-pane active">
                <div class="row">
                    <div class="col-md-5" style="max-width: 450px;">
                        <h3 class="pull-left" style="margin-right: 20px;">Очередь на въезд</h3>
                        <div class="btn-group">
                            <a data-action="car-new" href="<?php echo Func::getFullURL($siteData, '/shopcar/new', array());?>" class="btn bg-purple btn-flat"><i class="fa fa-fw fa-plus"></i> Добавить машину</a>
                            <button type="button" class="btn bg-purple btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="javascript:showMoveAutoAdd()"><i class="fa fa-fw fa-plus"></i> Добавить перемещение</a></li>
                                <li><a data-action="car-new" href="<?php echo Func::getFullURL($siteData, '/shoplesseecar/new', array());?>"><i class="fa fa-fw fa-plus"></i> Добавить ответ.хранение</a></li>
                                <li><a data-action="car-new" href="<?php echo Func::getFullURL($siteData, '/shopdefectcar/new', array());?>"><i class="fa fa-fw fa-plus"></i> Добавить возмещение брака</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3 pull-right">
                        <input id="find_number" type="text" data-type="auto-number" class="form-control text-number" placeholder="Номер авто">
                    </div>
                </div>
            </div>
            <div class="body-table">
                <div class="box-body table-responsive" style="padding-top: 0px;">
                    <?php echo trim($data['view::_shop/car/list/entry']); ?>
                </div>
            </div>
        </div>
	</div>
</div>
<script>
    $('[data-action="car-new"]').click(function (e) {
        e.preventDefault();
        var url = $(this).attr('href');

        jQuery.ajax({
            url: '/weighted/data/get',
            data: ({}),
            type: "GET",
            success: function (dataTarra) {
                var obj = jQuery.parseJSON($.trim(dataTarra));
                window.location.href = url + '?number=' + obj.number;
            },
            error: function (data) {
                console.log(data.responseText);
                alert('Ошибка запроса веса и номера машины.');
            }
        });
    });

    function showMoveAutoAdd() {
        jQuery.ajax({
            url: '/weighted/data/get',
            data: ({}),
            type: "GET",
            success: function (dataTarra) {
                var obj = jQuery.parseJSON($.trim(dataTarra));
                $('#dialog-move-car [name="name"]').val(obj.number);
                $('#dialog-move-car').modal('show');
            },
            error: function (data) {
                console.log(data.responseText);
                alert('Ошибка запроса веса и номера машины.');
            }
        });
    }

    function sendTarraForm(id) {
        var name = $('#entry-'+id+' input[name="name"]').val();
        var type = $('#entry-'+id).data('type');

        jQuery.ajax({
            url: '/weighted/data/get',
            data: ({}),
            type: "GET",
            success: function (dataTarra) {
                var objTarra = jQuery.parseJSON($.trim(dataTarra));
                var tarra = objTarra.weight;

                try {
                    $('#dialog-entry-start').data('test', objTarra.is_test);
                } catch (err) {
                }

                $('#dialog-entry-start input[name="name"]').val(name);
                $('#dialog-entry-start input[name="id"]').val(id);
                $('#dialog-entry-start input[name="id"]').attr('value', id);
                $('#dialog-entry-start input[name="tarra"]').val(tarra);
                $('#dialog-entry-start').data('type', type);
                $('#dialog-entry-start').modal('show');
            },
            error: function (data) {
                console.log(data.responseText);
                alert('Ошибка запроса веса и номера машины.');
            }
        });
    }

    function sendTarra() {
        var id = $('#dialog-entry-start input[name="id"]').val();
        var name = $('#dialog-entry-start input[name="name"]').val();
        var tarra = $('#dialog-entry-start input[name="tarra"]').val();
        var type = $('#dialog-entry-start').data('type');
        var is_test = $('#dialog-exit-finish').data('test');

        var url = '/weighted/shopcar/send_tarra';
        if (type == <?php echo Model_Ab1_Shop_Move_Car::TABLE_ID; ?>){
            url = '/weighted/shopmovecar/send_tarra';
        }else if (type == <?php echo Model_Ab1_Shop_Defect_Car::TABLE_ID; ?>){
            url = '/weighted/shopdefectcar/send_tarra';
        }else{
            if (type == <?php echo Model_Ab1_Shop_Lessee_Car::TABLE_ID; ?>){
                url = '/weighted/shoplesseecar/send_tarra';
            }
        }

        jQuery.ajax({
            url: url,
            data: ({
                id: (id),
                tarra: (tarra),
                is_test: (is_test),
                json: (1),
                name: (name),
            }),
            type: "POST",
            success: function (data) {
                $('#dialog-entry-start').modal('hide');
                var obj = jQuery.parseJSON($.trim(data));
                if(obj.error == 0){
                    $('#html-entry-ok').html(obj.html);
                    $('#dialog-entry-ok').modal('show');
                }else{
                    alert(obj.msg);
                }
            },
            error: function (data) {
                $('#dialog-entry-start').modal('hide');
                $('#dialog-entry-error input[name="name"]').val(name);
                $('#dialog-entry-error').modal('show');
                $('#dialog-entry-error').data('id', id);

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
                tr = $('input[name="name"][value="'+number+'"]');
                if(tr.length > 0){
                    tr = tr.parent().parent();
                    if ($(tr).attr('scroll') != 1) {
                        $('input[name="name"]').parent().parent().removeAttr('style');
                        $('input[name="name"]').parent().parent().removeAttr('scroll');

                        if (obj.coefficient > 89.9) {
                            tr.css('background-color', '#cbf7ab');
                        }else{
                            tr.css('background-color', '#fae873');
                        }
                        $('html, body').animate({ scrollTop: $(tr).offset().top }, 500);
                        $(tr).attr('scroll', 1);
                    }
                }else{
                    $('input[name="name"]').parent().parent().removeAttr('style');
                    $('input[name="name"]').parent().parent().removeAttr('scroll');
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
$view = View::factory('ab1/weighted/35/_shop/move/car/one/modal');
$view->siteData = $siteData;
$view->data = $data;
$view->url = '/weighted/shopclient/save';
echo Helpers_View::viewToStr($view);
?>
<?php
$view = View::factory('ab1/weighted/35/_shop/car/modal/entry-error');
$view->siteData = $siteData;
$view->data = $data;
$view->url = '/weighted/shopclient/save';
echo Helpers_View::viewToStr($view);
?>
<?php
$view = View::factory('ab1/weighted/35/_shop/car/modal/entry-ok');
$view->siteData = $siteData;
$view->data = $data;
$view->url = '/weighted/shopclient/save';
echo Helpers_View::viewToStr($view);
?>
<?php
$view = View::factory('ab1/weighted/35/_shop/car/modal/entry-start');
$view->siteData = $siteData;
$view->data = $data;
$view->url = '/weighted/shopclient/save';
echo Helpers_View::viewToStr($view);
?>
