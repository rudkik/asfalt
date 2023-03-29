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
                    <div class="col-md-5" style="max-width: 450px;">
                        <h3 class="pull-left" style="margin-right: 20px;">Автомобили</h3>
                    </div>
                    <div class="col-md-3 pull-right">
                        <input data-type="auto-number" id="find_number" data-type="auto-number" type="text" class="form-control text-number" placeholder="Номер авто">
                    </div>
                </div>
                <?php
                $view = View::factory('ab1/weighted/35/main/_shop/lessee/car/filter');
                $view->siteData = $siteData;
                $view->data = $data;
                echo Helpers_View::viewToStr($view);
                ?>
            </div>
            <div class="body-table">
            <div class="box-body table-responsive" style="padding-top: 0px;">
                <?php echo trim($data['view::_shop/lessee/car/list/index']); ?>
            </div>
            </div>
        </div>
	</div>
</div>
<script>
    function showAutoAdd(id) {
        jQuery.ajax({
            url: '/weighted/data/get',
            data: ({}),
            type: "GET",
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));

                jQuery.ajax({
                    url: '/weighted/shoplesseecar/clone',
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

    function PrintTTN(id, pages) {
        jQuery.ajax({
            url: '/weighted/data/save',
            data: ({
                'action': ('print'),
                'type': ('ttn'),
                'table_id': ('<?php echo Model_Ab1_Shop_Lessee_Car::TABLE_ID; ?>'),
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

    function PrintTalon(id) {
        jQuery.ajax({
            url: '/weighted/data/save',
            data: ({
                'action': ('print'),
                'type': ('talon'),
                'table_id': ('<?php echo Model_Ab1_Shop_Lessee_Car::TABLE_ID; ?>'),
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
