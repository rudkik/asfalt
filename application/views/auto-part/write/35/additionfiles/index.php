<div class="row" id="insert_image_panel">
    <?php
    foreach(Arr::path($data->values, 'files', array()) as $index => $file) {
        if($file['type'] == Model_ImageType::IMAGE_TYPE_IMAGE){
     ?>
        <div class="col-md-4"">
            <a class="dropzone-a" href="<?php echo $file['file'];?>" target="_blank">Посмотреть оригинал</a>
            <a class="dropzone-del" href="">x</a>
            <div class="dropzone">
                <div class="browser">
                    <label style="margin-bottom: 0px;">
                        <span>Загрузить</span>
                        <input type="file" name="file"/>
                    </label>
                </div>
                <div data-id="output" style="display: block;">
                    <img style="max-height: 170px; max-width: 100%;" src="<?php echo Helpers_Image::getPhotoPath($file['file'], 345, 170);?>">
                </div>

                <input data-id="file-index" hidden="hidden" name="addition_image_indexes[]" value="<?php echo $index; ?>"/>
                <input data-id="file-isdel" hidden="hidden" name="addition_image_isdels[]"/>
                <input data-id="file-name" hidden="hidden" name="addition_image_names[]" value="<?php echo $file['file']; ?>"/>
            </div>
        </div>
    <?php } }?>
    <?php
    $tmp = Arr::path($data->values, 'files', array());
    if(is_array($tmp) && (($tmp) == 0)){
        for($i = 0; $i < 3; $i++){
    ?>
    <div class="col-md-4">
        <a class="dropzone-del" href="">x</a>
        <div class="dropzone">
            <div class="browser">
                <label style="margin-bottom: 0px;">
                    <span>Загрузить</span>
                    <input type="file" name="file"/>
                </label>
            </div>
            <div data-id="output"></div>
            <input data-id="file-index" hidden="hidden" name="addition_image_indexes[]"/>
            <input data-id="file-isdel" hidden="hidden" name="addition_image_isdels[]"/>
            <input data-id="file-name" hidden="hidden" name="addition_image_names[]"/>
        </div>
    </div>
    <?php }}?>
</div>

<div class="row" style="margin-top: 10px;">
    <div class="col-md-9"></div>
    <div class="col-md-3">
        <input type="submit" class="btn btn-success btn-block" value="Добавить фото" onclick="actionAddTR('insert_image_panel', 'image_panel')">
    </div>
</div>

<div hidden="hidden" id="image_panel">
    <!--
    <div class="col-md-4">
        <a class="dropzone-del" href="">x</a>
        <div class="dropzone">
            <div class="browser">
                <label style="margin-bottom: 0px;">
                    <span>Загрузить</span>
                    <input type="file" name="file"/>
                </label>
            </div>
            <div data-id="output"></div>
            <input data-id="file-index" hidden="hidden" name="addition_image_indexes[]"/>
            <input data-id="file-isdel" hidden="hidden" name="addition_image_isdels[]"/>
            <input data-id="file-name" hidden="hidden" name="addition_image_names[]"/>
        </div>
    </div>
    <div class="col-md-4">
        <a class="dropzone-del" href="">x</a>
        <div class="dropzone">
            <div class="browser">
                <label style="margin-bottom: 0px;">
                    <span>Загрузить</span>
                    <input type="file" name="file"/>
                </label>
            </div>
            <div data-id="output"></div>
            <input data-id="file-index" hidden="hidden" name="addition_image_indexes[]"/>
            <input data-id="file-isdel" hidden="hidden" name="addition_image_isdels[]"/>
            <input data-id="file-name" hidden="hidden" name="addition_image_names[]"/>
        </div>
    </div>
    <div class="col-md-4">
        <a class="dropzone-del" href="">x</a>
        <div class="dropzone">
            <div class="browser">
                <label style="margin-bottom: 0px;">
                    <span>Загрузить</span>
                    <input type="file" name="file"/>
                </label>
            </div>
            <div data-id="output"></div>
            <input data-id="file-index" hidden="hidden" name="addition_image_indexes[]"/>
            <input data-id="file-isdel" hidden="hidden" name="addition_image_isdels[]"/>
            <input data-id="file-name" hidden="hidden" name="addition_image_names[]"/>
        </div>
    </div>
 -->
</div>
