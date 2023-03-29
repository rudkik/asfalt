<h2><?php echo $data->values['name']; ?></h2>
<div class="text"><?php echo Arr::path($data->values['options'], 'info', ''); ?></div>