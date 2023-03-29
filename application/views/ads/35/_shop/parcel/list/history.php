<div class="card panel panel-default panel-table" style="min-width: 100%;">
    <table class="table table-bordered table-items">
        <thead class="thead-default">
        <tr>
            <th>Описание</th>
            <th>Статус</th>
            <th>Создана</th>
            <th>Стоимость доставки</th>
            <th>Оплачено</th>
        </tr>
        </thead>
        <tbody id="history-parcel-table-body" data-index="0">
        <?php
        foreach ($data['view::_shop/parcel/one/history']->childs as $value) {
            echo $value->str;
        }
        ?>
        </tbody>
    </table>
</div>