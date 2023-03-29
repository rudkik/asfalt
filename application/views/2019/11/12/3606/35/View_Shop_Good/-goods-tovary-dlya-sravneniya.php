<?php
$options = array();
$optionKeys = array();
foreach ($data->values['options'] as $child){
    if(!Arr::path($child, 'is_public', FALSE)){
        continue;
    }
    $name = Arr::path($child, 'name', '');

    $options[$name] = Arr::path($child, 'title', '');
    $optionKeys[$name] = $name;
}

echo json_encode(
    array(
        'name_url' => $data->values['name_url'],
        'name' => $data->values['name'],
        'image_path' => $data->values['image_path'],
        'options' => $options,
        'option_keys' => $optionKeys,
    )
);
?>