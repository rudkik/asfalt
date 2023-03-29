<tr>
    <td><?php echo Helpers_DateTime::getDateFormatRus($data->additionDatas['_date']); ?></td>
    <td>
        <?php
        $title = $data->values['name'] . ' ' . $data->values['old_id'] . ' (' . Helpers_DateTime::getDateFormatRus($data->additionDatas['_date']) . ')';

        $url = '';
        switch ($data->additionDatas['table_id']){
            case Model_Ab1_Shop_Invoice::TABLE_ID:
                $url = 'shopinvoice';
                break;
            case Model_Ab1_Shop_Act_Service::TABLE_ID:
                $url = 'shopactservice';
                break;
            case Model_Ab1_Shop_Payment::TABLE_ID:
                $url = 'shoppayment';
                break;

        }
        if($url == ''){
            echo $title;
        }else{ ?>
            <a target="_blank" href="<?php echo Func::getFullURL($siteData, '/'.$url.'/edit', array(), array('id' => $data->id, 'shop_branch_id' => $data->values['shop_id'], 'is_show' => true)); ?>"><?php echo $title; ?></a>
        <?php } ?>
    </td>
    <td class="text-right"><?php
        if(!empty($data->additionDatas['receive'])){
            echo Func::getNumberStr($data->additionDatas['receive'], TRUE, 2, FALSE);
        }
        ?></td>
    <td class="text-right"><?php
        if(!empty($data->additionDatas['expense'])){
            echo Func::getNumberStr($data->additionDatas['expense'], TRUE, 2, FALSE);
        }
        ?></td>
    <td class="text-right"><?php
        if(!empty($data->additionDatas['expense'])){
            echo Func::getNumberStr($data->additionDatas['expense'], TRUE, 2, FALSE);
        }
        ?></td>
    <td class="text-right"><?php
        if(!empty($data->additionDatas['receive'])){
            echo Func::getNumberStr($data->additionDatas['receive'], TRUE, 2, FALSE);
        }
        ?></td>
    <?php if(empty($data->additionDatas['receive_balance'] - $data->additionDatas['expense_balance'])){ ?>
        <td class="text-right"></td>
        <td class="text-right"></td>
    <?php }elseif(!empty($data->additionDatas['receive_balance'] > $data->additionDatas['expense_balance'])){ ?>
        <td class="text-right">
            <?php echo Func::getNumberStr(
                $data->additionDatas['receive_balance'] - $data->additionDatas['expense_balance'],
                TRUE, 2, FALSE
            ); ?>
        </td>
        <td class="text-right"></td>
    <?php }else{ ?>
        <td class="text-right"></td>
        <td class="text-right">
            <?php echo Func::getNumberStr(
                $data->additionDatas['expense_balance'] - $data->additionDatas['receive_balance'],
                TRUE, 2, FALSE
            ); ?>
        </td>
    <?php } ?>
    <td><?php echo $data->getElementValue('shop_id'); ?></td>
</tr>
