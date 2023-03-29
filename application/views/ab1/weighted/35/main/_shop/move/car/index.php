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
                <?php $siteData->titleTop = 'Автомобили'; ?>
                <?php
                $view = View::factory('ab1/weighted/35/main/_shop/move/car/filter');
                $view->siteData = $siteData;
                $view->data = $data;
                echo Helpers_View::viewToStr($view);
                ?>
            </div>
            <div class="body-table">
            <div class="box-body table-responsive" style="padding-top: 0px;">
                <?php echo trim($data['view::_shop/move/car/list/index']); ?>
            </div>
            </div>
        </div>
	</div>
</div>
<script>
    function PrintTTN(id, pages) {
        jQuery.ajax({
            url: '/weighted/data/save',
            data: ({
                'action': ('print'),
                'type': ('ttn'),
                'table_id': ('<?php echo Model_Ab1_Shop_Move_Car::TABLE_ID; ?>'),
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
                'table_id': ('<?php echo Model_Ab1_Shop_Move_Car::TABLE_ID; ?>'),
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

    function showAutoAdd(id) {
        jQuery.ajax({
            url: '/weighted/data/get',
            data: ({}),
            type: "GET",
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));

                jQuery.ajax({
                    url: '/weighted/shopmovecar/clone',
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
