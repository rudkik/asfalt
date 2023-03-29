<div class="tab-pane active">
    <?php $siteData->titleTop = 'Обновление цен'; ?>
</div>
<div class="body-table dataTables_wrapper ">
    <h2>Запуск каждые 10 минут</h2>
    <div id="result" class="box-body table-responsive" style="padding-top: 0px;">

    </div>
</div>

<script async>
    $(function(){
        var number = 0;

        var testCashBox=function(){
            number = number + 1;
            if(number > 50){
                $('#result').html('');
                number = 0;
            }

            var currentDate = new Date();
            var currentDate = currentDate.toLocaleDateString() + ' ' + currentDate.toLocaleTimeString();

            var id = (currentDate + Math.random()).replaceAll('.', '_').replaceAll(':', '_').replaceAll(' ', '_') ;

            $('#result').append('<div><h3 class="text-blue">Начато обновление в ' + currentDate + '</h3><div id="'+id+'"></div></div>');
            jQuery.ajax({
                url: '/smg/kaspi/get_price_streams?is_auth=1&shop_source_id=<?php echo Request_RequestParams::getParamInt('shop_source_id'); ?>&step=400',
                data: ({}),
                type: "GET",
                success: function (data) {
                    $('#' + id).html(data);
                    setTimeout(testCashBox, 600000);
                },
                error: function (data) {
                    console.log(data.responseText);
                    setTimeout(testCashBox, 600000);
                }
            });
        }

        setTimeout(testCashBox, 100);
    });
</script>