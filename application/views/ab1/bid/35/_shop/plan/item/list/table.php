<?php
function getProductNames(array &$time, $isLeft = NULL){
    $result = '';
    if ($isLeft === NULL){
        foreach ($time['shop_product_name_left'] as $product => $quantity){
            $result .= $product . ' - ' . $quantity . 'т <br>';
        }
        foreach ($time['shop_product_name_right'] as $product => $quantity){
            $result .= $product . ' - ' . $quantity . 'т <br>';
        }
    }elseif ($isLeft){
        foreach ($time['shop_product_name_left'] as $product => $quantity){
            $result .= $product . ' - ' . $quantity . 'т <br>';
        }
    }else{
        foreach ($time['shop_product_name_right'] as $product => $quantity){
            $result .= $product . ' - ' . $quantity . 'т <br>';
        }
    }

    return $result;
}
?>
<link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/ab1/css/common.min.css">
<style>
    .bid-busy{
        width: 100%;
        float: left;
        height: 20px;
        background-color: #3c8dbc !important;
    }
    .bid-busy-left{
        float: left;
        height: 20px;
        background-color: #3c8dbc !important;
    }
    .bid-busy-right{
        float: right;
        height: 20px;
        background-color: #3c8dbc !important;
    }
    .table-items tr > td{
        padding: 8px 0px !important;
    }
    .table-items tr > td:first-child{
        padding: 8px !important;
    }
    .panel-table{
        overflow: auto;
        margin-top: 2px;
    }
</style>
<div class="card panel panel-default panel-table">
    <table class="table table-bordered table-items">
        <thead class="thead-default">
        <tr>
            <th>Клиент</th>
            <th>01:00</th>
            <th>02:00</th>
            <th>03:00</th>
            <th>04:00</th>
            <th>05:00</th>
            <th>06:00</th>
            <th>07:00</th>
            <th>08:00</th>
            <th>09:00</th>
            <th>10:00</th>
            <th>11:00</th>
            <th>12:00</th>
            <th>13:00</th>
            <th>14:00</th>
            <th>15:00</th>
            <th>16:00</th>
            <th>17:00</th>
            <th>18:00</th>
            <th>19:00</th>
            <th>20:00</th>
            <th>21:00</th>
            <th>22:00</th>
            <th>23:00</th>
            <th>24:00</th>
        </tr>
        </thead>
        <tbody data-index="0">
        <?php
        foreach ($clients as $client){ ?>
            <tr>
                <td><?php echo $client['name']; ?></td>
                <?php
                foreach ($client['time'] as $time){
                    if ($time === FALSE){
                    ?>
                        <td></td>
                    <?php }elseif((($time['minute_left'] == 60) && ($time['minute_right'] == 0))
                                    || (($time['minute_right'] == 60) && ($time['minute_left'] == 0))){ ?>
                        <td><div data-toggle="tooltip" title="<?php echo getProductNames($time); ?>" class="bid-busy"></div></td>
                    <?php }elseif($time['minute_right'] == 0){ ?>
                        <td><div data-toggle="tooltip" title="<?php echo getProductNames($time, TRUE); ?>" class="bid-busy-left" style="width: calc(100% / 60 * <?php echo $time['minute_left']; ?>);"></div></td>
                    <?php }elseif($time['minute_left'] == 0){ ?>
                        <td><div data-toggle="tooltip" title="<?php echo getProductNames($time, FALSE); ?>" class="bid-busy-right" style="width: calc(100% / 60 * <?php echo $time['minute_right']; ?>);"></div></td>
                    <?php }elseif($time['minute_left'] + $time['minute_right'] > 60){ ?>
                        <td>
                            <div data-toggle="tooltip" title="<?php echo getProductNames($time, TRUE); ?>" class="bid-busy-left" style="width: calc(100% / 60 * 30);"></div>
                            <div data-toggle="tooltip" title="<?php echo getProductNames($time, FALSE); ?>" class="bid-busy-right" style="width: calc(100% / 60 * 30);"></div>
                        </td>
                    <?php }else{ ?>
                        <td>
                            <div data-toggle="tooltip" title="<?php echo getProductNames($time, TRUE); ?>" class="bid-busy-left" style="width: calc(100% / 60 * <?php echo $time['minute_left']; ?>);"></div>
                            <div data-toggle="tooltip" title="<?php echo getProductNames($time, FALSE); ?>" class="bid-busy-right" style="width: calc(100% / 60 * <?php echo $time['minute_right']; ?>);"></div>
                        </td>
                    <?php } ?>
                <?php } ?>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip({
            html: true
        });
        $('[data-toggle="tooltip"]').click(function() {
            $(this).tooltip('show');
        });
    })
</script>
