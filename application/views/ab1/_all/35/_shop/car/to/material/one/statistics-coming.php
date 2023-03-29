<h3><?php echo $data->additionDatas['title']; ?></h3>
<table class="table table-hover table-db table-tr-line" style="margin-bottom: 40px;">
    <tr>
        <th>Транспортная организация</th>
        <?php foreach ($data->additionDatas['daughters']['data'] as $daughter){ ?>
            <th <?php if(count($daughter['data']) > 1){?> colspan="<?php echo count($daughter['data']) + 1;?>" <?php }?> class="width-110 text-right"><?php echo $daughter['name']; ?></th>
        <?php } ?>
        <th rowspan="2" class="text-right">Общий итог</th>
        <th rowspan="2" class="text-right">Кол-во рейсов</th>
        <th rowspan="2" class="text-right">Кол-во машин</th>
    </tr>
    <tr>
        <th>Материалы</th>
        <?php foreach ($data->additionDatas['daughters']['data'] as $daughter){ ?>
            <?php foreach ($daughter['data'] as $material){ ?>
                <th class="text-right"><?php echo $material['name']; ?></th>
            <?php } ?>
            <?php if(count($daughter['data']) > 1){?>
                <th class="text-right">Итого</th>
            <?php }?>
        <?php } ?>
    </tr>
    <?php foreach ($data->additionDatas['materials']['data'] as $company){ ?>
    <tr>
        <td><?php echo $company['name']; ?></td>
        <?php foreach ($company['data'] as $daughter){ ?>
            <?php foreach ($daughter['data'] as $material){ ?>
                <td class="text-right">
                    <?php if($material['quantity'] != 0){?>
                        <?php echo $material['quantity']; ?>
                    <?php } ?>
                </td>
            <?php } ?>
            <?php if(count($daughter['data']) > 1){?>
                <td class="text-right">
                    <?php if($daughter['quantity'] != 0){?>
                        <?php echo $daughter['quantity']; ?>
                    <?php } ?>
                </td>
            <?php } ?>
        <?php } ?>
        <td class="text-right">
            <?php if($company['quantity'] != 0){?>
                <?php echo $company['quantity']; ?>
            <?php } ?>
        </td>
        <td class="text-right"><?php echo $company['count']; ?></td>
        <td class="text-right"><?php echo count($company['cars']); ?></td>
    </tr>
    <?php } ?>
</table>

