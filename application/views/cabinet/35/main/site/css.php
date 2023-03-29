<div class="add-magazin">

    <?php if(Request_RequestParams::getParamInt('id') > 0){?>
        <section>
            <div class="row">
                <div class="col-md-12">
                    <nav class="navbar navbar-default navbar-top" role="navigation">
                        <ul class="nav navbar-nav">
                            <li><a href="<?php echo $siteData->urlBasic;?>/superadmin/site/index?id=<?php echo Request_RequestParams::getParamInt('id');?>">Информация о магазине</a></li>
                            <li class="active"><a href="<?php echo $siteData->urlBasic;?>/superadmin/site/css?id=<?php echo Request_RequestParams::getParamInt('id');?>">CSS</a></li>
                            <li><a href="<?php echo $siteData->urlBasic;?>/superadmin/site/urls?id=<?php echo Request_RequestParams::getParamInt('id');?>">Ссылки</a></li>
                            <li><a href="<?php echo $siteData->urlBasic;?>/superadmin/site/clientdata?id=<?php echo Request_RequestParams::getParamInt('id');?>">Данные для заполнения</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </section>
    <?php }?>

    <section class="content bg-white" style="padding-top: 0px;">
        <div class="col-md-12">
            <h3 class="head-title" style="margin-left: -15px;">
                CSS-стили
            </h3>
            <div class="row">
                <strong>Правила для загружаемого файла</strong>
                <div class="add-magazin-instr" style="margin-bottom: 0px;">
                    <ol style="padding-left: 30px;">
                        <li>Zip-файл должен содержить сразу стили.</li>
                        <li>Заменяются все старые файлы при повторной загрузки.</li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <form method="post" enctype="multipart/form-data"
                      action="<?php echo $siteData->urlBasic; ?>/superadmin/site/loadcss?id=<?php echo Request_RequestParams::getParamInt('id'); ?>">
                    <div class="col-md-3 file-upload-css">
                        <label>
                            <input type="file" name="filename" id="filename">
                            <span>Выберите файл</span>
                        </label>
                    </div>
                    <input class="btn btn-primary btn-oto-flo" type='submit' value='Сохранить'>
                </form>
            </div>
            <div class="row top20">
                <div class="catalog-struct">
                    <div>
                        <strong>Структура каталогов</strong>
                        <a style="margin-left: 20px;" href="<?php echo $siteData->urlBasic; ?>/superadmin/site/cleardir?id=<?php echo Request_RequestParams::getParamInt('id'); ?>"
                           class="btn btn-danger btn-sm btn-insert">Очистить каталог</a>
                    </div>
                    <ul class="scrollable-menu" role="menu"  style="border-width: 1px; border-style: solid; border-color: #00b9f2; height: 285px; margin-top: 10px;">
                        <?php echo trim($data['view::site/paths']); ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    $(document).ready(function() {
        $('#filename').change(function() {
           // alert($('#filename').val());
        });
    });
</script>