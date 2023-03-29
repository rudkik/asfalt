<table class="table table-hover table-db table-tr-line" data-action="fixed">
    <tr>
        <th>Показатель расчета</th>
        <?php foreach ($data['view::_shop/transport/to/indicator/season/one/index']->additionDatas['seasons'] as $child){?>
        <th class="width-110"><?php echo $child['name']; ?></th>
        <?php } ?>
    </tr>
    <tbody id="to-indicators">
    <?php
    foreach ($data['view::_shop/transport/to/indicator/season/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>
    </tbody>
</table>