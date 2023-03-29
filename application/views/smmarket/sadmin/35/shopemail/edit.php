<div class="row top20">
    <div class="col-md-12">
        <div class="form-group">
            <input type="checkbox" class="flat-red"<?php if($data->values['is_public'] == 1){ echo 'checked';} ?>> Опубликовать
        </div>

        <div class="form-group">
            <label>Тип сообщения</label>
            <select class="form-control select2" style="width: 100%;" name="email_type_id">
                <option data-id="0" value="0"></option>
                <?php echo trim($siteData->globalDatas['view::emailtypes/list']); ?>
            </select>
        </div>
    </div>

    <div class="col-md-12">
        <strong>Сообщение:</strong>
        <div class="row" id="panels-fields">
            <?php echo trim($siteData->globalDatas['view::emailtypes/options']); ?>
        </div>

        <div class="col-md-12" style="margin: 0px; padding: 0px; border-width: 1px; border-style: solid; border-color: #00b9f2; height: 325px;">
            <textarea is_editor="1" name="text" id="text" placeholder="Сообщение..." rows="7" class="form-control" style="margin: 0px; height: 100%;"><?php echo $data->values['text']; ?></textarea>

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
                var editor = CodeMirror.fromTextArea(document.getElementById("text"), {
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
<div class="row top20">
    <input name="shop_id" type="text" hidden="hidden" value="<?php echo $siteData->shopID;?>">
    <input name="data_language_id" type="text" hidden="hidden" value="<?php echo $siteData->dataLanguageID; ?>">
    <?php if($siteData->branchID > 0){ ?>
        <input name="shop_branch_id" type="text" hidden="hidden" value="<?php echo $siteData->branchID; ?>">
    <?php } ?>

    <div class="col-md-2">
        <input type="submit" value="Сохранить" class="btn btn-primary btn-block"
               onclick="actionSaveObject('<?php echo $siteData->urlBasic . '/cabinet/shopemail/save'; ?>?', <?php if($siteData->action == 'clone') {echo 0;}else{echo $data->id;} ?>, 'edit_panel', 'table_panel', false)">
    </div>
    <div class="col-md-3">
        <input type="submit" value="Сохранить и закрыть" class="btn btn-primary btn-block"
               onclick="actionSaveObject('<?php echo $siteData->urlBasic . '/cabinet/shopemail/save'; ?>?', <?php if($siteData->action == 'clone') {echo 0;}else{echo $data->id;} ?>, 'edit_panel', 'table_panel', true)">
    </div>
</div>
