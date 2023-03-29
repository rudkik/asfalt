<?php
$lastImage = '';
$files = Arr::path($data->values, 'files', array());
$i = 0;
foreach($files as $index => $file) {
    if((! is_array($file)) || (!key_exists('type', $file))){
        continue;
    }
    $tуpe = intval(Arr::path($file, 'type', 0));
    if(($tуpe == Model_ImageType::IMAGE_TYPE_IMAGE) || (($tуpe == 0))){
        $i++;
        if($i > 1) {
            $lastImage = $file['file'];
            break;
        }
    }
}

echo json_encode(
    array(
        'id' => $data->id,
        'producer' => $data->values['name'],
        'model' => Arr::path($data->values['options'], 'model', ''),
        'description' => Arr::path($data->values['options'], 'type', ''),
        'lease' => Arr::path($data->values['options'], 'is_lease', ''),
        'bigImageSrc' => Helpers_Image::getPhotoPath($data->values['image_path'], 531, 0),
        'smallImageSrc' => Helpers_Image::getPhotoPath($lastImage, 338, 0),
        'link' => $siteData->urlBasic.'/catalog'.$data->values['name_url'],
        'link_lease' => $siteData->urlBasic.'/lease?id='.$data->values['id'],
        'characteristic' =>  'Производительность '.Arr::path($data->values['options'], 'performance', '')
            .'.<br> Двигатель '.Arr::path($data->values['options'], 'motor', '')
            .'.<br> Номинальная мощность - '.Arr::path($data->values['options'], 'rating', '').'.',
    )
);
?>