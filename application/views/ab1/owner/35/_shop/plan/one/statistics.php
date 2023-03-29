<?php $isRotate = count($data->additionDatas['shop_client_ids']) > 8; ?>
<h3><?php echo $data->values['title']; ?></h3>
<table class="table table-hover table-db table-tr-line" style="margin-bottom: 25px;">
    <tr>
        <th>Рубрика / Клиент</th>
        <?php foreach ($data->additionDatas['shop_client_ids'] as $client) { ?>
        <th <?php if($isRotate){ ?>class="rotate-270"<?php } ?>><div><?php echo $client; ?></div></th>
        <?php } ?>
    </tr>
    <?php foreach ($data->childs as $root) { ?>
        <tr style="background-color: rgba(97, 168, 206, 0.8);">
            <td><?php echo $root->values['name']; ?></td>
            <?php foreach ($root->additionDatas as $client) { ?>
                <td><?php echo Func::getNumberStr($client['quantity_plan'], TRUE, 0, FALSE) . ' / ' . Func::getNumberStr($client['quantity_realization'], TRUE, 0, FALSE); ?></td>
            <?php } ?>
        </tr>

        <?php foreach ($root->childs as $rubric) { ?>
            <tr style="background-color: rgba(197, 168, 206, 0.4);">
                <td style="padding-left: 20px;"><i class="fa fa-fw fa-plus" style="cursor: pointer;" data-action="show-tr" data-id="<?php echo $rubric->id.'_'.$data->values['date']; ?>"></i> <?php echo $rubric->values['name']; ?></td>
                <?php foreach ($rubric->additionDatas as $client) { ?>
                    <td><?php echo Func::getNumberStr($client['quantity_plan'], TRUE, 0, FALSE) . ' / ' . Func::getNumberStr($client['quantity_realization'], TRUE, 0, FALSE); ?></td>
                <?php } ?>
            </tr>

            <?php foreach ($rubric->childs as $product) { ?>
                <tr style="display: none;" data-child-id="<?php echo $rubric->id.'_'.$data->values['date']; ?>">
                    <td style="padding-left: 40px;"><?php echo $product->values['name']; ?></td>
                    <?php foreach ($product->additionDatas as $client) { ?>
                        <td><?php echo Func::getNumberStr($client['quantity_plan'], TRUE, 0, FALSE) . ' / ' . Func::getNumberStr($client['quantity_realization'], TRUE, 0, FALSE); ?></td>
                    <?php } ?>
                </tr>
            <?php } ?>
        <?php } ?>
    <?php } ?>
</table>
