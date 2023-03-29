<?php
if(!isset($postfix)){
    $postfix = '';
}
if(!isset($prefix)){
    $prefix = '';
}
?>

<div class="box-header with-border" style="padding-top: 6px;margin-bottom: 10px;">
    <i class="fa fa-image"></i>
    <h3 class="box-title"><a href="" data-toggle="modal" data-target="#modal-image">Изображения списком</a></h3>
    <input name="<?php if(empty($prefix)){echo 'files'; }else{ echo $prefix.'[files]';} ?>[-1][file_name]" value="" hidden>
</div>
<div class="row">
    <div class="col-md-12 text-center" name="add-images" data-postfix="<?php echo $postfix; ?>">
        <label>
            <span class="btn btn-sm btn-info btn-flat pull-left">Загрузить изображения</span>
            <input class="input-files" name="file" type="file" multiple>
        </label>
    </div>
</div>
<div class="row box-images" id="sort-images<?php echo $postfix; ?>" data-id="<?php echo count(Arr::path($data->values, 'files', array())) + 1; ?>" column="<?php echo $columnSize; ?>">

    <?php if(count(Arr::path($data->values, 'files', array())) > 0){ ?>

        <?php
        foreach(Arr::path($data->values, 'files', array()) as $index => $file) {
            if((! is_array($file)) || (!key_exists('type', $file))){
               continue;
            }
            $tуpe = intval(Arr::path($file, 'type', 0));
            if(($tуpe == Model_ImageType::IMAGE_TYPE_IMAGE) || (($tуpe == 0))){
            ?>

        <div class="col-md-<?php echo $columnSize; ?>">
            <div class="box box-image box-danger">
                <div class="box-header with-border">
                    <input name="<?php echo $prefix; ?>files[<?php echo $index; ?>][title]"  class="form-control" placeholder="Подсказка (TITLE)" value="<?php echo Arr::path($file, 'title', '');?>">
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool text-red" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-load">
                    <label>
                        <span class="btn btn-sm btn-info btn-flat pull-left">Загрузить</span>
                        <input name="file" type="file">
                    </label>
                </div>
                <div class="box-body no-padding">
                    <ul class="users-list clearfix">
                        <li name="image-file">
                            <?php if((intval(Arr::path($file, 'w', '0'))> 0) && (intval(Arr::path($file, 'h', '0')) > 0)){ ?>
                            <div class="img-size">
                                <a href="<?php echo $file['file']; ?>" target="_blank" class="text-yellow"><?php echo Arr::path($file, 'w', '');?>x<?php echo Arr::path($file, 'h', '');?></a>
                            </div>
                            <?php }?>
                            <img src="<?php echo Helpers_Image::getPhotoPath($file['file'], 288, 175);?>" alt="<?php echo Arr::path($file, 'title', '');?>">
                        </li>
                    </ul>
                </div>
                <div name="index" data-id="<?php echo $index; ?>" hidden>
                    <input data-id="file-name" name="<?php if(empty($prefix)){echo 'files'; }else{ echo $prefix.'[files]';} ?>[<?php echo $index; ?>][file_name]" value="<?php echo Arr::path($file, 'file_name', '');?>"/>
                    <input data-id="file-url" name="<?php if(empty($prefix)){echo 'files'; }else{ echo $prefix.'[files]';} ?>[<?php echo $index; ?>][url]" value="<?php echo $file['file'];?>"/>
                    <input data-id="file-id" name="<?php if(empty($prefix)){echo 'files'; }else{ echo $prefix.'[files]';} ?>[<?php echo $index; ?>][id]" value="<?php echo intval(Arr::path($file, 'id', '0'));?>"/>
                    <input data-id="file-index" name="<?php if(empty($prefix)){echo 'files'; }else{ echo $prefix.'[files]';} ?>[<?php echo $index; ?>][index]" value="<?php echo $index; ?>"/>
                    <input data-id="file-type" name="<?php if(empty($prefix)){echo 'files'; }else{ echo $prefix.'[files]';} ?>[<?php echo $index; ?>][type]" value="<?php echo Model_ImageType::IMAGE_TYPE_IMAGE; ?>"/>
                </div>
            </div>
        </div>

        <?php
            }
        }
        ?>

    <?php } ?>
</div>

<?php if(count(Arr::path($data->values, 'files', array())) > 0){ ?>
    <div class="row">
        <div class="col-md-12 text-center" name="add-images" data-postfix="<?php echo $postfix; ?>">
            <label>
                <span class="btn btn-sm btn-info btn-flat pull-left">Загрузить изображения</span>
                <input class="input-files" name="file" type="file" multiple>
            </label>
        </div>
    </div>
<?php } ?>

