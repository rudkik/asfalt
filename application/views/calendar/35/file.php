<div id="fileupload" method="POST" enctype="multipart/form-data">
    <div class="row fileupload-buttonbar">
        <div class="col-lg-12">
            <span class="btn btn-success fileinput-button">
                <i class="glyphicon glyphicon-plus"></i>
                <span>Загрузить</span>
                <input type="file" name="files[]" multiple />
            </span>
            <button type="reset" class="btn btn-warning cancel">
                <i class="glyphicon glyphicon-ban-circle"></i>
                <span>Отменить загрузку</span>
            </button>
            <span class="fileupload-process"></span>
        </div>
        <div class="col-lg-12 fileupload-progress fade">
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar progress-bar-success" style="width:0%;"></div>
            </div>
        </div>
    </div>
    <div class="box-body no-padding">
        <ul class="file-list clearfix files">
            <?php foreach ($files as $file){ ?>
                <li>
                    <div class="box-img">
                        <?php
                        $tуpe = intval(Arr::path($file, 'type', 0));
                        if($tуpe == Model_ImageType::IMAGE_TYPE_IMAGE){ ?>
                            <a href="<?php echo $file['file'];?>" title="<?php echo Arr::path($file, 'file_name', '');?>" download="<?php echo Arr::path($file, 'file', '');?>" data-gallery><img src="<?php echo Helpers_Image::getPhotoPath($file['file'], 90, 90);?>"></a>
                        <?php }else{ ?>
                        <a data-gallery><img src="/img/system/file-add.png"></a>
                        <?php } ?>
                        <input name="file_list[][id]" value="<?php echo $file['id'];?>" style="display:none">
                    </div>
                    <a class="file-list-name" href="<?php echo $file['file'];?>" title="<?php echo Arr::path($file, 'file_name', '');?>" download="<?php echo Arr::path($file, 'file_name', '');?>"><?php echo Arr::path($file, 'file_name', '');?></a>
                    <span class="file-list-date"><?php echo Helpers_Image::getFileSizeStrRus(Arr::path($file, 'file_size', ''));?></span>
                    <button class="btn btn-danger delete" data-type="CANCEL">
                        <i class="glyphicon glyphicon-trash"></i>
                        <span>Удалить</span>
                    </button>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>

<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div>

<script id="template-upload" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
        <li>
            <span class="preview"></span>
            {% if (window.innerWidth > 480 || !o.options.loadImageFileTypes.test(file.type)) { %}
            <p class="file-list-name">{%=file.name%}</p>
            {% } %}
            <strong class="file-list-name error text-danger"></strong>
            <div class="file-list-date">
                <p class="size">Processing...</p>
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
            </div>
            {% if (!i) { %}
            <button class="btn btn-warning cancel" data-type="CANCEL">
                <i class="glyphicon glyphicon-ban-circle"></i>
                <span>Отменить</span>
            </button>
            {% } %}
        </li>
    {% } %}
</script>
<script id="template-download" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
        <li>
            <div class="box-img">
                {% if (file.thumbnailUrl) { %}
                <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                {% } else { %}
                <a data-gallery><img src="/img/system/file-add.png"></a>
                {% } %}
                {% if (file.id) { %}
                <input name="file_list[][id]" value="{%=file.id%}" style="display:none">
                {% } else { %}
                <input name="file_list[][name]" value="{%=file.name%}" style="display:none">
                {% } %}
            </div>
            {% if (window.innerWidth > 480 || !file.thumbnailUrl) { %}
            {% if (file.url) { %}
            <a class="file-list-name" href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
            {% } else { %}
            <span class="file-list-name">{%=file.name%}</span>
            {% } %}
            {% } %}
            <span class="file-list-date">{%=o.formatFileSize(file.size)%}</span>
            {% if (file.error) { %}
            <div><span class="label label-danger">Ошибка</span> {%=file.error%}</div>
            {% } %}
            {% if (file.deleteUrl) { %}
            <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                <i class="glyphicon glyphicon-trash"></i>
                <span>Удалить</span>
            </button>
            {% } else { %}
            <button class="btn btn-warning cancel" data-type="CANCEL" >
                <i class="glyphicon glyphicon-ban-circle"></i>
                <span>Отменить</span>
            </button>
            {% } %}
        </li>
    {% } %}
</script>