<?php //print_r($data);die; $data = $data['view::fuel/one/statistics']; ?>
<table class="table table-hover table-db table-tr-line" >
    <tr>
        <th class="width-140">
            В литрах</th>
        <?php foreach ($data->childs as $child) { ?>
            <th class="text-right width-80">
                <?php echo $child->getElementValue('fuel_id'); ?>
            </th>
        <?php } ?>
    </tr>
    <tr>
        <td>Входящий остаток на 1 января</td>
        <?php foreach ($data->childs as $child) { ?>
            <td class="text-right">
                <?php echo Func::getNumberStr(round($child->additionDatas['total_year']), TRUE, 3); ?>
            </td>
        <?php } ?>
    </tr>
    <tr>
        <td>Оплачено</td>
        <?php foreach ($data->childs as $child) { ?>
            <td class="text-right"><?php echo Func::getNumberStr(round($child->additionDatas['paid']), TRUE, 3); ?></td>
        <?php } ?>
    </tr>
    <tr>
        <td>Поступило</td>
        <?php foreach ($data->childs as $child) { ?>
            <td class="text-right"><?php echo Func::getNumberStr(round($child->additionDatas['issue']), TRUE, 3); ?></td>
        <?php } ?>
    </tr>
    <tr>
        <td>Выдано</td>
        <?php foreach ($data->childs as $child) { ?>
            <td class="text-right">
                <a href="<?php echo Func::getFullURL($siteData, '/shoptransportwaybillfuelexpense/statistics', array('fuel_id' => 'fuel_id'), array('shop_branch_id' => $siteData->shopID), $child->values); ?>">
                    <?php echo Func::getNumberStr(round($child->additionDatas['expense']), TRUE, 3); ?>
                </a>
            </td>
        <?php } ?>
    </tr>
    <tr>
        <td>Перемещено (подразделение)</td>
        <?php foreach ($data->childs as $child) { ?>
            <td class="text-right">
                <a href="<?php echo Func::getFullURL($siteData, '/shoptransportfuelexpense/statistics', array('fuel_id' => 'fuel_id'), array('shop_branch_id' => $siteData->shopID), $child->values); ?>">
                    <?php echo Func::getNumberStr(round($child->additionDatas['expense_department']), TRUE, 3); ?>
                </a>
            </td>
        <?php } ?>
    </tr>
    <tr>
        <td>Остаток на текущую дату</td>
        <?php foreach ($data->childs as $child) { ?>
            <td class="text-right">
                    <?php echo Func::getNumberStr(round($child->additionDatas['total_current']), TRUE, 3); ?>
            </td>
        <?php } ?>
    </tr>
</table>

