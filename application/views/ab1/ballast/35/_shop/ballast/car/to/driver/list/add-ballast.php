<table class="table table-hover table-db table-tr-line" >
    <tr>
        <th>Машина + водитель</th>
        <th>Место выгрузки</th>
        <th>Кол-во рейсов</th>
    </tr>
    <?php
    foreach ($data['view::_shop/ballast/car/to/driver/one/add-ballast']->childs as $value) {
        echo $value->str;
    }
    ?>
</table>
<script>
    $('[data-action="add-ballast"]').click(function() {
        var crusher = $(this).data('id');
        var is_storage = crusher < 1;

        var parent = $(this).parent().parent();
        var car = parent.data('shop_ballast_car_id');
        var driver = parent.data('shop_ballast_driver_id');

        var distance = $('#shop_ballast_distance_id').val();
        var workShift = $('#shop_work_shift_id').val();
        var take = $('#take_shop_ballast_crusher_id').val();
        var date = $('#date').val();

        if((distance < 1) || (workShift < 1)){
            alert('Выберите "место погрузки" и "смену".');
            return false;
        }

        jQuery.ajax({
            url: '/ballast/shopballast/save',
            data: ({
                shop_ballast_car_id: (car),
                shop_ballast_driver_id: (driver),
                shop_ballast_crusher_id: (crusher),
                take_shop_ballast_crusher_id: (take),
                shop_ballast_distance_id: (distance),
                shop_work_shift_id: (workShift),
                is_storage: (is_storage),
                date: (date),
                json: (1),
                is_add: (1),
            }),
            type: "GET",
            success: function (data) {
                var obj = jQuery.parseJSON($.trim(data));
                parent = parent.find('[data-id="count"]');
                parent.html(obj.count);
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });

        return false;
    });
</script>
