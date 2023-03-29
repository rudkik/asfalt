<record>
    <?php
    include_once 'xml-function.php';

    foreach ($data->values as $key => $value) {
        if((! isIgnore($key)) && (! Func::emptyValue($value))) {
            if($key == 'image_path'){
                $value = Func::addSiteNameInFilePath($value, $siteData);
            }
            echo '<' . $key . '>' . writeValue($value) . '</' . $key . '>'."\r\n" . writeElementName($data, $key);
        }
    }
    ?>
</record>