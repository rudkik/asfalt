<table class="table table-hover table-db table-tr-line" >
    <tr>
        <th rowspan="2">
            <a href="<?php echo Func::getFullURL($siteData, '/shopballastdriver/statistics'). Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Водитель</a>
        </th>
        <?php foreach ($data->additionDatas['crushers'] as $crusher) { ?>
            <th style="border-left: 1px solid #0000cc; border-right: 1px solid #0000cc" class="text-center" colspan="2">
                <?php echo $crusher; ?>
            </th>
        <?php } ?>
        <?php foreach ($data->additionDatas['places'] as $place) { ?>
            <th class="text-center" rowspan="2">
                <?php echo $place; ?>
            </th>
        <?php } ?>
        <th style="border-left: 1px solid #0000cc" class="text-center" colspan="2">
            Итоги
        </th>
    </tr>
    <tr>
        <?php foreach ($data->additionDatas['crushers'] as $crusher) { ?>
            <th style="border-left: 1px solid #0000cc" class="text-right">Кол-во</th>
            <th style="border-right: 1px solid #0000cc" class="text-right">Тоннаж</th>
        <?php } ?>
        <th style="border-left: 1px solid #0000cc" class="text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopballastdriver/statistics'). Func::getAddURLSortBy($siteData->urlParams, 'count'); ?>" class="link-black">Кол-во</a>
        </th>
        <th class="text-right">
            <a href="<?php echo Func::getFullURL($siteData, '/shopballastdriver/statistics'). Func::getAddURLSortBy($siteData->urlParams, 'quantity'); ?>" class="link-black">Тоннаж</a>
        </th>
    </tr>
    <?php foreach ($data->values['data'] as $driver) { ?>
        <tr>
            <td><?php echo $driver['name']; ?></td>
            <?php foreach ($data->additionDatas['crushers'] as $crusher => $s) { ?>
                <td style="border-left: 1px solid #0000cc" class="text-right"><?php echo Func::getNumberStr(Arr::path($driver['crushers'], $crusher.'.count', ''), true, 0); ?></td>
                <td style="border-right: 1px solid #0000cc" class="text-right"><?php echo Func::getNumberStr(Arr::path($driver['crushers'], $crusher.'.quantity', ''), true, 0); ?></td>
            <?php } ?>
            <?php foreach ($data->additionDatas['places'] as $place => $s) { ?>
                <td class="text-right"><?php echo Func::getNumberStr(Arr::path($driver['places'], $place.'.count', ''), true, 0); ?></td>
            <?php } ?>
            <th style="border-left: 1px solid #0000cc" class="text-right"><?php echo Func::getNumberStr($driver['count'], true, 0); ?></td>
            <th class="text-right"><?php echo Func::getNumberStr($driver['quantity'], true, 0); ?></td>
        </tr>
    <?php } ?>
</table>
