<?php
$isNew = Request_RequestParams::getParamBoolean('is_new');
$isOld = Request_RequestParams::getParamBoolean('is_old');

$options = $data->values['options'];
function keyExists($name, array &$options){
    $result = FALSE;
    foreach($options as $option){
        if($option['field'] == $name){
            $result = TRUE;
            break;
        }
    }

    return $result;
}
?>
<table class="table table-hover table-db">
    <tr>
        <th style="width: 30px">№</th>
        <?php if(keyExists('is_public', $options)){?>
            <th style="width: 200px">
                <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoploadfile/index_data<?php echo Func::getAddURLSortBy($siteData->urlParams, 'is_public'); ?>" class="link-black">Опуб.</a>
                <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoploadfile/index_data<?php echo Func::getAddURLSortBy($siteData->urlParams, 'is_public'); ?>" class="link-blue">
                    <i class="fa fa-fw fa-sort-alpha-<?php if (Arr::path($siteData->urlParams, 'sort_by.is_public', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
                </a>
            </th>
        <?php } ?>
        <?php if(keyExists('collations', $options)){?>
            <th style="width: 200px">
                <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoploadfile/index_data<?php echo Func::getAddURLSortBy($siteData->urlParams, 'collations'); ?>" class="link-black">Сопоставление</a>
                <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoploadfile/index_data<?php echo Func::getAddURLSortBy($siteData->urlParams, 'collations'); ?>" class="link-blue">
                    <i class="fa fa-fw fa-sort-alpha-<?php if (Arr::path($siteData->urlParams, 'sort_by.collations', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
                </a>
            </th>
        <?php } ?>
        <?php if(keyExists('old_id', $options)){?>
            <th style="width: 200px">
                <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoploadfile/index_data<?php echo Func::getAddURLSortBy($siteData->urlParams, 'old_id'); ?>" class="link-black">ID</a>
                <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoploadfile/index_data<?php echo Func::getAddURLSortBy($siteData->urlParams, 'old_id'); ?>" class="link-blue">
                    <i class="fa fa-fw fa-sort-alpha-<?php if (Arr::path($siteData->urlParams, 'sort_by.old_id', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
                </a>
            </th>
        <?php } ?>
        <?php if(keyExists('article', $options)){?>
            <th style="width: 200px">
                <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoploadfile/index_data<?php echo Func::getAddURLSortBy($siteData->urlParams, 'article'); ?>" class="link-black">Артикул</a>
                <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoploadfile/index_data<?php echo Func::getAddURLSortBy($siteData->urlParams, 'article'); ?>" class="link-blue">
                    <i class="fa fa-fw fa-sort-alpha-<?php if (Arr::path($siteData->urlParams, 'sort_by.article', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
                </a>
            </th>
        <?php } ?>
        <?php if(keyExists('name', $options)){?>
            <th style="width: 200px">
                <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoploadfile/index_data<?php echo Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">Название</a>
                <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoploadfile/index_data<?php echo Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-blue">
                    <i class="fa fa-fw fa-sort-alpha-<?php if (Arr::path($siteData->urlParams, 'sort_by.name', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
                </a>
            </th>
        <?php } ?>
        <?php if(keyExists('price', $options)){?>
            <th style="width: 200px">
                <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoploadfile/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'price'); ?>" class="link-black">Цена</a>
                <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoploadfile/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'price'); ?>" class="link-blue">
                    <i class="fa fa-fw fa-sort-numeric-<?php if (Arr::path($siteData->urlParams, 'sort_by.price', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
                </a>
            </th>
        <?php } ?>
        <?php if(keyExists('price_old', $options)){?>
            <th style="width: 200px">
                <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoploadfile/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'price_old'); ?>" class="link-black">Старая цена</a>
                <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoploadfile/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'price_old'); ?>" class="link-blue">
                    <i class="fa fa-fw fa-sort-numeric-<?php if (Arr::path($siteData->urlParams, 'sort_by.price_old', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
                </a>
            </th>
        <?php } ?>
        <?php if(keyExists('shop_good_unit_type_id', $options)){?>
            <th style="width: 200px">
                <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoploadfile/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'shop_good_unit_type_id'); ?>" class="link-black">Единица измерения</a>
                <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoploadfile/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'shop_good_unit_type_id'); ?>" class="link-blue">
                    <i class="fa fa-fw fa-sort-alpha-<?php if (Arr::path($siteData->urlParams, 'sort_by.shop_good_unit_type_id', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
                </a>
            </th>
        <?php } ?>
        <?php
        $objOptions = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_catalog_id.options', array());
        if (!is_array($objOptions)){
            $objOptions = array();
        }
        foreach($objOptions as $objOption) {
            $field = 'options.'.$objOption['field'];
            if(keyExists($field, $options)){
                ?>
                <th style="width: 200px">
                    <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoploadfile/index<?php echo Func::getAddURLSortBy($siteData->urlParams, $field); ?>" class="link-black"><?php echo $objOption['title']; ?></a>
                    <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoploadfile/index<?php echo Func::getAddURLSortBy($siteData->urlParams, $field); ?>" class="link-blue">
                        <i class="fa fa-fw fa-sort-alpha-<?php if (Arr::path($siteData->urlParams, 'sort_by.'.$field, '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
                    </a>
                </th>
                <?php
            }
        } ?>
        <?php if(keyExists('info', $options)){?>
            <th style="width: 200px">
                <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoploadfile/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'info'); ?>" class="link-black">Описание</a>
                <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoploadfile/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'info'); ?>" class="link-blue">
                    <i class="fa fa-fw fa-sort-alpha-<?php if (Arr::path($siteData->urlParams, 'sort_by.info', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
                </a>
            </th>
        <?php } ?>
        <th style="width: 200px">Товар в БД</th>
        <th class="tr-header-buttom"></th>
    </tr>

    <?php
    $count = 0;
    foreach ($data->values['data'] as $index => $collation) {
        $shopGoodID = intval(Arr::path($collation, 'shop_good_id', ''));
        if((($isNew === TRUE) && ($shopGoodID == 0))
            || (($isOld === TRUE) && ($shopGoodID > 0))
            || (($isNew !== TRUE) && ($isOld !== TRUE))){
            $count = $count + 1;
            ?>
            <tr>
                <td><?php echo $count; ?></td>
                <td colspan="<?php echo count($data->values['options']);?>">
                    <div class="row">
                        <?php if(keyExists('is_public', $options)){?>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="is_public">Опубликовать</label>
                                    <input name="data[<?php echo $index; ?>][is_public]" class="form-control" id="is_public" placeholder="Опубликовать" type="text" value="<?php echo htmlspecialchars(Arr::path($collation, 'collations', ''), ENT_QUOTES);?>">
                                </div>
                            </div>
                        <?php } ?>
                        <?php if(keyExists('collations', $options)){?>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="article">Сопоставление</label>
                                    <input name="data[<?php echo $index; ?>][collations]" class="form-control" id="article" placeholder="Сопоставление" type="text" value="<?php echo htmlspecialchars(Arr::path($collation, 'collations', ''), ENT_QUOTES);?>">
                                </div>
                            </div>
                        <?php } ?>
                        <?php if(keyExists('old_id', $options)){?>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="old_id">ID</label>
                                    <input name="data[<?php echo $index; ?>][old_id]" class="form-control" id="old_id" placeholder="ID" type="text" value="<?php echo htmlspecialchars(Arr::path($collation, 'old_id', ''), ENT_QUOTES);?>">
                                </div>
                            </div>
                        <?php } ?>
                        <?php if(keyExists('article', $options)){?>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="article">Артикул</label>
                                    <input name="data[<?php echo $index; ?>][article]" class="form-control" id="article" placeholder="Артикул" type="text" value="<?php echo htmlspecialchars(Arr::path($collation, 'article', ''), ENT_QUOTES);?>">
                                </div>
                            </div>
                        <?php } ?>
                        <?php if(keyExists('name', $options)){?>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="name">Название</label>
                                    <input name="data[<?php echo $index; ?>][name]" class="form-control" id="name" placeholder="Название" type="text" value="<?php echo htmlspecialchars(Arr::path($collation, 'name', ''), ENT_QUOTES);?>">
                                </div>
                            </div>
                        <?php } ?>
                        <?php if(keyExists('price', $options)){?>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="price">Цена</label>
                                    <input name="data[<?php echo $index; ?>][price]" class="form-control" id="price" placeholder="Цена" type="text" value="<?php echo round(str_replace(' ', '', intval(Arr::path($collation, 'price', ''))), 2);?>">
                                </div>
                            </div>
                        <?php } ?>
                        <?php if(keyExists('price_old', $options)){?>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="price_old">Старая цена</label>
                                    <input name="data[<?php echo $index; ?>][price_old]" class="form-control" id="price_old" placeholder="Старая цена" type="text" value="<?php echo round(str_replace(' ', '', intval(Arr::path($collation, 'price_old', ''))), 2);?>">
                                </div>
                            </div>
                        <?php } ?>
                        <?php if(keyExists('shop_good_unit_type_id', $options)){?>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="shop_good_unit_type_id">Единица измерения</label>
                                    <input name="data[<?php echo $index; ?>][shop_good_unit_type_id]" class="form-control" id="shop_good_unit_type_id" placeholder="Единица измерения" type="text" value="<?php echo intval(Arr::path($collation, 'shop_good_unit_type_id', ''));?>">
                                </div>
                            </div>
                        <?php } ?>

                        <?php
                        foreach($objOptions as $objOption) {
                            $field = 'options.'.$objOption['field'];
                            if(keyExists($field, $options)){
                                ?>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="<?php echo $field; ?>"><?php echo $objOption['title']; ?></label>
                                        <input name="data[<?php echo $index; ?>][<?php echo $field; ?>]" class="form-control" id="<?php echo $field; ?>" placeholder="<?php echo $objOption['title']; ?>" type="text" value="<?php echo htmlspecialchars(Arr::path($collation, $field, '', '::::'), ENT_QUOTES);?>">
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                        <?php if(keyExists('info', $options)){?>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="info">Описание</label>
                                    <textarea name="data[<?php echo $index; ?>][info]" placeholder="Описание..." rows="3" class="form-control"><?php echo $data->values['text'];?></textarea>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </td>
                <td>
                    <?php if($shopGoodID > 0){?>
                        <?php echo Arr::path($collation, 'shop_good_name', '');?>
                    <?php }else{?>
                        товар будет добавлен
                    <?php }?>
                    <input name="data[<?php echo $index; ?>][shop_good_id]" value="<?php echo $shopGoodID;?>" hidden>
                </td>
                <td>
                    <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
                        <li class="tr-remove"><a href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                        <li class="tr-un-remove"><a href="" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
                    </ul>
                </td>
            </tr>
        <?php } ?>
    <?php } ?>
</table>
<div class="col-md-12">
    <div aria-live="polite" role="status" class="dataTables_info">Найдено <?php echo Func::getCountElementStrRus($count, 'записей', 'запись', 'записи'); ?></div>
</div>