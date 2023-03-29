<?php
if(key_exists('shop_products', $data->additionDatas)) {
    $shopProducts = $data->additionDatas['shop_products'];
}else{
    $shopProducts = array();
}

$fields = $data->additionDatas['fields'];
?>
<?php if(count($shopProducts) > 0){?>
    <table class="table table-hover table-bordered">
        <tr>
            <?php foreach ($fields as $name){ ?>
                <th>
                    <?php
                    switch ($name){
                        case 'integration':
                            $name = 'Поле поиска';
                            break;
                        case 'article':
                            $name = 'Артикул';
                            break;
                        case 'shop_brand_id.name':
                            $name = 'Бренд';
                            break;
                        case 'name':
                            $name = 'Название';
                            break;
                        case 'tnved':
                            $name = 'Код ТНВЭД';
                            break;
                        case 'quantity':
                            $name = 'Количество на складе';
                            break;
                        case 'text':
                            $name = 'Описание';
                            break;
                        case 'price_cost':
                            $name = 'Себестоимость';
                            break;
                        case 'price':
                            $name = 'Цена продажи';
                            break;
                        case 'barcode':
                            $name = 'Штрихкод';
                            break;
                    }
                    echo $name;
                    ?>
                </th>
            <?php }?>
            <th class="width-80"></th>
        </tr>
        <tbody>
        <?php foreach ($shopProducts as $index => $shopProduct){?>
            <tr>
                <?php foreach ($fields as $name){ ?>
                    <td>
                        <?php if ($name == 'text'){ ?>
                            <textarea name="shop_products[<?php echo $index;?>][text]" class="form-control"><?php echo htmlspecialchars(Arr::path($shopProduct, $name, ''), ENT_QUOTES);?></textarea>
                        <?php }else{ ?>
                            <input name="shop_products[<?php echo $index;?>][<?php echo $name;?>]" type="text" class="form-control" value="<?php echo htmlspecialchars(Arr::path($shopProduct, $name, '', '#'), ENT_QUOTES);?>">
                        <?php } ?>
                    </td>
                <?php }?>
                <td>
                    <ul class="list-inline tr-button delete">
                        <li class="tr-remove"><a data-action="remove-tr" href="#" data-parent-count="4" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                    </ul>
                </td>
            </tr>
        <?php }?>
        </tbody>
    </table>
<?php }?>