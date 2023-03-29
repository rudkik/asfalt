<?php
Helpers_SEO::setSEOHeader(Model_Shop_Good::TABLE_NAME, $data, $siteData);
$siteData->siteImage = $data->values['image_path'];

if ($data->values['shop_table_rubric_id'] == 0){
    $_GET['rubric_root_id'] = Arr::path($_GET, '_current_rubric_', 999);
}else{
    $_GET['rubric_root_id'] = Arr::path($_GET, '_current_rubric_', $data->values['shop_table_rubric_id']);
}
?>
<header class="header-bread-crumbs">
    <div class="container">
        <h2><?php echo $data->values['name']; ?></h2>
        <div class="box-bread-crumbs">
            <a href="<?php echo $siteData->urlBasicLanguage; ?>">Main</a> |
            <?php echo trim($siteData->globalDatas['view::View_Shop_Table_Rubrics\-products-khlebnye-kroshki']); ?>
            <span><?php echo $data->values['name']; ?></span>
        </div>
    </div>
</header>
<header itemscope itemtype="http://schema.org/Product" class="header-goods">
    <div class="container">
        <div class="row">
            <div class="col-md-7 box-good-name">
                <div class="goods-title">
                    <h1 itemprop="name"><?php echo $data->values['name']; ?></h1>
                </div>
                <div class="line-red"></div>
                <div class="image-hashtags">
                    <div class="box-tags">
                        <div class="row">
                            <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\-product-kheshtegi']); ?>
                            <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\-product-kheshtegi-ostalnye']); ?>
                        </div>
                    </div>
                </div>
                <div class="buttons">
                    <a class="btn btn-info btn-flat btn-red" <?php if (Func::_empty(Arr::path($data->values['options'], 'pdf.file', ''))){?>disabled<?php }else{ ?>href="<?php echo Arr::path($data->values['options'], 'pdf.file', ''); ?>"<?php } ?>>PDF</a>
                    <a href="#" class="btn btn-info btn-flat btn-red" <?php if (!Func::_empty(Arr::path($data->values['options'], 'youtube', ''))){echo 'data-toggle="modal" data-target="#show-youtube"';}else{echo 'disabled';} ?>>Youtube</a>
                    <a href="#" data-toggle="modal" data-target="#show-send" class="btn btn-info btn-flat btn-red">Message</a>
                </div>
                <?php if (!Func::_empty(Arr::path($data->values['options'], 'info', ''))){ ?>
                    <div class="box_text margin-b-40">
                        <?php echo Arr::path($data->values['options'], 'info', ''); ?>
                    </div>
                <?php } ?>
                <?php
                $table = Arr::path($data->values['options'], 'table', array());
                if (!empty($table)){?>
                    <table class="table table-red margin-b-40">
                        <tr>
                            <td colspan="2">GENERAL TECHNICAL DATA</td>
                        </tr>
                        <?php
                        foreach ($table as $child){
                            if(Arr::path($child, 'is_public', FALSE)){
                                ?>
                                <tr>
                                    <td><?php echo Arr::path($child, 'name', ''); ?></td>
                                    <td><?php echo Arr::path($child, 'title', ''); ?></td>
                                </tr>
                                <?php
                            }
                        } ?>
                    </table>
                <?php } ?>
            </div>
            <div class="col-md-5">
                <div class="box-images">
                    <?php
                    $files = Arr::path($data->values, 'files', array());
                    if (count($files) > 0){
                        ?>
                        <div class="photo-list" id="sliders">
                            <?php
                            $i = 0;
                            $files = Arr::path($data->values, 'files', array());
                            foreach($files as $index => $file) {
                                $type = intval(Arr::path($file, 'type', 0));
                                if(($type == Model_ImageType::IMAGE_TYPE_IMAGE) || (($type == 0))){
                                    $i++;
                                    ?>
                                    <div class="item<?php if($i == 1){echo ' active';} ?>">
                                        <a data-fancybox="gallery" href="<?php echo Arr::path($file, 'file', '');?>" data-width="<?php echo Arr::path($file, 'w', '');?>" data-height="<?php echo Arr::path($file, 'h', '');?>">
                                            <img class="img-fluid" src="<?php echo Helpers_Image::getPhotoPath($file['file'], 571, 379);?>" alt="<?php $s = Arr::path($file, 'title', ''); if(empty($s)){$s = $data->values['name'];} echo $s;?>" style="margin: 0 auto;">
                                        </a>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    <?php } ?>
                </div>
                <?php if($data->values['shop_table_unit_id'] > 0){?>
                    <div class="box-brand">
                        <a href="<?php echo $siteData->urlBasicLanguage; ?>/brands<?php echo $data->getElementValue('shop_table_unit_id', 'name_url'); ?>">
                            <img class="img-responsive" src="<?php echo Helpers_Image::getPhotoPath($data->getElementValue('shop_table_unit_id', 'image_path'), 237, 0);?>" alt="<?php echo htmlspecialchars($data->getElementValue('shop_table_unit_id', 'name'), ENT_QUOTES); ?>">
                        </a>
                        <div class="box_text">
                            <p><?php echo Func::trimTextNew($data->getElementValue('shop_table_unit_id', 'text'), 250); ?></p>
                        </div>
                    </div>
                <?php }?>
            </div>
        </div>
        <div itemprop="description" class="box_text addition-text">
            <?php echo $data->values['text']; ?>

            <div class="row margin-t-40">
                <div class="col-md-6">
                <?php
                $accessories = Arr::path($data->values['options'], 'accessories', array());
                if (!empty($accessories)){?>
                    <table class="table table-red">
                        <tr>
                            <td>Further Accessories</td>
                            <td>№</td>
                        </tr>
                        <?php
                        foreach ($accessories as $child){
                            if(Arr::path($child, 'is_public', FALSE)){
                                ?>
                                <tr>
                                    <td><?php echo Arr::path($child, 'name', ''); ?></td>
                                    <td><?php echo Arr::path($child, 'title', ''); ?></td>
                                </tr>
                                <?php
                            }
                        } ?>
                    </table>
                <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div style="display: none;">
        <?php if(! empty($data->values['image_path'])){ ?>
            <img src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 900, 750); ?>" itemprop="image">
        <?php } ?>
        <?php if($data->values['price'] > 0){ ?>
            <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                <span itemprop="price"><?php echo $data->values['price']; ?></span>
                <span itemprop="priceCurrency"><?php echo $siteData->currency->getCode(); ?></span>
            </div>
        <?php } ?>
        <div itemscope="" itemtype="http://schema.org/PostalAddress">
            <span itemprop="addressLocality" data-qaid="region">г. <?php $city = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_id.'.Model_Basic_BasicObject::FIELD_ELEMENTS.'.city_id.name', ''); if(empty($city)){$city = $siteData->city->getName();} echo $city; ?></span>
        </div>
    </div>
</header>

<?php if (!Func::_empty(Arr::path($data->values['options'], 'youtube', ''))){ ?>
    <div id="show-youtube" class="dialog-youtube modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="box-close">
                    <button class="close" type="button" data-dismiss="modal"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/f-close.png" class="img-responsive"></button>
                </div>
                <div class="modal-body">
                    <iframe width="728" height="409" src="<?php echo Arr::path($data->values['options'], 'youtube', ''); ?>" frameborder="0" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<div id="show-send" class="dialog-youtube modal fade">
    <div class="modal-dialog" style="max-width: 500px;">
        <div class="modal-content">
            <div class="box-close">
                <button class="close" type="button" data-dismiss="modal"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/f-close.png" class="img-responsive"></button>
            </div>
            <div class="modal-body">
                <div id="respond" style="display: inline-block; width: 100%;">
                    <form id="form-send" class="ajax_form" method="post" action="/command/message_add" enctype="multipart/form-data">
                        <h2 class="text-red">Message</h2>
                        <?php
                        $view = View::factory('2018/11/22/3590/802/country');
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
                            <label for="text">Message<font color="red">*</font></label><br>
                            <textarea id="text" cols="40" rows="5" name="text" class="form-control" required></textarea>
                        </p>
                        <div class="form-group box-captcha">
                            <img id="img-captcha" src="/command/get_image_captcha" style="float: left;">

                            <div id="reload-captcha" class="btn btn-block btn-danger btn-lg btn-send"><i class="glyphicon glyphicon-refresh"></i> تحديث</div>
                            <script src="<?php echo $siteData->urlBasic; ?>/css/_component/captcha/captcha.js"></script>
                        </div>
                        <div class="form-group">
                            <label id="label-captcha" for="image_captcha" class="control-label">الرجاء إدخال الرمز المبين على الصورة</label>
                            <input id="text-captcha" name="image_captcha" type="text" class="form-control" required value="">
                        </div>
                        <input name="type" value="15132" hidden> <input name="symbol" value="0" hidden>
                        <input name="options[url]" hidden value="<?php echo  ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];?>">
                        <button id="button-send" class="btn btn-block btn-danger btn-lg btn-send" type="button">إرسال</button>
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
                            if (s == ''){
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
                                        $('#show-send').modal('hide');
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
</div>
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