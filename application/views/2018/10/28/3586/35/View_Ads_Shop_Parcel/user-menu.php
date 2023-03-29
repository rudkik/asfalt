<?php
echo json_encode(
    array(
        'parcel_status_id' => $data->values['parcel_status_id'],
        'count' => $data->values['count'],
    )
);
?>