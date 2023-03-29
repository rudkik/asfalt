<?php
$panelID = 'bill-item-'.rand(0, 10000);
?>
<div class="card panel panel-default panel-table" style="overflow: auto;">
    <table data-id="rooms" class="table table-bordered table-items" style="min-width: 710px;">
        <thead class="thead-default">
        <tr>
            <th style="min-width: 180px;">Номер</th>
            <?php
            $dateFrom = Arr::path($additionDatas, 'date_from', NULL);
            if($dateFrom === NULL){
                $dateFrom = date('Y-m-d');
            }
            $dateTo = Arr::path($additionDatas, 'date_to', NULL);
            if($dateTo === NULL){
                $dateTo = date('Y-m-d', strtotime('1 months'));
            }

            $dateFrom = strtotime($dateFrom);
            $dateTo = strtotime($dateTo);
            while ($dateFrom <= $dateTo){
                echo '<th style="width: 135px;">'.strftime('%d.%m.%Y', $dateFrom).'</th>';
                $dateFrom = $dateFrom + 60 * 60 * 24;
            }
            ?>
        </tr>
        </thead>
        <tbody id="<?php echo $panelID; ?>-table-body" data-index="0">
        <?php
        foreach ($data['view::_shop/room/one/free']->childs as $value) {
            echo $value->str;
        }
        ?>
        </tbody>
    </table>
</div>
