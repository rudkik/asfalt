<div class="col-md-12">
<div class="row">
    <div class="col-md-12">
        <table class="table table-hover table-db table-tr-line" style="max-width: 900px;">
            <thead>
            <tr class="bg-blue">
                <th colspan="5" class="text-center">Каменные материалы</th>
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
            foreach ($data['view::_shop/product/one/pricelist/stone-material']->childs as $value) {
                echo str_replace('#index#', $i++, $value->str);
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
</div>