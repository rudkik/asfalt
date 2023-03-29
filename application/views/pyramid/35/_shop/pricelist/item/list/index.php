<?php
$panelID = 'pricelist-item-'.rand(0, 10000);
?>

<div class="col-lg-12">
    <div class="card panel panel-default panel-table">
        <table class="table table-bordered table-items">
            <thead class="thead-default">
            <tr>
                <th>Комната</th>
                <th style="width: 120px;">Цена</th>
                <th style="width: 120px;">Цена в праздник</th>
                <th style="width: 93px;">Цена взрослого</th>
                <th style="width: 110px;">Цена детского</th>
            </tr>
            </thead>
            <tbody id="<?php echo $panelID; ?>-table-body" data-index="0">
            <?php
            foreach ($data['view::_shop/pricelist/item/one/index']->childs as $value) {
                echo $value->str;
            }
            ?>
            </tbody>
        </table>
    </div>
</div>