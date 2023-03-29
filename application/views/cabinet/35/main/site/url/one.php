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

<section class="content-header">
    <h1>
        HTML тела страницы
        <small style="margin-right: 10px;">редактирование</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Func::getFullURL($siteData, '/shop/edit'); ?>"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li class="active">HTML тела страницы</li>
    </ol>
</section>
<section class="content padding-5">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary padding-t-5">
                <div class="box-body pad table-responsive">
                    <form action="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/site/save_url" method="post" style="padding-right: 5px;">
                        <div class="col-md-12">
                            <div class="row">
                                <?php if(!Func::_empty(trim($siteData->globalDatas['view::site/view/list/list']))){; ?>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Добавить вьюшку</label>
                                            <div class="input-group">
                                                <select class="form-control select2" id="views" style="width:100%;">
                                                    <option value="">Выберите поле</option>
                                                    <?php echo trim($siteData->replaceDatas['view::site/view/list/list']); ?>
                                                </select>
                                                <div class="input-group-btn">
                                                    <a href="" data-action="insert-views" data-textarea="html" data-select="views" class="btn btn-danger">Вставить</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }?>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Добавить ссылку</label>
                                        <div class="input-group">
                                            <select class="form-control select2" id="urls" style="width:100%;">
                                                <option value="">Выберите поле</option>
                                                <?php echo trim($siteData->replaceDatas['view::site/url/list/list']); ?>
                                            </select>
                                            <div class="input-group-btn">
                                                <a href="" data-action="insert-urls" data-textarea="html" data-select="urls" class="btn btn-danger">Вставить</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Добавить файл</label>
                                        <div class="input-group">
                                            <select class="form-control select2" id="files" style="width:100%;">
                                                <option value="">Выберите поле</option>
                                                <?php echo trim($siteData->replaceDatas['view::site/file/list/list']); ?>
                                            </select>
                                            <div class="input-group-btn">
                                                <a href="" data-action="insert-files" data-textarea="html" data-select="files" class="btn btn-danger">Вставить</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="row">
                                <div style="border-width: 1px; border-style: solid; border-color: #00b9f2; height: 325px">
                                <textarea name="html" id="html" rows="30" cols="60"><?php echo trim($data['view::html']); ?></textarea>
                                <script type="text/javascript">
                                    var editor = CodeMirror.fromTextArea(document.getElementById("html"), {
                                        styleActiveLine: true,
                                        lineNumbers: true,
                                        lineWrapping: true,
                                        matchBrackets: true,
                                        matchTags: {bothTags: true},
                                        mode: "application/x-httpd-php",
                                        extraKeys: {"Ctrl-Space": "autocomplete"},
                                        autoCloseTags: true,
                                        indentUnit: 4,
                                        indentWithTabs: true,
                                        enterMode: "keep",
                                        tabMode: "shift",
                                        extraKeys: {
                                            "Ctrl-Q": function(cm){
                                                cm.foldCode(cm.getCursor());
                                            },
                                            "F11": function(cm) {
                                                cm.setOption("fullScreen", !cm.getOption("fullScreen"));
                                            },
                                            "Esc": function(cm) {
                                                if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
                                            },
                                            "Ctrl-J": "toMatchingTag"
                                        },
                                        foldGutter: true,
                                        gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"],
                                        matchTags: {bothTags: true},
                                    });
                                </script>
                            </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row margin-t-15 text-center">
                                <div style="display: none">
                                    <input name="id" value="<?php echo Request_RequestParams::getParamInt('id'); ?>"/>
                                    <input name="url" value="<?php echo Request_RequestParams::getParamStr('url'); ?>"/>
                                    <input name="language" value="<?php echo Request_RequestParams::getParamInt('language'); ?>"/>
                                </div>
                                <button class="btn btn-primary" type="submit">Сохранить</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="<?php echo $siteData->urlBasic; ?>/css/cabinet/js/php.js"></script>