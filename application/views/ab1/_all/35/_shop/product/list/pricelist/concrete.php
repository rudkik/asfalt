<div class="col-md-12">
<div class="row">
    <div class="col-md-12">

        <table class="table table-hover table-db table-tr-line" style="max-width: 800px">
            <thead>
            <tr>
                <th>Номенклатура</th>
                <th class="text-right">Цена за 1 куб.м. с НДС (тенге)</th>
                <th class="width-90 text-center">Цена актуально с</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 1;
            foreach ($data['view::_shop/product/one/pricelist/concrete']->childs as $value) {
                echo str_replace('#index#', $i++, $value->str);
            }
            ?>
            </tbody>
        </table>
        <table class="table table-hover table-db table-tr-line" style="margin-top: 30px; max-width: 800px">
            <thead>
            <tr class="bg-blue">
                <th colspan="3" class="text-center">Доставка</th>
            </tr>
            <tr>
                <th>Расстояние</th>
                <th class="text-right">Цена за 1 куб.м. с НДС (тенге)</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $deliveries = $data['view::_shop/product/one/pricelist/concrete']->additionDatas['deliveries'];
            foreach ($deliveries as $delivery) {
                ?>
                <tr>
                    <td><?php echo $delivery['distance']; ?></td>
                    <td class="text-right">
                        <?php
                        if(is_numeric($delivery['price'])){
                            echo Func::getNumberStr($delivery['price'], true, 0);
                        }else{
                            echo $delivery['price'];
                        }
                        ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</div>