<div id="add-image-panel<?php echo $postfix; ?>" hidden>
    <!--
    <div class="col-md-#column#" name="#name#">
        <div class="box box-image box-danger">
            <div class="box-header with-border">
                <input name="<?php if(empty($prefix)){echo 'files'; }else{ echo $prefix.'[files]';} ?>[#index#][title]" class="form-control" placeholder="Подсказка (TITLE)">
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool text-red" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-load">
                <label>
                    <span class="btn btn-sm btn-info btn-flat pull-left">Загрузить</span>
                    <input name="file" type="file">
                </label>
            </div>
            <div class="box-body no-padding">
                <ul class="users-list clearfix">
                    <li name="image-file"></li>
                </ul>
            </div>
            <div name="index" data-id="#index#" hidden>
                <input data-id="file-name" name="<?php if(empty($prefix)){echo 'files'; }else{ echo $prefix.'[files]';} ?>[#index#][file_name]" value=""/>
                <input data-id="file-url" name="<?php if(empty($prefix)){echo 'files'; }else{ echo $prefix.'[files]';} ?>[#index#][url]" value=""/>
                <input data-id="file-id" name="<?php if(empty($prefix)){echo 'files'; }else{ echo $prefix.'[files]';} ?>[#index#][id]" value="0"/>
                <input data-id="file-index" name="<?php if(empty($prefix)){echo 'files'; }else{ echo $prefix.'[files]';} ?>[#index#][index]" value="0"/>
                <input data-id="file-type" name="<?php if(empty($prefix)){echo 'files'; }else{ echo $prefix.'[files]';} ?>[#index#][type]" value="<?php echo Model_ImageType::IMAGE_TYPE_IMAGE; ?>"/>
            </div>
        </div>
    </div>
    -->
</div>

<script>
    $("#sort-images<?php echo $postfix; ?>").sortable({
        zIndex: 999999,
        update: function() {
            $('#sort-images<?php echo $postfix; ?> > div').each(function(index) {
                indexDiv = $(this).find('div[name="index"]').attr('data-id');
                $(this).find('input').each(function( index2 ) {
                    $(this).attr('name', $(this).attr('name').replace('files[' + indexDiv + ']', 'files[' + index + ']'));
                });

                $(this).find('div[name="index"]').attr('data-id', index);
            });
        }
    });

    $('#sort-images<?php echo $postfix; ?> button[data-widget="remove"]').click(function () {
        $(this).parent().parent().parent().parent().remove();
    });
</script>

<?php
$files = Arr::path($data->values, 'files', array());
if(count($files) > 0){ ?>
    <div id="modal-image" class="modal fade modal-image">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть" style="margin: -40px -40px 0px 0px;"><span aria-hidden="true">×</span></button>
                    <div class="modal-fields">
                        <div class="row">
                            <div class="ones">
                                <div id="carousel" class="carousel slide" data-interval="300000" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        <?php
                                        $i = -1;
                                        foreach($files as $index => $file) {
                                            if((! is_array($file)) || (!key_exists('type', $file))){
                                                continue;
                                            }
                                            $tуpe = intval(Arr::path($file, 'type', 0));
                                            if(($tуpe == Model_ImageType::IMAGE_TYPE_IMAGE) || (($tуpe == 0))){
                                                $i++;?>
                                                <li <?php if ($i == 0){echo 'class="active"';} ?> data-target="#carousel" data-slide-to="<?php echo $i; ?>"></li>
                                            <?php } } ?>
                                    </ol>
                                    <div class="carousel-inner">
                                        <?php
                                        $i = 0;
                                        foreach($files as $index => $file) {
                                            if((! is_array($file)) || (!key_exists('type', $file))){
                                                continue;
                                            }
                                            $tуpe = intval(Arr::path($file, 'type', 0));
                                            if(($tуpe == Model_ImageType::IMAGE_TYPE_IMAGE) || (($tуpe == 0))){
                                                $i++;?>
                                                <div class="item <?php if ($i == 1){echo 'active';} ?>">
                                                    <img src="<?php echo Helpers_Image::getPhotoPath($file['file'], 950, 700);?>" alt="">
                                                </div>
                                            <?php } } ?>
                                    </div>
                                    <a href="#carousel" class="left carousel-control" data-slide="prev">
                                        <span class="glyphicon glyphicon-chevron-left"></span>
                                    </a>
                                    <a href="#carousel" class="right carousel-control" data-slide="next">
                                        <span class="glyphicon glyphicon-chevron-right"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
