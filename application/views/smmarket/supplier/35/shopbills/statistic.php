<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom pull-left">
            <ul class="nav nav-tabs ui-sortable-handle">
                <li><a href="/supplier/shopbill/index<?php $tmp = Request_RequestParams::getParamInt('shop_branch_id'); if($tmp > 0){echo '&shop_branch_id='.$tmp;} ?>">Все</a></li>
                <li><a href="/supplier/shopbill/index?shop_bill_status_id=1,3,4,5,8<?php $tmp = Request_RequestParams::getParamInt('shop_branch_id'); if($tmp > 0){echo '&shop_branch_id='.$tmp;} ?>">Текущие</a></li>
                <li><a href="/supplier/shopbill/index?shop_bill_status_id=2,4,6,7,9<?php $tmp = Request_RequestParams::getParamInt('shop_branch_id'); if($tmp > 0){echo '&shop_branch_id='.$tmp;} ?>">Старые</a></li>
                <li class="active"><a href="/supplier/shopbill/statistic<?php $tmp = Request_RequestParams::getParamInt('shop_branch_id'); if($tmp > 0){echo '&shop_branch_id='.$tmp;} ?>">Статистика продаж</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom">
            <ul id="tab-button" class="nav nav-tabs pull-right">
                <li class="active"><a href="#" onclick="$('#tab-button li').removeAttr('class'); $(this).parent().attr('class', 'active'); area.xLabels = 'day'; area.calc(); return false;">День</a></li>
              <!--  <li><a href="#"  onclick="$('#tab-button li').removeAttr('class'); $(this).parent().attr('class', 'active'); area.xLabels = 'month'; area.calc(); return false;">Месяц</a></li>
                <li><a href="#"  onclick="$('#tab-button li').removeAttr('class'); $(this).parent().attr('class', 'active'); area.xLabels = 'decade'; area.calc(); return false;">Квартал</a></li>
                <li><a href="#"  onclick="$('#tab-button li').removeAttr('class'); $(this).parent().attr('class', 'active'); area.xLabels = 'year'; area.calc(); return false;">Год</a></li>-->
            </ul>
            <div class="tab-content no-padding">
                <div class="chart tab-pane active" id="chart-day" style="position: relative; height: 300px;"></div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/morris/morris.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/morris/morris.min.js"></script>

<script>
    var area = new Morris.Area({
        element: 'chart-day',
        resize: true,
        data: [
            <?php
            foreach ($data['view::shopbill/statistic']->childs as $value) {
                echo $value->str;
            }
            ?>
        ],
        xkey: 'y',
        ykeys: ['count', 'amount'],
        labels: ['Количество', 'Сумма'],
        lineColors: ['#a0d0e0', '#3c8dbc'],
        hideHover: 'auto',
        xLabels: 'day'
    });
</script>