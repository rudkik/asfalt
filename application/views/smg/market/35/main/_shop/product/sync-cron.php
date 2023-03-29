<div class="tab-pane active">
    <?php $siteData->titleTop = 'Запуск синхронизации с поставщиками'; ?>
</div>
<div class="body-table dataTables_wrapper ">
    <h2>Запуск каждые 7 минут</h2>
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
                url: '/market/shopproduct/cron_urls?is_auth=1',
                data: ({}),
                type: "GET",
                success: function (data) {
                    $('#' + id).html(data);
                    setTimeout(testCashBox, 420000);
                },
                error: function (data) {
                    console.log(data.responseText);
                    setTimeout(testCashBox, 420000);
                }
            });
        }

        setTimeout(testCashBox, 100);
    });
</script>