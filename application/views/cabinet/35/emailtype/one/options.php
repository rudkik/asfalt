<div id="panel-fields-<?php echo $data->id; ?>" data-id="fields" hidden>
    <div class="col-md-4">
        <select class="form-control select2" style="width: 100%;" id="fields-<?php echo $data->id; ?>">
            <option data-id="0" value=""></option>
            <?php
            $fields = $data->values['fields_options'];
            foreach ($fields as $field){
                ?>
                <option value="<?php echo htmlspecialchars($field['field']); ?>"><?php echo $field['title']; ?></option>
            <?php }?>
        </select>
    </div>
    <div class="col-md-4" style="min-width: 109px;">
        <a onclick="javascript:addEMailField('fields-<?php echo $data->id; ?>')" textarea="html" class="btn btn-primary btn-insert">Вставить</a>
    </div>
</div>
