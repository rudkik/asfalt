<?php

if(! is_array($fields)){
    $fields = array();
}

$values = Arr::path($data->values, 'options', array());
if(! is_array($values)){
    $values = array();
}

foreach ($fields as $field){
    $value = Arr::path($values, $field['field'], '');
?>
    <div class="row record-input <?php echo $className; ?>">
        <div class="col-md-3 record-title">
            <label>
                <?php echo $field['title']; ?>
                <?php if(!Func::_empty(Arr::path($field, 'hint', ''))){ ?>
                    <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                <?php } ?>
            </label>
        </div>
        <div class="col-md-9">
            <input name="options[<?php echo $field['field']; ?>]" type="text" class="form-control" placeholder="<?php echo $field['title']; ?>" value="<?php echo $value; ?>">
        </div>
    </div>
<?php }?>

