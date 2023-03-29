<h3 class="head-title">
    <a style="text-decoration: underline;" href="<?php echo $siteData->urlBasic; ?>/superadmin/site/staticview?id=<?php echo Request_RequestParams::getParamInt('id'); ?>&url=<?php echo Request_RequestParams::getParamStr('url'); ?>&language=<?php echo Request_RequestParams::getParamInt('language'); ?>&view=<?php echo Request_RequestParams::getParamInt('view'); ?>">
        <?php echo $data->values['title_view']; ?></a>

    <?php if(key_exists('title_group', $data->values)){ ?>
        &nbsp;&nbsp;>>>>&nbsp;&nbsp;
        <a style="text-decoration: underline; color: #777;" href="<?php echo $siteData->urlBasic; ?>/superadmin/site/staticviewgroup?id=<?php echo Request_RequestParams::getParamInt('id'); ?>&url=<?php echo Request_RequestParams::getParamStr('url'); ?>&language=<?php echo Request_RequestParams::getParamInt('language'); ?>&view=<?php echo Request_RequestParams::getParamInt('view'); ?>">
            <?php echo $data->values['title_group']['ru']; ?></a>
    <?php } ?>
</h3>

<?php if($data->values['is_one'] === FALSE){?>
    <div class="row" style="margin: 0px;">
        <div class="col-md-12">
            <div class="row" style="margin-bottom: 8px;">
                <strong style="margin-top: 17px; position: absolute;">Html списка вьюшки</strong>
                <a href="<?php echo htmlspecialchars('javascript:addList(\'<div>\r\n<?php\r\n$n = 1;\r\n$i = 1;\r\nforeach ($data['.htmlspecialchars('\'', ENT_QUOTES).'view::'.str_replace('\\', '\\'.'\\', $data->values['tag_list']).htmlspecialchars('\'', ENT_QUOTES).']->childs as $value){\r\n    if($i == $n + 1){\r\n        echo '.htmlspecialchars('\'', ENT_QUOTES).'</div><div>'.htmlspecialchars('\'', ENT_QUOTES).';\r\n        $i = 1;\r\n    }\r\n    $i++;\r\n    echo $value->str;\r\n}\r\n?>\r\n</div>\')', ENT_QUOTES); ?>"
                   class="btn btn-primary pull-right btn-insert-list">Разбитый список</a>

                <a href="<?php echo htmlspecialchars('javascript:addList(\'<?php \r\n foreach ($data[' . htmlspecialchars('\'', ENT_QUOTES). 'view::' . str_replace('\\', '\\'.'\\', $data->values['tag_list']) . htmlspecialchars('\'', ENT_QUOTES) . ']->childs as $value){\r\n' . "\t" . 'echo $value->str;\r\n}\r\n' . '?>\')', ENT_QUOTES); ?>"
                   class="btn btn-primary pull-right btn-insert-list">Cтандартный список</a>
            </div>

            <div class="row" style="border-width: 1px; border-style: solid; border-color: #00b9f2; height: 325px;">
                <textarea name="list" id="list" rows="30" cols="60"><?php echo $data->values['list']; ?></textarea>
                <script type="text/javascript">
                    var editor_list = CodeMirror.fromTextArea(document.getElementById("list"), {
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

            <!--  <textarea name="list" textarea="three" view="3" id="three" cols="30" rows="10" class="form-control"
                  placeholder="Ввод текста"><?php echo $data->values['list']; ?></textarea>
                  -->
        </div>
    </div>
<?php } ?>

<div class="row">
    <div class="col-md-12">
        <div class="row top20" style="margin-left: 0px; margin-right: 0px; ">
            <span class="add-magazin-bold">
                Html вьюшки одной записи
            </span>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4 div-select">
                        <strong>Добавить функцию:</strong>
                        <div class="row">
                            <div class="col-md-8" id="child1" textarea="one">
                                <select class="form-control select">
                                    <?php echo trim($data->additionDatas['view::site/funcs']); ?>
                                </select>
                            </div>
                            <div class="col-md-4" style="min-width: 109px;">
                                <a  onclick="javascript:addItem(1)" textarea="html" class="btn btn-primary btn-insert">Вставить</a>
                            </div>
                        </div>
                    </div>
                    <?php if(!Func::_empty(trim($data->additionDatas['view::site/fields']))){; ?>
                        <div class="col-md-4 div-select">
                            <strong>Добавить поле:</strong>
                            <div class="row">
                                <div class="col-md-8" id="child2" textarea="html">
                                    <select class="form-control select">
                                        <?php echo trim($data->additionDatas['view::site/fields']); ?>
                                    </select>
                                </div>
                                <div class="col-md-4" style="min-width: 109px;">
                                    <a onclick="javascript:addData(2)" class="btn btn-primary btn-insert">Вставить</a>
                                </div>
                            </div>
                        </div>
                    <?php }?>
                </div>
            </div>
        </div>

        <div class="row" style="margin: 0px; border-width: 1px; border-style: solid; border-color: #00b9f2; height: 325px;">
            <textarea name="one" id="one" rows="30" cols="60"><?php echo $data->values['one']; ?></textarea>
            <script type="text/javascript">
                var editor = CodeMirror.fromTextArea(document.getElementById("one"), {
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
<div class="add-magazin-save-btns">
    <input name="id" value="<?php echo Request_RequestParams::getParamInt('id'); ?>" hidden="hidden"/>
    <input name="url" value="<?php echo Request_RequestParams::getParamStr('url'); ?>" hidden="hidden"/>
    <input name="language" value="<?php echo Request_RequestParams::getParamInt('language'); ?>" hidden="hidden"/>
    <input name="view" value="<?php echo Request_RequestParams::getParamInt('view'); ?>" hidden="hidden"/>
    <button type="submit" name="save" class="btn btn-primary btn-flat-oto">Сохранить</button>
</div>