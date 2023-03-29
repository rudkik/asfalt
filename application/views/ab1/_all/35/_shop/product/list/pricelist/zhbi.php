<div class="col-md-12">
<div class="row">
    <div class="col-md-12">
        <table class="table table-hover table-db table-tr-line" style="max-width: 900px;">
            <thead>
            <tr>
                <th>Номенклатура</th>
                <th class="text-right">Цена за 1 шт. с НДС (тенге)</th>
                <th class="text-right">Вес (кг)</th>
                <th class="text-right">Размеры (м)</th>
                <th class="text-right">Объем изделия (м3)</th>
                <th class="width-90 text-center">Цена актуально с</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 1;
            foreach ($data['view::_shop/product/one/pricelist/zhbi']->childs as $value) {
                echo str_replace('#index#', $i++, $value->str);
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
</div>

