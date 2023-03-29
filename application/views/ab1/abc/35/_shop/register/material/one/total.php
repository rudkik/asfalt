<?php $additionDatas = $data->getRoot()->additionDatas; ?>
<tr>
    <td><?php echo $data->getElementValue('shop_material_id'); ?></td>
    <?php foreach ($additionDatas['daughters'] as $key => $child){ ?>
        <td class="text-right"><?php $tmp = Arr::path($data->additionDatas['daughters'], $key, 0); if($tmp != 0){echo Func::getNumberStr($tmp, true, 3, false);} ?></td>
    <?php } ?>
    <td class="text-right total"><?php echo Func::getNumberStr($data->additionDatas['total_daughter'], true, 3, false); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['total_make'], true, 3, false); ?></td>
    <?php foreach ($additionDatas['receivers'] as $key => $child){ ?>
        <td class="text-right"><?php $tmp = Arr::path($data->additionDatas['receivers'], $key, 0); if($tmp != 0){echo Func::getNumberStr($tmp, true, 3, false);} ?></td>
    <?php } ?>
    <td class="text-right"><?php $tmp = $data->additionDatas['total_receiver']; echo Func::getNumberStr($tmp, true, 3, false); ?></td>
    <td class="text-right"><?php $tmp = $data->additionDatas['total_side']; if($tmp != 0){echo Func::getNumberStr($tmp, true, 3, false);} ?></td>
    <td class="text-right"><?php $tmp = $data->additionDatas['total_realization']; if($tmp != 0){echo Func::getNumberStr($tmp, true, 3, false);} ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->additionDatas['total'], true, 3, false); ?></td>
</tr>
