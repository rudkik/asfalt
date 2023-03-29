<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-9">
        <label class="span-checkbox">
            <input name="is_public" value="0" style="display: none;">
            <input name="is_public" <?php if (Arr::path($data->values, 'is_public', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
            Показать
        </label>
    </div>
</div>

<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Название
        </label>
    </div>
    <div class="col-md-9">
        <input name="name" type="text" class="form-control" placeholder="Название" required value="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Поля испытания
        </label>
    </div>
    <div class="col-md-9">
        <table class="table table-hover table-db table-tr-line" >
            <tr>
                <th>Название поля</th>
                <th class="tr-header-amount">Тип поля</th>
                <th class="tr-header-amount">Поле по формуле</th>
                <th class="tr-header-buttom"></th>
            </tr>
            <tbody id="options">
            <?php
            $i = 0;
            foreach (Arr::path($data->values['options'], 'fields', array()) as $key => $value){?>
                <tr>
                    <td>
                        <input name="options[fields][<?php echo $i; ?>][name]" type="text" class="form-control" required value="<?php {echo $value['name'];} ?>">
                    </td>
                    <td>
                        <select name="options[fields][<?php echo $i; ?>][type]" class="form-control select2" required style="width: 100%;">
                            <option value="0" data-id="0">Без значения</option>
                            <option value="1" data-id="1" <?php if(key_exists('type', $value)) {if($value['type'] == 1){echo 'selected';} }?>>Целое число</option>
                            <option value="2" data-id="2" <?php if(key_exists('type', $value)) {if($value['type'] == 2){echo 'selected';} }?>>Нецелое число</option>
                            <option value="3" data-id="3" <?php if(key_exists('type', $value)) {if($value['type'] == 3){echo 'selected';} }?>>Комплексное число</option>
                            <option value="4" data-id="4" <?php if(key_exists('type', $value)) {if($value['type'] == 4){echo 'selected';} }?>>Многострочное поле</option>
                            <option value="5" data-id="5" <?php if(key_exists('type', $value)) {if($value['type'] == 5){echo 'selected';} }?>>Текстовое поле</option>
                        </select>
                    </td>
                    <td>
                        <label class="span-checkbox">
                            <input name="options[fields][<?php echo $i++; ?>][is_formula]" <?php if(key_exists('is_formula', $value)) {
                                if ($value['is_formula'] == 1) { echo 'value="1" checked'; }else{echo 'value="0"';}
                            } ?> type="checkbox" class="minimal">
                        </label>
                    </td>
                    <td>
                        <ul class="list-inline tr-button delete">
                            <li class="tr-remove"><a data-action="remove-tr" data-parent-count="4" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                        </ul>
                    </td>
                </tr>
            <?php }?>
            </tbody>
        </table>
        <div id="new-option" data-index="<?php echo count(Arr::path($data->values['options'], 'fields', array())); ?>">
            <!--
            <tr>
                <td>
                    <input name="options[fields][_#index#][name]" type="text" class="form-control" placeholder="Название" required value="">
                </td>
                <td>
                    <select name="options[fields][_#index#][type]" class="form-control select2" required style="width: 100%;">
                        <option value="0" data-id="0">Без значения</option>
                        <option value="1" data-id="1">Целое число</option>
                        <option value="2" data-id="2">Нецелое число</option>
                        <option value="3" data-id="3">Комплексное число</option>
                        <option value="4" data-id="4">Многострочное поле</option>
                        <option value="5" data-id="5">Текстовое поле</option>
                    </select>
                </td>
                    <td>
                        <label class="span-checkbox">
                            <input name="options[fields][_#index#][is_formula]"  type="checkbox" class="minimal">
                        </label>
                    </td>
                <td>
                    <ul class="list-inline tr-button delete">
                        <li class="tr-remove"><a data-action="remove-tr" data-parent-count="4" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                    </ul>
                </td>
            </tr>
            -->
        </div>
        <div class="modal-footer text-center">
            <button type="button" class="btn btn-danger" onclick="addElement('new-option', 'options', true);">Добавить поле</button>
        </div>
    </div>
</div>
<div class="row">
    <div hidden>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php } ?>
    </div>
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>