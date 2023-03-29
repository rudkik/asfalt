<div id="modal-load-images" class="modal fade modal-image">
    <div class="modal-dialog" style="max-width: 600px">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть" style="margin: -40px -40px 0px 0px;"><span aria-hidden="true">×</span></button>
                <div class="modal-fields">
                    <div class="row">
                        <form enctype="multipart/form-data" action="" method="post">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Выберите список файлов:</label>
                                    <div id="file-load-images"  class="file-upload" data-text="Выберите файл" placeholder="Выберите файл">
                                        <input type="file" name="files[]" multiple>
                                    </div>
                                    <label id="error-load-images" class="text-red" style="display: none">Ошибка! Файлы не загружены.</label>
                                    <img id="loader-load-images" src="<?php echo $siteData->urlBasic; ?>/css/_component/loadimage_v2/loader.gif" class="img-responsive" style="margin: 0 auto; display: none">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div hidden>
                                    <input name="data_language_id" value="<?php echo $siteData->dataLanguageID; ?>">
                                    <?php if($siteData->branchID > 0){ ?>
                                        <input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
                                    <?php } ?>
                                    <?php if($siteData->superUserID > 0){ ?>
                                        <input name="shop_id" value="<?php echo $siteData->shopID; ?>">
                                    <?php } ?>
                                </div>
                                <a href="javascript:actionLoadImages('<?php echo $saveURL; ?>');" class="btn btn-primary pull-right">Загрузить</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function actionLoadImages(url) {
        $('#file-load-images').css('display', 'none');
        $('#loader-load-images').css('display', 'block');
        $('#error-load-images').css('display', 'none');

        formData = new FormData($('#modal-load-images form').get(0));

        jQuery.ajax({
            url: url,
            data: formData,
            type: "POST",
            contentType: false, // важно - убираем форматирование данных по умолчанию
            processData: false, // важно - убираем преобразование строк по умолчанию
            success: function (data) {
                $('#loader-load-images').css('display', 'none');
                $('#file-load-images').css('display', 'block');

                var obj = jQuery.parseJSON($.trim(data));
                if (!obj.error) {
                    s = '';
                    $.each(obj.data,function(id,value){
                        s = s + id + ' - ' + value + '<br>';
                    });

                    tmp = $('#error-load-images');
                    tmp.html(s);
                    tmp.css('display', 'block');
                    tmp.attr('class', 'text-blue');
                }
            },
            error: function (data) {
                $('#loader-load-images').css('display', 'none');
                $('#file-load-images').css('display', 'block');

                console.log(data.responseText);

                tmp = $('#error-load-images');
                tmp.text('Ошибка! Файлы не загружены.');
                tmp.css('display', 'block');
                tmp.attr('class', 'text-red');
            }
        });
        return;
    }
</script>