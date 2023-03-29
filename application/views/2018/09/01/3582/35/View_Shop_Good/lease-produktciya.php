<?php
$default_active = '';
if (array_key_exists ('id', $_GET)) {
  if ($_GET['id'] == $data->values['id']) {
    $default_active = ' data-def="true"';
  }
}
?>
<li data-id="<?php echo $data->values['id']; ?>" data-value="<?php echo $data->values['price']; ?>"<?php echo $default_active; ?>><?php echo $data->values['name'].' '.Arr::path($data->values['options'], 'model', ''); ?></li>