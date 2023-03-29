<?php
/** @var MyArray $data */
/** @var SitePageData $siteData */
//print_r($data);die;

$dateFrom = Request_RequestParams::getParamDate('date_from');
$dateTo = Request_RequestParams::getParamDate('date_to');
?>
<tr>
    <td>#index#</td>
    <td><?php echo $data->getElementValue('shop_transport_driver_id'); ?></td>
    <td><?php echo $data->getElementValue('shop_transport_driver_id', 'number'); ?></td>
    <td><?php echo $data->getElementValue('shop_transport_id', 'number'); ?></td>
    <?php
    $dateBegin = $dateFrom;
    while (strtotime($dateBegin) <= strtotime($dateTo)){
    ?>
    <td colspan="<?php
    $across = 0;
    if(key_exists($dateBegin, $data->childs)) {
        $day = $data->childs[$dateBegin];
        $fromAt = strtotime(Helpers_DateTime::plusDays(Helpers_DateTime::getDateFormatPHP($day->getElementValue('shop_transport_waybill_id', 'from_at')), 1));
        $toAt = strtotime($day->getElementValue('shop_transport_waybill_id', 'to_at'));

        for ($j = $fromAt; $j < $toAt; $j += 24 * 60 * 60){
            if(key_exists(date('Y-m-d', $j), $transport->childs)) {
                break;
            }

            $across++;
        }
    }
    echo $across;
    ?>"><?php
        if(key_exists($dateBegin, $transport->childs)) {
            $day = $transport->childs[$dateBegin];

            $s = '';
            foreach ($works as $work) {
                $quantity = Arr::path($day->childs, $work['id']);
                if ($quantity == null) {
                    continue;
                }
                $s .= trim(htmlspecialchars($work['name'], ENT_QUOTES) . ' ' . $quantity->values['quantity']) . '<br/>';
            }
            echo substr($s, 0,-5);
        }
        $dateBegin = Helpers_DateTime::getDateFormatPHP(Helpers_DateTime::plusDays($dateBegin, $across + 1));
        ?></td>
    <td class="text-right"><?php echo $data->additionDatas['hours']; ?></td>
    <td class="text-right"><?php echo $data->additionDatas['days']; ?></td>
    <?php foreach ($works as $work){ ?>
    <td class="text-right"><?php $quantity = Arr::path($data->additionDatas['works'], $work['id'], 0); if($quantity != 0){ echo $quantity; } ?></td>
    <?php } }?>
</tr>