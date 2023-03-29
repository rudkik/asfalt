<header class="header-bread-crumbs">
    <div class="container">
        <h2>Contact us</h2>
        <div class="box-bread-crumbs">
            <a href="<?php echo $siteData->urlBasicLanguage; ?>">Main</a> |
            <span>Contact us</span>
        </div>
    </div>
</header>
<header class="header-contact-list">
    <div class="container">
        <h1 itemprop="name">Contact us</h1>
        <div class="row">
            <div class="col-md-8">
                <ul class="nav nav-tabs">
                    <?php echo trim($siteData->globalDatas['view::View_Shop_Addresss\-contact-us-fillialy-zagolovki']); ?>
                </ul>
                <div class="tab-content">
                    <?php echo trim($siteData->globalDatas['view::View_Shop_Addresss\-contact-us-fillialy']); ?>
                </div>
            </div>
            <div class="col-md-4">
                <script>
                    $(document).ready(function() {
                        $.viewInput = {
                            '0' : $([]),
                            'otherField' : $('#otherField'),
                        };

                        $('#otherFieldOption').change(function() {
                            $.each($.viewInput, function() { this.hide(); });
                            $.viewInput[$(this).val()].show();
                        });

                    });
                </script>
                <div id="respond">
                    <form id="form-send" class="ajax_form" method="post" action="/command/message_add" enctype="multipart/form-data">
                        <?php
                        $view = View::factory('2018/11/22/3590/36/country');
                        $view->siteData = $siteData;
                        echo Helpers_View::viewToStr($view);
                        ?>
                        <p>
                            <label for="name">Name <span color="red">*</span></label><br>
                            <input type="text" name="name" size="60" maxlength="60" class="form-control" required>
                        </p>
                        <p>
                            <label for="email">E-mail<span color="red">*</span></label><br>
                            <input id="email" type="email" name="options[email]" size="40" maxlength="40"class="form-control" required>
                        </p>
                        <p>
                            <label for="phone">Phone<span color="red">*</span></label><br>
                            <input id="phone" type="text" name="options[phone]" size="40" maxlength="40" class="form-control" required>
                        </p>
                        <p>
                            <label accesskey="s" for="title">Head</label><br>
                            <select class="form-control" id="title" name="options[title]" id="otherFieldOption" style="width: 100%">
                                <?php echo trim($siteData->globalDatas['view::View_Shop_News\tema']); ?>
                            </select>
                        </p>
                        <div id="otherField">
                            <label>Attach existing pictures of equipment or text file:</label><br>
                            <label for="file" class="btn btn-block btn-danger btn-lg btn-file">Attach file</label>
                            <div class="file-list" id="files"></div>
                            <input class="load-file" id="file" name="options[file]" accept="jpg,png,jpeg,gif" value="/" type="file"
                                   onchange='document.querySelector("#files").innerHTML = Array.from(this.files).map(f => f.name).join("<br />")' />
                        </div>
                        <p>
                            <label for="text">Message<font color="red">*</font></label><br>
                            <textarea id="text" cols="40" rows="10" name="text" class="form-control" required></textarea>
                        </p>
                        <div class="form-group box-captcha">
                            <img id="img-captcha" src="/command/get_image_captcha" style="float: left;">

                            <div id="reload-captcha" class="btn btn-block btn-danger btn-lg btn-send"><i class="glyphicon glyphicon-refresh"></i> Refresh</div>
                            <script src="<?php echo $siteData->urlBasic; ?>/css/_component/captcha/captcha.js"></script>
                        </div>
                        <div class="form-group">
                            <label id="label-captcha" for="image_captcha" class="control-label">Please provide captcha code:</label>
                            <input id="text-captcha" name="image_captcha" type="text" class="form-control" required value="">
                        </div>
                        <input name="type" value="15132" hidden> <input name="symbol" value="0" hidden>
                        <input name="options[url]" hidden value="<?php echo  ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];?>">
                        <button id="button-send" class="btn btn-block btn-danger btn-lg btn-send" type="button">Send</button>
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
                                el.after('<span data="'+el.attr('id')+'" class="text--title alert--error">Please provide your first and last name</span>');
                                isOK = false;
                            }

                            el = $that.find('[id="email"]');
                            var s = el.val();
                            $that.find('[data="'+el.attr('id')+'"]').remove();
                            if ((s == '') || (!(/^[\.a-zA-Z0-9_-]+@[a-zA-Z0-9-]+\.[a-zA-Z]{2,6}$/i.test(s)))){
                                el.after('<span data="'+el.attr('id')+'" class="text--title alert--error">Please provide your correct e-mail</span>');
                                isOK = false;
                            }

                            el = $that.find('[id="phone"]');
                            var s = el.val();
                            $that.find('[data="'+el.attr('id')+'"]').remove();
                            if ((s == '') || (!(/^\s?(\+\s?[0-9])([- ()]*\d){10,11}$/i.test(s)))){
                                el.after('<span data="'+el.attr('id')+'" class="text--title alert--error">Please provide your correct tel number</span>');
                                isOK = false;
                            }

                            el = $that.find('[name="text"]');
                            var s = el.val();
                            $that.find('[data="'+el.attr('id')+'"]').remove();
                            if (s == ''){
                                el.after('<span data="'+el.attr('id')+'" class="text--title alert--error">Please describe your request</span>');
                                isOK = false;
                            }

                            var el = $that.find('[name="image_captcha"]');
                            var s = el.val();
                            $that.find('[data="'+el.attr('id')+'"]').remove();
                            if (s == ''){
                                el.after('<span data="'+el.attr('id')+'" class="text--title alert--error">Please provide captcha code</span>');
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
                                        el.after('<span data="'+el.attr('id')+'" class="text--title alert--error">Please provide actual code</span>');
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
                <button type="button" class="btn btn-block btn-danger btn-lg btn-send  pull-right" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>