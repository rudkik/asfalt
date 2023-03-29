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
                        <h3>Материалы</h3>
                    </div>
                    <div class="col-md-3 pull-right">
                        <input data-type="auto-number" id="find_number" type="text" class="form-control text-number" placeholder="Номер авто">
                    </div>
                </div>

                <?php
                $view = View::factory('ab1/weighted/35/main/_shop/car/to/material/filter');
                $view->siteData = $siteData;
                $view->data = $data;
                echo Helpers_View::viewToStr($view);
                ?>
            </div>
            <div class="tab-content">
                <div class="nav-tabs-custom" style="margin-bottom: 0px;">
                    <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
                        <li class="<?php if(Arr::path($siteData->urlParams, 'is_delete', '') == 1){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopcartomaterial/index', array(), array('is_delete' => 1, 'is_public_ignore' => 1));?>" data-id="is_delete_public_ignore">Удаленные</a></li>
                        <li class="<?php if((Arr::path($siteData->urlParams, 'is_delete', '') != 1) && (Arr::path($siteData->urlParams, 'is_not_public', '') != 1) && (Arr::path($siteData->urlParams, 'is_public', '') != 1)){echo 'active';}?>"><a href="<?php echo Func::getFullURL($siteData, '/shopcartomaterial/index', array(), array('is_public_ignore' => 1));?>"  data-id="is_public_ignore">Все <i class="fa fa-fw fa-info text-blue"></i></a></li>
                        <li class="pull-left header">
                            <a data-action="new-auto" href="<?php echo Func::getFullURL($siteData, '/shopcartomaterial/new', array(), array('is_weighted' => true));?>" class="btn bg-purple btn-flat">
                                <i class="fa fa-fw fa-plus"></i>
                                Добавить
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="body-table">
                <div class="box-body table-responsive" style="padding-top: 0px;">
                    <?php echo trim($data['view::_shop/car/to/material/list/index']); ?>
                </div>
                </div>
            </div>
        </div>
	</div>
</div>
<script>
    function PrintTTNMaterial(id, pages) {
        jQuery.ajax({
            url: '/weighted/data/save',
            data: ({
                'action': ('print'),
                'table_id': ('<?php echo Model_Ab1_Shop_Car_To_Material::TABLE_ID; ?>'),
                'type': ('ttn_material'),
                'pages': (pages),
                'id': (id)
            }),
            type: "GET",
            success: function (dataBrutto) {
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    }

    function formReceptionCar(id) {
        var name = $('tr[id="'+id+'"]').data('name');
        var tarra = $('tr[id="'+id+'"]').data('tarra');

        $('#dialog-reception-car').remove();
        jQuery.ajax({
            url: '/weighted/shopcartomaterial/get_receiver_form',
            data: ({
                id: (id),

            }),
            type: "GET",
            success: function (data) {
                $('body').append(data);

                _initDialogReceptionCar();
                $('#dialog-reception-car').modal('show');
            },
            error: function (data) {
                console.log(data.responseText);
                alert('Ошибка запроса веса и номера машины.');
            }
        });

        return FALSE;
    }

    function formDaughterQuantity(id) {
        var name = $('tr[id="'+id+'"]').data('name');
        var tarra = $('tr[id="'+id+'"]').data('tarra');

        $('#dialog-daughter-car').remove();
        jQuery.ajax({
            url: '/weighted/shopcartomaterial/get_daughter_form',
            data: ({
                id: (id),

            }),
            type: "GET",
            success: function (data) {
                $('body').append(data);

                _initDialogDaughterCar();
                $('#dialog-daughter-car').modal('show');
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });

        return FALSE;
    }

    function sendDaughterCar(id) {
        jQuery.ajax({
            url: '/weighted/shopcartomaterial/apply_weight_receiver',
            data: ({
                id: (id),
                json: (1),
            }),
            type: "POST",
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));
                if(obj.error == 0){
                    $('#' + id + ' [data-id="quantity_daughter"]').html(obj.values.quantity_daughter + ' т');
                    $('#' + id + ' [data-id="send_quantity_daughter"]').css('display', 'none');
                }else{
                    alert(obj.msg);
                }
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    }

    function sendTareForm(id) {
        var name = $('tr[id="'+id+'"]').data('name');
        var tarra = $('tr[id="'+id+'"]').data('tarra');
        var quantity = $('tr[id="'+id+'"]').data('quantity');

        jQuery.ajax({
            url: '/weighted/data/get',
            data: ({}),
            type: "GET",
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));
                var tarraNew = obj.weight;

                try {
                    $('#dialog-edit-tare').data('test', obj.is_test);
                } catch (err) {
                }

                $('#dialog-edit-tare input[name="name"]').val(name);
                $('#dialog-edit-tare input[name="id"]').val(id);
                $('#dialog-edit-tare input[name="id"]').attr('value', id);
                $('#dialog-edit-tare input[name="tarra"]').val(tarraNew);
                $('#dialog-edit-tare input[name="brutto"]').val(Number(quantity) + Number(tarra));
                $('#dialog-edit-tare input[name="netto"]').val((Number(quantity) + Number(tarra) - Number(tarraNew)).toFixed(3));
                $('#dialog-edit-tare').modal('show');
            },
            error: function (data) {
                console.log(data.responseText);
                alert('Ошибка запроса веса и номера машины.');
            }
        });

        return FALSE;
    }

    function sendTare() {
        var id = $('#dialog-edit-tare input[name="id"]').val();
        var tarra = $('#dialog-edit-tare input[name="tarra"]').val();
        var quantity = $('#dialog-edit-tare input[name="netto"]').val();
        var is_test = $('#dialog-edit-tare').data('test');

        jQuery.ajax({
            url: '/weighted/shopcartomaterial/send_tare',
            data: ({
                id: (id),
                tarra: (tarra),
                is_test: (is_test),
                quantity: (quantity),
                json: (1),
            }),
            type: "POST",
            success: function (data) {
                $('#dialog-edit-tare').modal('hide');

                var obj = jQuery.parseJSON($.trim(data));
                if(obj.error == 0){
                    window.location.reload();
                }else{
                    alert(obj.msg);
                }
            },
            error: function (data) {
                $('#dialog-edit-tare').modal('hide');
                $('#dialog-exit-error').modal('show');

                console.log(data.responseText);
            }
        });
    }

    $('[data-action="new-auto"]').click(function() {
        jQuery.ajax({
            url: '/weighted/data/get',
            data: ({}),
            type: "GET",
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));
                window.location.href = ('<?php echo Func::getFullURL($siteData, '/shopcartomaterial/new', array());?>'+'?is_weighted=1&number='+obj.number+'&weight='+obj.weight);
            },
            error: function (data) {
                console.log(data.responseText);
                alert('Ошибка запроса веса и номера машины.');
            }
        });

        return false;
    });
    $('[data-action="clone-auto"]').click(function() {
        url = $(this).attr('href');
        jQuery.ajax({
            url: '/weighted/data/get',
            data: ({}),
            type: "GET",
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));
                window.location.href = (url+'&number='+obj.number+'&weight='+obj.weight);
            },
            error: function (data) {
                console.log(data.responseText);
                alert('Ошибка запроса веса и номера машины.');
            }
        });

        return false;
    });

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
$view = View::factory('ab1/weighted/35/_shop/car/to/material/modal/edit-tare');
$view->siteData = $siteData;
$view->data = $data;
echo Helpers_View::viewToStr($view);
?>
