<table class="table table-hover table-db table-tr-line" >
    <tr>
        <th>Таблица</th>
        <th style="width: 155px;"></th>
    </tr>
    <?php
    foreach ($data['view::record-db/one/table']->childs as $value) {
        echo $value->str;
    }
    ?>
</table>

