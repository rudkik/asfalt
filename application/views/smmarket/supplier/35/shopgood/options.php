<?php

$fields = Arr::path($data->values, '$elements$.shop_good_type.options', array());
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
    <div class="col-md-6">
        <div class="form-group">
            <label><?php echo $field['title']; ?></label>
            <input name="options[<?php echo $field['field']; ?>]" type="text" class="form-control" placeholder="<?php echo $field['title']; ?>" value="<?php echo $value; ?>">
        </div>
    </div>
<?php }?>

