<?php $isShow =  FALSE && $data->values['is_exit'] || Request_RequestParams::getParamBoolean('is_show'); ?>
<tr>
    <td rowspan="4">$index$</td>
    <td>
        <img data-action="show-big"
             data-src="<?php echo Func::getFullURL($siteData, '/shopboxcar/get_images'); ?>"
             data-id="<?php echo $data->id; ?>"
             data-type="<?php echo Model_Ab1_Shop_Boxcar::TABLE_ID; ?>"
             src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 68, 52); ?>">
    </td>
    <td>
        <input name="shop_boxcars[<?php echo $data->id; ?>][number]" type="text" class="form-control" placeholder="№ вагона" value="<?php echo htmlspecialchars($data->values['number'], ENT_QUOTES); ?>" <?php if($isShow){echo 'readonly';}?>>
    </td>
    <td>
        <input data-type="money" data-fractional-length="3" data-id="quantity" name="shop_boxcars[<?php echo $data->id; ?>][quantity]" type="text" class="form-control" placeholder="Тоннаж" value="<?php echo Func::getNumberStr($data->values['quantity'], FALSE, 3, false); ?>" <?php if($isShow){echo 'readonly';}?>>
    </td>
    <td>
        <input name="shop_boxcars[<?php echo $data->id; ?>][date_arrival]" type="datetime" date-type="datetime" class="form-control" placeholder="Дата подачи" value="<?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['date_arrival']); ?>" <?php if($isShow){echo 'readonly';}?>>
    </td>
    <td>
        <input name="shop_boxcars[<?php echo $data->id; ?>][date_drain_from]" type="datetime" date-type="datetime" class="form-control" placeholder="Начало разгрузки" value="<?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['date_drain_from']); ?>" <?php if($isShow){echo 'readonly';}?>>
    </td>
    <td>
        <input name="shop_boxcars[<?php echo $data->id; ?>][date_drain_to]" type="datetime" date-type="datetime" class="form-control" placeholder="Окончания слива" value="<?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['date_drain_to']); ?>" <?php if($isShow){echo 'readonly';}?>>
    </td>
    <td>
        <input name="shop_boxcars[<?php echo $data->id; ?>][stamp]" type="text" class="form-control" placeholder="№ пломбы" value="<?php echo htmlspecialchars($data->values['stamp'], ENT_QUOTES); ?>" <?php if($isShow){echo 'readonly';}?>>
    </td>
    <td>
        <input name="shop_boxcars[<?php echo $data->id; ?>][date_departure]" type="datetime" date-type="datetime" class="form-control" placeholder="Дата уборки" value="<?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['date_departure']); ?>" <?php if($isShow){echo 'readonly';}?>>
    </td>
    <td>
        <input name="shop_boxcars[<?php echo $data->id; ?>][sending]" type="text" class="form-control" placeholder="№ отправки" value="<?php echo htmlspecialchars($data->values['sending'], ENT_QUOTES); ?>" <?php if($isShow){echo 'readonly';}?>>
    </td>
    <td rowspan="4">
        <?php if(!$isShow){?>
            <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
                <li class="tr-remove"><a href="#" data-action="remove-tr" data-parent-count="4" data-row="3" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            </ul>
        <?php }?>
    </td>
