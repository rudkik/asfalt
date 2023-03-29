<?php
$listOption = Arr::path($data->values['fields_options'], $data->additionDatas['options_name'], array());
?>

<?php
foreach ($listOption as $index => $value):
    ?>
    <th><?php echo $value['title'];?></th>
<?php endforeach;?>