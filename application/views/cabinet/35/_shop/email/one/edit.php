<div class="row">
    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab1" data-toggle="tab">Общая информация</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="tab1">
                    <div class="row record-input record-tab">
                        <div class="col-md-3 record-title"></div>
                        <div class="col-md-5" style="max-width: 250px;">
                            <label class="span-checkbox">
                                <input name="is_public" <?php if ($data->values['is_public'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
                                Показать
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                    </div>
                    <div class="row record-input record-tab">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                Заголовок
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input name="name" type="text" class="form-control" placeholder="Заголовок" value="<?php echo htmlspecialchars($data->values['name']);?>">
                        </div>
                    </div>
                    <div class="row record-input record-tab margin-top-10px">
                        <div class="col-md-3 record-title">
                            <label>
                                Вид сообщения
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <select name="email_type_id" class="form-control select2" style="width: 100%;">
                                <option value="0" data-id="0">Без значения</option>
                                <?php echo trim($siteData->globalDatas['view::emailtype/list/list']); ?>
                            </select>
                        </div>
                    </div>
                    <div class="row record-input record-tab">
                        <div class="col-md-3 record-title">
                            <label>
                                Сообщение
                                <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
                            </label>
                        </div>
                        <div class="col-md-9 record-textarea">
                            <div class="row" id="panels-fields" style="padding-bottom: 15px;">
                                <?php echo trim($siteData->globalDatas['view::emailtype/list/options']); ?>
                            </div>
                            <div class="html-editor">
                                <textarea is_editor="1" id="editor"  name="text" placeholder="Сообщение" rows="11" class="form-control"><?php echo $data->values['text']; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
    </div>
</div>
<div class="row">
    <div hidden>
        <input name="data_language_id" value="<?php echo $siteData->dataLanguageID; ?>">
        <?php if($siteData->branchID > 0){ ?>
            <input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
        <?php } ?>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php } ?>
        <?php if($siteData->superUserID > 0){ ?>
            <input name="shop_id" value="<?php echo $siteData->shopID; ?>">
        <?php } ?>
    </div>
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>
<link rel="stylesheet" href="<?php $siteData->urlBasic; ?>/css/_component/CodeMirror/lib/codemirror.css">
<script src="<?php $siteData->urlBasic; ?>/css/_component/CodeMirror/lib/codemirror.js"></script>
<script src="<?php $siteData->urlBasic; ?>/css/_component/CodeMirror/addon/edit/matchbrackets.js"></script>
<script src="<?php $siteData->urlBasic; ?>/css/_component/CodeMirror/mode/htmlmixed/htmlmixed.js"></script>
<script src="<?php $siteData->urlBasic; ?>/css/_component/CodeMirror/mode/xml/xml.js"></script>
<script src="<?php $siteData->urlBasic; ?>/css/_component/CodeMirror/mode/javascript/javascript.js"></script>
<script src="<?php $siteData->urlBasic; ?>/css/_component/CodeMirror/mode/css/css.js"></script>
<script src="<?php $siteData->urlBasic; ?>/css/_component/CodeMirror/mode/clike/clike.js"></script>
<script src="<?php $siteData->urlBasic; ?>/css/_component/CodeMirror/mode/php/php.js"></script>
<script src="<?php $siteData->urlBasic; ?>/css/_component/CodeMirror/addon/selection/active-line.js"></script>
<script src="<?php $siteData->urlBasic; ?>/css/_component/CodeMirror/addon/edit/closetag.js"></script>

<link rel="stylesheet" href="<?php $siteData->urlBasic; ?>/css/_component/CodeMirror/addon/fold/foldgutter.css" />
<script src="<?php $siteData->urlBasic; ?>/css/_component/CodeMirror/addon/fold/foldcode.js"></script>
<script src="<?php $siteData->urlBasic; ?>/css/_component/CodeMirror/addon/fold/foldgutter.js"></script>
<script src="<?php $siteData->urlBasic; ?>/css/_component/CodeMirror/addon/fold/brace-fold.js"></script>
<script src="<?php $siteData->urlBasic; ?>/css/_component/CodeMirror/addon/fold/xml-fold.js"></script>
<script src="<?php $siteData->urlBasic; ?>/css/_component/CodeMirror/addon/fold/markdown-fold.js"></script>
<script src="<?php $siteData->urlBasic; ?>/css/_component/CodeMirror/addon/fold/comment-fold.js"></script>

<script src="<?php $siteData->urlBasic; ?>/css/_component/CodeMirror/addon/display/fullscreen.js"></script>

<script src="<?php $siteData->urlBasic; ?>/css/_component/CodeMirror/addon/edit/matchtags.js"></script>

<script src="<?php $siteData->urlBasic; ?>/css/_component/CodeMirror/addon/hint/html-hint.js"></script>
<script src="<?php $siteData->urlBasic; ?>/css/_component/CodeMirror/addon/hint/show-hint.js"></script>
<link rel="stylesheet" href="<?php $siteData->urlBasic; ?>/css/_component/CodeMirror/addon/hint/show-hint.css">

<script type="text/javascript">
    var editor = CodeMirror.fromTextArea(document.getElementById("editor"), {
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