</tr>
<tr data-index="_$index$">
    <td colspan="9">
        <div class="row pull-left" style="width: calc(100% - 83px)">
            <div class="col-md-12">
                <h3>Начало разгрузки</h3>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Диспетчер ЖДЦ и ДС</label>
                            <select data-id="drain_zhdc_from_shop_operation_id" name="shop_boxcars[<?php echo $data->id; ?>][drain_zhdc_from_shop_operation_id]" class="form-control select2" style="width: 100%">
                                <option data-id="0" value="0">Без значения</option>
                                <?php
                                $tmp = 'data-id="'.$data->values['drain_zhdc_from_shop_operation_id'].'"';
                                echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/operation/list/zhdc']));
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Товарный оператор 1</label>
                            <select data-id="drain_from_shop_operation_id_1" name="shop_boxcars[<?php echo $data->id; ?>][drain_from_shop_operation_id_1]" class="form-control select2" style="width: 100%">
                                <option data-id="0" value="0">Без значения</option>
                                <?php
                                $tmp = 'data-id="'.$data->values['drain_from_shop_operation_id_1'].'"';
                                echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/operation/list/list']));
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Товарный оператор 2</label>
                            <select data-id="drain_from_shop_operation_id_2" name="shop_boxcars[<?php echo $data->id; ?>][drain_from_shop_operation_id_2]" class="form-control select2" style="width: 100%">
                                <option data-id="0" value="0">Без значения</option>
                                <?php
                                $tmp = 'data-id="'.$data->values['drain_from_shop_operation_id_2'].'"';
                                echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/operation/list/list']));
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Оператор ТУ НБЦ (Бригадир)</label>
                            <select data-id="brigadier_drain_from_shop_operation_id" name="shop_boxcars[<?php echo $data->id; ?>][brigadier_drain_from_shop_operation_id]" class="form-control select2" style="width: 100%">
                                <option data-id="0" value="0">Без значения</option>
                                <?php
                                $tmp = 'data-id="'.$data->values['brigadier_drain_from_shop_operation_id'].'"';
                                echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/operation/list/list']));
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <h3>Окончание разгрузки</h3>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Остаток в цистерне</label>
                            <input data-id="residue" name="shop_boxcars[<?php echo $data->id; ?>][residue]" type="text" class="form-control" placeholder="Остаток в цистерне по замеру глубины Метроштоком №135 МШ 4.5 мм" value="<?php echo htmlspecialchars(Arr::path($data->values, 'residue', ''), ENT_QUOTES);?>" >
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Товарный оператор 1</label>
                            <select data-id="drain_to_shop_operation_id_1" name="shop_boxcars[<?php echo $data->id; ?>][drain_to_shop_operation_id_1]" class="form-control select2" style="width: 100%">
                                <option data-id="0" value="0">Без значения</option>
                                <?php
                                $tmp = 'data-id="'.$data->values['drain_to_shop_operation_id_1'].'"';
                                echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/operation/list/list']));
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Товарный оператор 2</label>
                            <select data-id="drain_to_shop_operation_id_2" name="shop_boxcars[<?php echo $data->id; ?>][drain_to_shop_operation_id_2]" class="form-control select2" style="width: 100%">
                                <option data-id="0" value="0">Без значения</option>
                                <?php
                                $tmp = 'data-id="'.$data->values['drain_to_shop_operation_id_2'].'"';
                                echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/operation/list/list']));
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Оператор ТУ НБЦ (Бригадир)</label>
                            <select data-id="brigadier_drain_to_shop_operation_id" name="shop_boxcars[<?php echo $data->id; ?>][brigadier_drain_to_shop_operation_id]" class="form-control select2" style="width: 100%">
                                <option data-id="0" value="0">Без значения</option>
                                <?php
                                $tmp = 'data-id="'.$data->values['brigadier_drain_to_shop_operation_id'].'"';
                                echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/operation/list/list']));
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Диспетчер ЖДЦ и ДС</label>
                            <select data-id="drain_zhdc_to_shop_operation_id" name="shop_boxcars[<?php echo $data->id; ?>][drain_zhdc_to_shop_operation_id]" class="form-control select2" style="width: 100%">
                                <option data-id="0" value="0">Без значения</option>
                                <?php
                                $tmp = 'data-id="'.$data->values['drain_zhdc_to_shop_operation_id'].'"';
                                echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/operation/list/zhdc']));
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Диспетчер по ж.д документом</label>
                            <select data-id="zhdc_shop_operation_id" name="shop_boxcars[<?php echo $data->id; ?>][zhdc_shop_operation_id]" class="form-control select2" style="width: 100%">
                                <option data-id="0" value="0">Без значения</option>
                                <?php
                                $tmp = 'data-id="'.$data->values['zhdc_shop_operation_id'].'"';
                                echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/operation/list/zhdc']));
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a href="#" data-action="copy-operation" class="btn btn-primary pull-right margin-b-5">Везде</a>
        <a href="#" data-action="copy-one-operation" class="btn bg-green pull-right margin-b-5">Копировать</a>
        <a href="#" data-action="paste-operation" class="btn bg-yellow pull-right margin-b-5">Вставить</a>
    </td>
