

<div class="form-group">
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        Название
    </label>
    <div class="col-md-4">
        <input name="name" type="text" class="form-control" placeholder="Название" value="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES); ?>" required>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        Логин
    </label>
    <div class="col-md-4">
        <input name="login" type="text" class="form-control" placeholder="Логин" value="<?php echo htmlspecialchars($data->values['login'], ENT_QUOTES); ?>" required>
    </div>
    <label class="col-md-2 control-label">
        Пароль
    </label>
    <div class="col-md-4">
        <input type="password" name="password" class="form-control login-input" id="" placeholder="Пароль" >
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Комментарий
    </label>
    <label class="col-md-10">
        <textarea name="text" rows="5" placeholder="Комментарий" class="form-control"><?php echo htmlspecialchars($data->values['text'], ENT_QUOTES); ?></textarea>
    </label>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Ссылка
    </label>
    <div class="col-md-10">
        <input name="link" type="text" class="form-control" placeholder="Ссылка" value="<?php echo htmlspecialchars($data->values['link'], ENT_QUOTES); ?>">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Файл
    </label>
    <div class="col-md-10">
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
    <div hidden>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php } ?>
        <input id="is_close" name="is_close" value="1" style="display: none">
    </div>
    <div class="modal-footer text-center">
        <button type="submit" class="btn bg-green" data-action="form-apply">Применить</button>
        <button type="submit" class="btn btn-primary" data-action="form-save">Сохранить</button>
    </div>
</div>
