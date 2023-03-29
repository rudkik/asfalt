<div class="add-magazin">

    <?php if (Request_RequestParams::getParamInt('id') > 0) { ?>
        <section>
            <div class="row">
                <div class="col-md-12">
                    <nav class="navbar navbar-default navbar-top" role="navigation">
                        <ul class="nav navbar-nav">
                            <li>
                                <a href="<?php echo $siteData->urlBasic; ?>/superadmin/site/index?id=<?php echo Request_RequestParams::getParamInt('id'); ?>">Информация
                                    о магазине</a></li>
                            <li>
                                <a href="<?php echo $siteData->urlBasic; ?>/superadmin/site/css?id=<?php echo Request_RequestParams::getParamInt('id'); ?>">CSS</a>
                            </li>
                            <li>
                                <a href="<?php echo $siteData->urlBasic; ?>/superadmin/site/urls?id=<?php echo Request_RequestParams::getParamInt('id'); ?>">Ссылки</a>
                            </li>
                            <li><a href="<?php echo $siteData->urlBasic;?>/superadmin/site/clientdata?id=<?php echo Request_RequestParams::getParamInt('id');?>">Данные для заполнения</a></li>
                            <li>
                                <a href="<?php echo $siteData->urlBasic; ?>/superadmin/site/languages?id=<?php echo Request_RequestParams::getParamInt('id'); ?>&url=<?php echo Request_RequestParams::getParamStr('url'); ?>">Языки</a>
                            </li>
                            <li>
                                <a href="<?php echo $siteData->urlBasic; ?>/superadmin/site/views?id=<?php echo Request_RequestParams::getParamInt('id'); ?>&url=<?php echo Request_RequestParams::getParamStr('url'); ?>&language=<?php echo Request_RequestParams::getParamInt('language'); ?>">Список
                                    вьюшек страницы</a></li>
                            <li><a href="<?php echo $siteData->urlBasic;?>/superadmin/site/url?id=<?php echo Request_RequestParams::getParamInt('id');?>&url=<?php echo Request_RequestParams::getParamStr('url');?>&language=<?php echo Request_RequestParams::getParamInt('language');?>">HTML-тело страницы</a></li>
                            <li class="active"><a
                                    href="<?php echo $siteData->urlBasic; ?>/superadmin/site/view?id=<?php echo Request_RequestParams::getParamInt('id'); ?>&url=<?php echo Request_RequestParams::getParamStr('url'); ?>&language=<?php echo Request_RequestParams::getParamInt('language'); ?>&view=<?php echo Request_RequestParams::getParamInt('view'); ?>">HTML
                                    вьюшки </a></li>

                        </ul>
                    </nav>
                </div>
            </div>
        </section>
    <?php } ?>

    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/lib/codemirror.css">
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/lib/codemirror.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/addon/edit/matchbrackets.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/mode/htmlmixed/htmlmixed.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/mode/xml/xml.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/mode/javascript/javascript.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/mode/css/css.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/mode/clike/clike.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/mode/php/php.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/addon/selection/active-line.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/addon/edit/closetag.js"></script>

    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/addon/fold/foldgutter.css" />
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/addon/fold/foldcode.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/addon/fold/foldgutter.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/addon/fold/brace-fold.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/addon/fold/xml-fold.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/addon/fold/markdown-fold.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/addon/fold/comment-fold.js"></script>

    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/addon/display/fullscreen.js"></script>

    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/addon/edit/matchtags.js"></script>

    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/addon/hint/html-hint.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/addon/hint/show-hint.js"></script>
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/CodeMirror/addon/hint/show-hint.css">

    <form class="content bg-white" method="post" action="<?php echo $siteData->urlBasic; ?>/superadmin/site/saveviewgroup" style="padding-top: 0px;">
        <div class="row">
            <div class="col-md-12">
                <?php echo trim($data['view::site/view-group']); ?>
            </div>
        </div>
    </form>
</div>