</tr>
<tr>
    <td colspan="9">
        <div class="col-md-6">
        <textarea rows="5" name="shop_boxcars[<?php echo $data->id; ?>][text]" class="form-control" placeholder="Примечание" <?php if($isShow){echo 'readonly';}?>><?php echo htmlspecialchars($data->values['text'], ENT_QUOTES);?></textarea>
        </div>
        <div class="col-md-6">

            <label>
                Дополнительные файлы
            </label>
            <input name="shop_boxcars[<?php echo $data->id; ?>][options][files][]" value="" style="display: none">
            <table class="table table-hover table-db table-tr-line" >
                <tr>
                    <th>Файлы</th>
                    <?php if(!$isShow){ ?>
                        <th class="width-90"></th>
                    <?php } ?>
                </tr>
                <tbody id="files<?php echo $data->id; ?>">
                <?php
                $i = -1;
                foreach (Arr::path($data->values['options'], 'files', array()) as $file){
                    $i++;
                    if(empty($file)){
                        continue;
                    }
                    ?>
                    <tr>
                        <td>
                            <a target="_blank" href="<?php echo Arr::path($file, 'file', ''); ?>"><?php echo Arr::path($file, 'name', ''); ?></a>
                            <input name="shop_boxcars[<?php echo $data->id; ?>][options][files][<?php echo $i; ?>][file]" value="<?php echo Arr::path($file, 'file', ''); ?>" style="display: none">
                            <input name="shop_boxcars[<?php echo $data->id; ?>][options][files][<?php echo $i; ?>][name]" value="<?php echo Arr::path($file, 'name', ''); ?>" style="display: none">
                            <input name="shop_boxcars[<?php echo $data->id; ?>][options][files][<?php echo $i; ?>][size]" value="<?php echo Arr::path($file, 'size', ''); ?>" style="display: none">
                        </td>
                        <?php if(!$isShow){ ?>
                            <td>
                                <ul class="list-inline tr-button ">
                                    <li class="tr-remove"><a href="#" data-action="remove-tr" data-parent-count="4"  class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                                </ul>
                            </td>
                        <?php } ?>
                    </tr>
                <?php }?>
                </tbody>
            </table>
            <?php if(!$isShow){ ?>
                <div class="modal-footer text-center" style="padding: 5px 0px 0px;">
                    <button type="button" class="btn btn-danger" onclick="addElement('new-file<?php echo $data->id; ?>', 'files<?php echo $data->id; ?>', true);">Добавить файл</button>
                </div>
                <div id="new-file<?php echo $data->id; ?>" data-index="0">
                    <!--
                    <tr>
                        <td>
                            <div class="file-upload" data-text="Выберите файл" placeholder="Выберите файл">
                                <input type="file" name="shop_boxcars[<?php echo $data->id; ?>][options][files][_#index#]" >
                            </div>
                        </td>
                        <td>
                            <ul class="list-inline tr-button delete">
                                <li class="tr-remove"><a data-action="remove-tr" data-parent-count="4" href="#" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                            </ul>
                        </td>
                    </tr>
                    -->
                </div>
            <?php } ?>
        </div>
    </td>
</tr>
<tr>
    <td colspan="9">
        <?php
        $i = -1;
        foreach (Arr::path($data->values['options'], 'files', array()) as $file){
            $i++;
            if(empty($file)){
                continue;
            }
            ?>
            <a target="_blank" href="<?php echo Arr::path($file, 'file', ''); ?>" style="padding: 0px 15px 5px 0px;display: inline-block;"><?php echo Arr::path($file, 'name', ''); ?></a>
        <?php }?>
    </td>
</tr>
