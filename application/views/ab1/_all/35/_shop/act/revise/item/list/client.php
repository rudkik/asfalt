<table class="table table-hover table-db table-tr-line" style="max-width: 1250px;">
    <tr>
        <th rowspan="2" class="width-80">Дата</th>
        <th rowspan="2" >Название</th>
        <th colspan="2" class="text-center">Асфальтобетон</th>
        <th colspan="2" class="text-center">Клиент</th>
        <th colspan="2" class=" text-center">Задолженность за</th>
        <th rowspan="2" style="width: 200px">Филиал</th>
    </tr>
    <tr>
        <th class="width-110 text-center">Приход</th>
        <th class="width-110 text-center">Расход</th>
        <th class="width-110 text-center">Приход</th>
        <th class="width-110 text-center">Расход</th>
        <th class="width-115 text-center">Асфальтобетон</th>
        <th class="width-115 text-center">Клиент</th>
    </tr>
    <?php $list = $data['view::_shop/act/revise/item/one/client']; ?>
    <tr class="box-total">
        <td></td>
        <td>Итоги на <?php echo Helpers_DateTime::getDateFormatRus($list->additionDatas['date_from']); ?></td>
        <td class="text-right"></td>
        <td class="text-right"></td>
        <td class="text-right"></td>
        <td class="text-right"></td>
        <td class="text-right"><?php
            if(!empty($list->additionDatas['receive'])){
                echo Func::getNumberStr($list->additionDatas['receive'], TRUE, 2, FALSE);
            }
            ?></td>
        <td class="text-right"><?php
            if(!empty($list->additionDatas['expense'])){
                echo Func::getNumberStr($list->additionDatas['expense'], TRUE, 2, FALSE);
            }
            ?></td>
        <td></td>
    </tr>
    <?php
    foreach ($data['view::_shop/act/revise/item/one/client']->childs as $value) {
        echo $value->str;
    }
    ?>
    <tr class="box-total">
        <td></td>
        <td>Итоги на <?php echo Helpers_DateTime::getDateFormatRus($list->additionDatas['date_to']); ?></td>
        <td class="text-right"><?php
            if(!empty($list->additionDatas['receive_balance'] - $list->additionDatas['receive'])){
                echo Func::getNumberStr($list->additionDatas['receive_balance'] - $list->additionDatas['receive'], TRUE, 2, FALSE);
            }
            ?></td>
        <td class="text-right"><?php
            if(!empty($list->additionDatas['expense_balance'] - $list->additionDatas['expense'])){
                echo Func::getNumberStr($list->additionDatas['expense_balance'] - $list->additionDatas['expense'], TRUE, 2, FALSE);
            }
            ?></td>
        <td class="text-right"><?php
            if(!empty($list->additionDatas['expense_balance'] - $list->additionDatas['expense'])){
                echo Func::getNumberStr($list->additionDatas['expense_balance'] - $list->additionDatas['expense'], TRUE, 2, FALSE);
            }
            ?></td>
        <td class="text-right"><?php
            if(!empty($list->additionDatas['receive_balance'] - $list->additionDatas['receive'])){
                echo Func::getNumberStr($list->additionDatas['receive_balance'] - $list->additionDatas['receive'], TRUE, 2, FALSE);
            }
            ?></td>
        <td class="text-right"><?php
            if($list->additionDatas['receive_balance'] > $list->additionDatas['expense_balance']){
                echo Func::getNumberStr($list->additionDatas['receive_balance'] - $list->additionDatas['expense_balance'], TRUE, 2, FALSE);
            }
            ?></td>
        <td class="text-right"><?php
            if($list->additionDatas['expense_balance'] > $list->additionDatas['receive_balance']){
                echo Func::getNumberStr($list->additionDatas['expense_balance'] - $list->additionDatas['receive_balance'], TRUE, 2, FALSE);
            }
            ?></td>
        <td></td>
    </tr>

</table>
<style>
    td{
        border-right: 1px solid #ccc;
        border-left: 1px solid #ccc;
    }
</style>

