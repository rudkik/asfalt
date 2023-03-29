<?php
Helpers_SEO::setSEOHeader(Model_Shop_New::TABLE_NAME, $data, $siteData);
$siteData->siteImage = $data->values['image_path'];
?>
<header class="header-bread-crumbs">
    <div class="container">
        <h2><?php echo $data->values['name']; ?></h2>
        <div class="box-bread-crumbs">
            <a href="<?php echo $siteData->urlBasicLanguage; ?>">Main</a> |
            <a href="<?php echo $siteData->urlBasicLanguage; ?>/about-us">O nas</a> |
            <a href="<?php echo $siteData->urlBasicLanguage; ?>/about-us/job-positions">Kariera</a> |
            <span><?php echo $data->values['name']; ?></span>
        </div>
    </div>
</header>
<header class="header-article">
    <div class="container">
        <h1 itemprop="name"><?php echo $data->values['name']; ?></h1>
        <div class="line-red"></div>
        <div class="row">
            <div class="col-md-9">
                <div class="box_text margin-b-40">
                    <div class="box_text">
                        <h4>Подчинение: <?php echo Arr::path($data->values['options'], 'land', ''); ?></h4>
                        <div class="objectText">
                            <p><?php echo Arr::path($data->values['options'], 'position', ''); ?></p>
                            <h4><span data-mce-mark="1">Требования:</span></h4>
                            <?php echo Arr::path($data->values['options'], 'demand', ''); ?>
                            <h4>Описание позиции:</h4>
                            <?php echo Arr::path($data->values['options'], 'info', ''); ?>
                            <h4>Условия:</h4>
                            <?php echo Arr::path($data->values['options'], 'conditions', ''); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div id="respond">
                    <form id="form-send" class="ajax_form" method="post" action="/command/message_add" enctype="multipart/form-data">
                        <?php
                        $view = View::factory('2018/11/22/3590/801/country');
                        $view->siteData = $siteData;
                        echo Helpers_View::viewToStr($view);
                        ?>
                        <p>
                            <label for="name">Nazwisko <span color="red">*</span></label><br>
                            <input type="text" name="name" size="60" maxlength="60" class="form-control" required>
                        </p>
                        <p>
                            <label for="email">E-mail<span color="red">*</span></label><br>
                            <input id="email" type="email" name="options[email]" size="40" maxlength="40"class="form-control" required>
                        </p>
                        <p>
                            <label for="phone">Telefon<span color="red">*</span></label><br>
                            <input id="phone" type="text" name="options[phone]" size="40" maxlength="40" class="form-control" required>
                        </p>
                        <p>
                            <label for="position">Position</label><br>
                            <input id="position" type="text" name="options[position]" size="40" maxlength="40" class="form-control" required>
                        </p>
                        <div id="otherField">
                            <label>Files:</label><br>
                            <label for="file" class="btn btn-block btn-danger btn-lg btn-file">Select</label>
                            <div class="file-list" id="files"></div>
                            <input class="load-file" id="file" name="options[file]" accept="jpg,png,jpeg,gif" value="/" type="file"
                                   onchange='document.querySelector("#files").innerHTML = Array.from(this.files).map(f => f.name).join("<br />")' />
                        </div>
                        <p>
                            <label for="text">Wiadomość<font color="red">*</font></label><br>
                            <textarea id="text" cols="40" rows="10" name="text" class="form-control" required></textarea>
                        </p>
                        <div class="form-group box-captcha">
                            <img id="img-captcha" src="/command/get_image_captcha" style="float: left;">

                            <div id="reload-captcha" class="btn btn-block btn-danger btn-lg btn-send"><i class="glyphicon glyphicon-refresh"></i> Odśwież</div>
                            <script src="<?php echo $siteData->urlBasic; ?>/css/_component/captcha/captcha.js"></script>
                        </div>
                        <div class="form-group">
                            <label id="label-captcha" for="image_captcha" class="control-label">Wpisz kod z powyższego obrazka:</label>
                            <input id="text-captcha" name="image_captcha" type="text" class="form-control" required value="">
                        </div>
                        <input name="type" value="15132" hidden> <input name="symbol" value="0" hidden>
                        <input name="options[url]" hidden value="<?php echo  ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];?>">
                        <button id="button-send" class="btn btn-block btn-danger btn-lg btn-send" type="button">Wyślij</button>
                    </form>
                    <script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/input-mask/jquery.inputmask.js"></script>
                    <script>
                        $('#button-send').on('click', function(e){
                            e.preventDefault();
                            $('[name="symbol"]').val(15132);

                            var $that = $('#form-send'),
                                formData = new FormData($that.get(0)); // создаем новый экземпляр объекта и передаем ему нашу форму (*)


                            var isOK = true;

                            el = $that.find('[name="name"]');
                            var s = el.val();
                            $that.find('[data="'+el.attr('id')+'"]').remove();
                            if (s == ''){
                                el.after('<span data="'+el.attr('id')+'" class="text--title alert--error">Заполните "Ваше имя"</span>');
                                isOK = false;
                            }

                            el = $that.find('[id="email"]');
                            var s = el.val();
                            $that.find('[data="'+el.attr('id')+'"]').remove();
                            if ((s == '') || (!(/^[\.a-zA-Z0-9_-]+@[a-zA-Z0-9-]+\.[a-zA-Z]{2,6}$/i.test(s)))){
                                el.after('<span data="'+el.attr('id')+'" class="text--title alert--error">Введите корректный "E-mail"</span>');
                                isOK = false;
                            }

                            el = $that.find('[id="phone"]');
                            var s = el.val();
                            $that.find('[data="'+el.attr('id')+'"]').remove();
                            if ((s == '') || (!(/^\s?(\+\s?[0-9])([- ()]*\d){10,11}$/i.test(s)))){
                                el.after('<span data="'+el.attr('id')+'" class="text--title alert--error">Введите корректный "Телефон"</span>');
                                isOK = false;
                            }

                            el = $that.find('[name="text"]');
                            var s = el.val();
                            $that.find('[data="'+el.attr('id')+'"]').remove();
                            if (s == ''){
                                el.after('<span data="'+el.attr('id')+'" class="text--title alert--error">Введите текст сообщения</span>');
                                isOK = false;
                            }

                            var el = $that.find('[name="image_captcha"]');
                            var s = el.val();
                            $that.find('[data="'+el.attr('id')+'"]').remove();
                            if (s == ''){
                                el.after('<span data="'+el.attr('id')+'" class="text--title alert--error">Введите код с картинки</span>');
                                isOK = false;
                            }

                            if (isOK){
                                var url = $that.attr('action');
                                jQuery.ajax({
                                    url: url,
                                    data: formData,
                                    type: "POST",
                                    contentType: false, // важно - убираем форматирование данных по умолчанию
                                    processData: false, // важно - убираем преобразование строк по умолчанию
                                    success: function (data) {
                                        $('#modal-send').modal('show');
                                    },
                                    error: function (data) {
                                        console.log(data.responseText);

                                        var el = $that.find('[name="image_captcha"]');
                                        $that.find('[data="'+el.attr('id')+'"]').remove();
                                        el.after('<span data="'+el.attr('id')+'" class="text--title alert--error">Введите код с картинки</span>');
                                        isOK = false;
                                    }
                                });
                            }

                            return false;
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</header>
<div id="modal-send" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Message was sent</h4>
            </div>
            <div class="modal-body">
                <p>Message was sent, soon our adviser will contact you…</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-block btn-danger btn-lg btn-send pull-right" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>