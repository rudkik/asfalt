<div class="card panel panel-default panel-table" style="min-width: 100%;">
    <table class="table table-bordered table-items">
        <thead class="thead-default">
        <tr>
            <th>№ счета</th>
            <th>№ посылки</th>
            <th>Сумма</th>
            <th>Оплата</th>
        </tr>
        </thead>
        <tbody id="history-invoice-table-body" data-index="0">
        <?php
        foreach ($data['view::_shop/invoice/one/history']->childs as $value) {
            echo $value->str;
        }
        ?>
        </tbody>
    </table>
</div>