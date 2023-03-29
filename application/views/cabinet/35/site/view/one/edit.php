<section class="content-header">
    <h1>
        <a style="text-decoration: underline; color: #777;" href="<?php echo $siteData->urlBasic; ?>/cabinet/site/staticview?id=<?php echo Request_RequestParams::getParamInt('id'); ?>&url=<?php echo Request_RequestParams::getParamStr('url'); ?>&language=<?php echo Request_RequestParams::getParamInt('language'); ?>&view=<?php echo Request_RequestParams::getParamInt('view'); ?>">
            <?php echo $data->values['title_view']; ?></a>

        <?php if(key_exists('title_group', $data->values)){ ?>
            &nbsp;&nbsp;>>>>&nbsp;&nbsp;
            <a style="text-decoration: underline;" href="<?php echo $siteData->urlBasic; ?>/cabinet/site/view_group?id=<?php echo Request_RequestParams::getParamInt('id'); ?>&url=<?php echo Request_RequestParams::getParamStr('url'); ?>&language=<?php echo Request_RequestParams::getParamInt('language'); ?>&view=<?php echo Request_RequestParams::getParamInt('view'); ?>">
                <?php echo $data->values['title_group']['ru']; ?></a>
        <?php } ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Func::getFullURL($siteData, '/shop/edit'); ?>"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li class="active"><?php echo $data->values['title_view']; ?></li>
    </ol>
</section>
<section class="content padding-5">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary padding-t-5">
                <div class="box-body pad table-responsive">
                    <form action="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/site/save_view" method="post" style="padding-right: 5px;">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab1" data-toggle="tab">Html вьюшки</a></li>
                                <?php if(!Func::_empty(trim($siteData->replaceDatas['view::site/param/list/list']))){; ?>
                                    <li class="<?php if($data->values['is_one']){echo 'active';}?>"><a href="#tab2" data-toggle="tab">Список параметров</a></li>
                                <?php }?>
                                <li class=""><a href="#tab4" data-toggle="tab">Приоритеты считывания</a></li>
                            </ul>
                            <div class="tab-content">
                                    <div class="active tab-pane" id="tab1">
                                        <?php if($data->values['is_one'] === FALSE){?>
                                        <div class="row margin-b-20">
                                            <div class="col-md-12 margin-b-10">
                                                <h4 style="margin-top: 17px; position: absolute;">Html списка вьюшки</h4>
                                                <a href="<?php echo htmlspecialchars('javascript:addList(\'<div>\r\n<?php\r\n$n = 1;\r\n$i = 1;\r\nforeach ($data['.htmlspecialchars('\'', ENT_QUOTES).'view::'.str_replace('\\', '\\'.'\\', $data->values['tag_list']).htmlspecialchars('\'', ENT_QUOTES).']->childs as $value){\r\n    if($i == $n + 1){\r\n        echo '.htmlspecialchars('\'', ENT_QUOTES).'</div><div>'.htmlspecialchars('\'', ENT_QUOTES).';\r\n        $i = 1;\r\n    }\r\n    $i++;\r\n    echo $value->str;\r\n}\r\n?>\r\n</div>\')', ENT_QUOTES); ?>"
                                                   class="btn btn-primary pull-right margin-l-5">Разбитый список</a>

                                                <a href="<?php echo htmlspecialchars('javascript:addList(\'<?php \r\n foreach ($data[' . htmlspecialchars('\'', ENT_QUOTES). 'view::' . str_replace('\\', '\\'.'\\', $data->values['tag_list']) . htmlspecialchars('\'', ENT_QUOTES) . ']->childs as $value){\r\n' . "\t" . 'echo $value->str;\r\n}\r\n' . '?>\')', ENT_QUOTES); ?>"
                                                   class="btn btn-primary pull-right">Cтандартный список</a>
                                            </div>
                                            <div class="col-md-12">
                                                <div style="border-width: 1px; border-style: solid; border-color: #00b9f2; height: 325px;">
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
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h4>Html вьюшки одной записи</h4>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Добавить функцию</label>
                                                            <div class="input-group">
                                                                <select class="form-control select2" id="functions" style="width:100%;">
                                                                    <option>Выберите функцию</option>
                                                                    <?php echo trim($siteData->replaceDatas['view::site/func/list/list']); ?>
                                                                </select>
                                                                <div class="input-group-btn">
                                                                    <a href="" data-action="insert-functions" data-textarea="one" data-select="functions" class="btn btn-danger">Вставить</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php if(!Func::_empty(trim($siteData->replaceDatas['view::site/field/list/list']))){; ?>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Добавить поле</label>
                                                                <div class="input-group">
                                                                    <select class="form-control select2" id="fields" style="width:100%;">
                                                                        <option value="">Выберите поле</option>
                                                                        <?php echo trim($siteData->replaceDatas['view::site/field/list/list']); ?>
                                                                    </select>
                                                                    <div class="input-group-btn">
                                                                        <a href="" data-action="insert-fields" data-textarea="one" data-select="fields" class="btn btn-danger">Вставить</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php }?>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div style="border-width: 1px; border-style: solid; border-color: #00b9f2; height: 325px; width: 200px; min-width: 100%;">
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
                                                                    "Ctrl-Q": function (cm) {
                                                                        cm.foldCode(cm.getCursor());
                                                                    },
                                                                    "F11": function (cm) {
                                                                        cm.setOption("fullScreen", !cm.getOption("fullScreen"));
                                                                    },
                                                                    "Esc": function (cm) {
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
                                    </div>
                                <div class="tab-pane" id="tab3" data-fistr="1">
                                </div>
                                <?php if(!Func::_empty(trim($siteData->replaceDatas['view::site/param/list/list']))){; ?>
                                    <div class="tab-pane" id="tab2">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Список параметров</label>
                                            </div>
                                            <div class="col-md-12">
                                                <?php echo $siteData->globalDatas['view::site/param/list/list']; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php }?>
                                <div class="tab-pane" id="tab4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Приоритеты считывания параметров</label>
                                        </div>
                                        <div class="col-md-12">
                                            <?php echo $siteData->globalDatas['view::site/param/type/one/edit']; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <div class="row">
                                <div style="display: none">
                                    <input name="id" value="<?php echo Request_RequestParams::getParamInt('id'); ?>"/>
                                    <input name="url" value="<?php echo Request_RequestParams::getParamStr('url'); ?>"/>
                                    <input name="language" value="<?php echo Request_RequestParams::getParamInt('language'); ?>"/>
                                    <input name="view" value="<?php echo Request_RequestParams::getParamInt('view'); ?>"/>
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