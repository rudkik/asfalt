<?php
    include_once 'csv-function.php';

    foreach ($data->values as $key => $value) {
        if(! isIgnore($key)) {
            if($key == 'image_path'){
                $value = Func::addSiteNameInFilePath($value, $siteData);
            }
            if(!is_array($value)) {
                echo writeElementName($data, $key, $value);
            }
        }
    }
echo "\r\n";
?>