<?php
$i = 0;
foreach ($data['view::_shop/turn/place/one/list-car']->childs as $value) {
    switch($i){
        case 0: $color = 'bg-aqua';break;
        case 1: $color = 'bg-green';break;
        case 2: $color = 'bg-yellow';break;
        case 3: $color = 'bg-red';break;
        case 4: $color = 'bg-purple';break;
        case 5: $color = 'bg-maroon';break;
        case 6: $color = 'bg-navy';break;
        case 7: $color = 'bg-orange';break;
    }
    $i++;

    echo str_replace('#color#', $color, $value->str);
}
?>
<script>
    $(function () {
        $('a[data-action="set-turn"]').click(function () {
            url = $(this).attr('href');
            jQuery.ajax({
                url: url,
                data: ({}),
                type: "POST",
                success: function (data) {
                    if (window.location.href.indexOf('/shopcar/index')> -1){
                        $('#dialog-entry-ok').modal('hide');
                    }else{
                        window.location.reload();
                    }
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });

            return false;
        });
    });
</script>
