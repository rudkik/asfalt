<?php
/** @var MyArray $data */
$data = $data['view::_shop/transport/waybill/one/index'];

$dateFrom = Request_RequestParams::getParamDate('date_from');
$dateTo = Request_RequestParams::getParamDate('date_to');
?>
<table class="table table-hover table-db table-tr-line" >
    <tr>
        <th class="width-60" rowspan="2">№</th>
        <th class="width-150" rowspan="2">Водитель</th>
        <th class="width-150" rowspan="2">Табельный номер</th>
        <th class="width-90" rowspan="2">Гос. номер</th>
        <th class="text-center" colspan="">Отметки о явках и неявках на работу по числам месяца</th>
        <th class="text-center" colspan="<?php count($data->additionDatas['works']); ?>">Итого за период</th>
    </tr>
    <tr>
        <?php
        $dateBegin = $dateFrom;
        while (strtotime($dateBegin) <= strtotime($dateTo)){ ?>
            <th class="width-60"><?php echo Helpers_DateTime::getDay($dateBegin); $dateBegin = Helpers_DateTime::plusDays($dateBegin, 1); ?></th>
        <?php } ?>
        <?php foreach ($data->additionDatas['works'] as $work){?>
            <th class="text-right width-60"><?php echo $work['name'];?></th>
        <?php }?>
    </tr>
    <?php
    foreach ($data->childs as $value) {
        echo $value->str;
    }
    ?>
</table>

