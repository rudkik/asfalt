<div class="col-md-12">
<div class="row">
    <div class="col-md-12">
        <table class="table table-hover table-db table-tr-line" style="max-width: 1200px;">
            <thead>
            <tr class="bg-blue">
                <th colspan="4" class="text-center">Битум</th>
            </tr>
            <tr>
                <th class="text-right width-40">№</th>
                <th>Номенклатура</th>
                <th class="text-center">Цена за 1 тонну с НДС (тенге)</th>
                <th class="width-90 text-center">Цена актуально с</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 1;
            foreach ($data['view::_shop/product/one/pricelist/bitumen']->childs as $value) {
                echo str_replace('#index#', $i++, $value->str);
            }
            ?>
            </tbody>
        </table>
    </div>
    <div class="col-md-12">
        <table class="table table-hover table-db table-tr-line" style="margin-top: 30px; max-width: 900px">
            <thead>
            <tr class="bg-blue">
                <th colspan="7" class="text-center">Доставка</th>
            </tr>
            <tr>
                <th>№</th>
                <th>Расстояние (км)</th>
                <th class="width-100 text-right">Цена за 1 тонну <br>с НДС (тенге)</th>
                <th style="width: 18px"></th>
                <th>№</th>
                <th>Расстояние (км)</th>
                <th class="width-100 text-right">Цена за 1 тонну <br>с НДС (тенге)</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $deliveries = $data['view::_shop/product/one/pricelist/bitumen']->additionDatas['deliveries'];
            $i = 1;
            foreach ($deliveries as $delivery) {
                ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $delivery['distance_1']; ?></td>
                    <td class="text-right">
                        <?php echo $delivery['price_1']; ?>
                    </td>
                    <td style="background: rgba(60, 141, 188, 0.3);"></td>
                    <td><?php echo ($i++) + count($deliveries); ?></td>
                    <td><?php echo $delivery['distance_2']; ?></td>
                    <td class="text-right">
                        <?php echo $delivery['price_2']; ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</div>