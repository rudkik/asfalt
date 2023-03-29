<?php
$panelID = 'act-revise-item-'.rand(0, 10000);
?>
<input name="shop_act_revise_items[0][]" value="" style="display: none">
<div class="col-lg-12">
    <div class="card panel panel-default panel-table">
        <table class="table table-bordered table-items">
            <thead class="thead-default">
            <tr>
                <th style="width: 70px;">Дата</th>
                <th>Название</th>
                <th style="width: 120px;">Дебет</th>
                <th style="width: 120px;">Кредит</th>
            </tr>
            </thead>
            <tbody id="<?php echo $panelID; ?>-table-body" data-index="0">
            <?php if (count($data['view::_shop/act/revise/item/one/index']->childs) > 0) { ?>
                <tr>
                    <td>
                    </td>
                    <td style="font-weight: bold; text-align: right">
                        Итого
                    </td>
                    <td>
                        <?php echo Func::getNumberStr($data['view::_shop/act/revise/item/one/index']->additionDatas['debit'], TRUE, 2); ?>
                    </td>
                    <td>
                        <?php echo Func::getNumberStr($data['view::_shop/act/revise/item/one/index']->additionDatas['credit'], TRUE, 2); ?>
                    </td>
                </tr>
                <?php
                foreach ($data['view::_shop/act/revise/item/one/index']->childs as $value) {
                    echo $value->str;
                }
                ?>
                <tr>
                    <td>
                    </td>
                    <td style="font-weight: bold; text-align: right">
                        Итого
                    </td>
                    <td>
                        <?php echo Func::getNumberStr($data['view::_shop/act/revise/item/one/index']->additionDatas['debit'], TRUE, 2); ?>
                    </td>
                    <td>
                        <?php echo Func::getNumberStr($data['view::_shop/act/revise/item/one/index']->additionDatas['credit'], TRUE, 2); ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>