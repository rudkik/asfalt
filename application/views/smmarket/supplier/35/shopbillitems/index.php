<table class="table table-hover">
    <thead>
    <tr>
        <th>Наименование товара</th>
        <th class="tr-header-number"><span style="font-size: 10px">Первонач.</span><br>кол-во</th>
        <th class="tr-header-count">Кол-во</th>
        <th class="tr-header-amount">Цена</th>
        <th class="tr-header-amount">Итого</th>
        <th class="tr-header-buttom"></th>
    </tr>
    </thead>
    <tbody id="list-goods">
    <?php
    foreach ($data['view::shopbillitem/index']->childs as $value) {
        echo $value->str;
    }
    ?>
    </tbody>
</table>
