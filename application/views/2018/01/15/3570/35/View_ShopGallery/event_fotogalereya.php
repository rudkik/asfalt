<?php
if(is_array($data->values['files'])) {
    foreach ($data->values['files'] as $file) {
        if (($file['type'] == Model_ImageType::IMAGE_TYPE_IMAGE) || (floatval($file['type']) == 0)) {
            ?>
            <li>
                <a href="<?php echo $file['file']; ?>">
                    <img src="<?php echo Func::getPhotoPath($file['file'], 870, 328); ?>" alt="<?php echo htmlspecialchars($file['title'], ENT_QUOTES);?>">
                </a>
            </li>
            <?php
        }
    }
}
?>


