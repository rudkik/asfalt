<table class="table-input table table-hover table-db table-tr-line" data-action="table-select">
    <tr class="bg-light-blue-active">
        <th class="width-30 text-right">№</th>
        <th>Продукция</th>
        <th class="width-100 text-right">Кол-во</th>
        <th class="width-100 text-right">Цена</th>
        <th class="width-100 text-right">Сумма</th>
    </tr>
    <tbody id="products">
    <?php
    $data = $data['view::_shop/realization/return/item/one/invoice-new'];
    $i = 0;
    foreach ($data->childs as $value) {
        $i++;
        echo str_replace('#index#', $i, $value->str);
    }
    ?>
    <?php if(count($data->childs) > 0) {?>
    <tr>
        <td colspan="2" class="bg-light-blue-active b-green"></td>
        <td class="text-right bg-light-blue-active b-green"><?php echo Func::getNumberStr($data->additionDatas['quantity'], TRUE, 3, FALSE); ?></td>
        <td class="text-center bg-light-blue-active b-green">x</td>
        <td class="text-right bg-light-blue-active b-green"><?php echo Func::getNumberStr($data->additionDatas['amount'], TRUE, 2, FALSE); ?></td>
    </tr>
    <?php }?>
    </tbody>
</table>