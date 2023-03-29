<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Клиент
        </label>
    </div>
    <div class="col-md-9">
        <input type="text" class="form-control" value="<?php echo $data->getElementValue('shop_client_id'); ?>" readonly>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            № автомобиля
        </label>
    </div>
    <div class="col-md-3">
        <input type="text" class="form-control" value="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES); ?>" readonly>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Кол-во
        </label>
    </div>
    <div class="col-md-3">
        <input type="text" class="form-control" value="<?php echo Func::getNumberStr($data->values['quantity'], true, 3); ?>" readonly>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Продукт
        </label>
    </div>
    <div class="col-md-9">
        <input type="text" class="form-control" value="<?php echo $data->getElementValue('shop_product_id'); ?>" readonly>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Примечание
        </label>
    </div>
    <div class="col-md-9">
        <textarea name="text" class="form-control" placeholder="Примечание"><?php echo htmlspecialchars(Arr::path($data->values, 'text', ''), ENT_QUOTES);?></textarea>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Подтверждающие файлы
        </label>
    </div>
    <div class="col-md-9">
        <input name="options[files][]" value="" style="display: none">
        <table class="table table-hover table-db table-tr-line" >
            <tr>
                <th>Файлы</th>
                <th class="width-90"></th>
            </tr>
            <tbody id="files">
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
                        <input name="options[files][<?php echo $i; ?>][file]" value="<?php echo Arr::path($file, 'file', ''); ?>" style="display: none">
                        <input name="options[files][<?php echo $i; ?>][name]" value="<?php echo Arr::path($file, 'name', ''); ?>" style="display: none">
                        <input name="options[files][<?php echo $i; ?>][size]" value="<?php echo Arr::path($file, 'size', ''); ?>" style="display: none">
                    </td>
                    <td>
                        <ul class="list-inline tr-button ">
                            <li class="tr-remove"><a href="#" data-action="remove-tr" data-parent-count="4"  class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                        </ul>
                    </td>
                </tr>
            <?php }?>
            </tbody>
        </table>
        <div class="modal-footer text-center">
            <button type="button" class="btn btn-danger" onclick="addElement('new-file', 'files', true);">Добавить файл</button>
        </div>
        <div id="new-file" data-index="0">
            <!--
            <tr>
                <td>
                    <div class="file-upload" data-text="Выберите файл" placeholder="Выберите файл">
                        <input type="file" name="options[files][_#index#]" >
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
    </div>
</div>
<div class="row">
    <div class="col-md-12 text-center">
        <div hidden>
            <input id="id" name="id" value="<?php echo $data->values['id'];?>">
            <input id="is_public" name="is_public" value="0">
        </div>
        <button type="submit" class="btn btn-primary">Отказ</button>
    </div>
</div>