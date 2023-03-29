<div class="col-md-12">
<div class="row">
    <div class="col-md-12">
        <table class="table table-hover table-db table-tr-line" style="max-width: 1100px;">
            <thead>
            <tr class="bg-blue">
                <th colspan="5" class="text-center">Асфальтобетон</th>
            </tr>
            <tr>
                <th rowspan="2" class="text-right width-40">№</th>
                <th rowspan="2">Номенклатура</th>
                <th colspan="2" class="text-center">Цена за 1 тонну с НДС (тенге)</th>
                <th rowspan="2" class="width-90 text-center">Цена актуально с</th>
            </tr>
            <tr>
                <th class="width-100 text-center">Алматы</th>
                <th class="width-100 text-center">Алм. Область</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 1;
            foreach ($data['view::_shop/product/one/pricelist/asfalt']->childs as $value) {
                echo str_replace('#index#', $i++, $value->str);
            }
            ?>
            </tbody>
        </table>
    </div>
    <div class="col-md-12">
        <table class="table table-hover table-db table-tr-line" style="margin-top: 30px; max-width: 800px">
            <thead>
            <tr class="bg-blue">
                <th colspan="3" class="text-center">Доставка</th>
            </tr>
            <tr>
                <th>Расстояние</th>
                <th class="text-right width-140">День (06:00 - 21:00)</th>
                <th class="text-right width-140">Ночь (21:00 – 06:00)</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $deliveries = $data['view::_shop/product/one/pricelist/asfalt']->additionDatas['deliveries'];
            foreach ($deliveries as $delivery) {
                ?>
                <tr>
                    <td><?php echo $delivery['distance']; ?></td>
                    <td class="text-right">
                        <?php echo $delivery['time1']['price']; ?> <?php echo $delivery['time1']['unit']; ?>
                    </td>
                    <td class="text-right">
                        <?php echo $delivery['time2']['price']; ?> <?php echo $delivery['time2']['unit']; ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</div>