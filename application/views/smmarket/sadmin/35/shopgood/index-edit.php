<tr>
    <td><input name="shop_goods[<?php echo $data->id; ?>][is_public]" <?php if($data->values['is_public'] == 1){echo 'checked value="1" ';}else{echo 'value="0"';}?> data-id="1" type="checkbox" class="minimal"></td>
    <td><input name="shop_goods[<?php echo $data->id; ?>][good_select_type_id]" <?php if($data->values['good_select_type_id'] == 3723){echo 'checked value="3723"';}else{echo 'value="0"';}?> data-id="3723" type="checkbox" class="minimal"></td>
    <td><?php echo $data->values['id']; ?></td>
    <td>
        <textarea name="shop_goods[<?php echo $data->id; ?>][collations]" class="form-control" rows="4" placeholder="Сопоставление"><?php echo implode("\r\n", $data->values['collations']);?></textarea>
    </td>
    <td class="tr-header-photo">
        <img data-action="modal-image" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 90, 60); ?>" class="logo img-responsive" alt="">
    </td>
    <td>
        <input name="shop_goods[<?php echo $data->id; ?>][name]" type="text" class="form-control" placeholder="Название" value="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
    </td>
    <td>
        <div class="row price-block">
            <div class="col-md-6">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span>A</span>
                        </div>
                        <input name="shop_goods[<?php echo $data->id; ?>][options][price_a]" type="text" class="form-control" placeholder="Цена - А" value="<?php echo Func::getPrice($siteData->currency, Arr::path($data->values, 'options.price_a', ''));?>">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span>C</span>
                        </div>
                        <input name="shop_goods[<?php echo $data->id; ?>][options][price_c]" type="text" class="form-control" placeholder="Цена - C" value="<?php echo Func::getPrice($siteData->currency, Arr::path($data->values, 'options.price_c', ''));?>">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span>B</span>
                        </div>
                        <input name="shop_goods[<?php echo $data->id; ?>][options][price_b]" type="text" class="form-control" placeholder="Цена - B" value="<?php echo Func::getPrice($siteData->currency, Arr::path($data->values, 'options.price_b', ''));?>">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span>Р</span>
                        </div>
                        <input name="shop_goods[<?php echo $data->id; ?>][options][price_market]" type="text" class="form-control" placeholder="Цена - рынки и базары" value="<?php echo Func::getPrice($siteData->currency, Arr::path($data->values, 'options.price_market', ''));?>">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span>B+</span>
                        </div>
                        <input name="shop_goods[<?php echo $data->id; ?>][options][price_b_plus]" type="text" class="form-control" placeholder="Цена - B+" value="<?php echo Func::getPrice($siteData->currency, Arr::path($data->values, 'options.price_b_plus', ''));?>">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span>H</span>
                        </div>
                        <input name="shop_goods[<?php echo $data->id; ?>][options][price_horeca]" type="text" class="form-control" placeholder="Цена - Horeca" value="<?php echo Func::getPrice($siteData->currency, Arr::path($data->values, 'options.price_horeca', ''));?>">
                    </div>
                </div>
            </div>
        </div>
    </td>
    <?php if($siteData->branchID == 0){ ?>
    <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_id.name', ''); ?></td>
    <?php } ?>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="/sadmin/shopgood/edit?id=<?php echo $data->id; ?>&shop_branch_id=<?php echo $data->values['shop_id']; ?>" class="link-blue text-sm"><i class="fa fa-edit"></i>изменить</a></li>
            <li><a href="/sadmin/shopgood/clone?id=<?php echo $data->id; ?>&shop_branch_id=<?php echo $data->values['shop_id']; ?>" class="link-black text-sm"><i class="fa fa-clone"></i>дублировать</a></li>
            <li class="tr-remove"><a href="/sadmin/shopgood/del?id=<?php echo $data->id; ?>&shop_branch_id=<?php echo $data->values['shop_id']; ?>" class="link-red text-sm"><i class="fa fa-remove"></i>удалить</a></li>
            <li class="tr-un-remove"><a href="/sadmin/shopgood/del?id=<?php echo $data->id; ?>&is_undel=1&shop_branch_id=<?php echo $data->values['shop_id']; ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i>восстановить</a></li>
        </ul>
    </td>
</tr>