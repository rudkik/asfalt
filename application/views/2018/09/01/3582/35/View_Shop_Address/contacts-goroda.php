<?php
if((!key_exists('city_id', $_GET)) && ($data->values['is_main_shop'] == 1)) {
    $_GET['city_id'] = $data->values['city_id'];
}

echo json_encode(
    array(
        'id' => $data->values['city_id'],
        'name' => Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.city_id.name', ''),
    )
);
?>