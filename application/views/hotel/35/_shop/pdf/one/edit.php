<div id="pdf-edit-record" class="modal fade bd-example-modal-lg modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 1200px; width: 100%">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Редактирование PDF-шаблона</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fa fa-close"></span>
                </button>
            </div>
            <form class="has-validation-callback" action="/hotel/shoppdf/save">
                <div class="modal-body pb0">
                    <div class="container-fluid">
                        <div class="form-group row">
                            <label for="header" class="col-form-label">Верхний колонтитул</label>
                        </div>
                        <div class="form-group row">
                            <div class="col-12 html-editor">
                                <textarea id="pdf-edit-header" name="header" class="form-control" placeholder="Верхний колонтитул"><?php echo htmlspecialchars($data->values['header'], ENT_QUOTES);?></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="body" class="col-form-label">Тело документа</label>
                        </div>
                        <div class="form-group row">
                            <div class="col-12 html-editor" style="height: 325px">
                                <textarea id="pdf-edit-body" name="body" class="form-control" placeholder="Тело документа"><?php echo htmlspecialchars($data->values['body'], ENT_QUOTES);?></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="footer" class="col-form-label">Нижний колонтитул</label>
                        </div>
                        <div class="form-group row">
                            <div class="col-12 html-editor">
                                <textarea id="pdf-edit-footer" name="footer" class="form-control" placeholder="Нижний колонтитул"><?php echo htmlspecialchars($data->values['footer'], ENT_QUOTES);?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary-outline ks-light" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                    <input name="id" value="<?php echo $data->values['id']; ?>" style="display: none">
                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            var editor_header = '';
            var editor_body = '';
            var editor_footer = '';
            $('#pdf-edit-record').on('shown.bs.modal', function (e) {
                editor_header = CodeMirror.fromTextArea(document.getElementById("pdf-edit-header"), {
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
                editor_body = CodeMirror.fromTextArea(document.getElementById("pdf-edit-body"), {
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
                editor_footer = CodeMirror.fromTextArea(document.getElementById("pdf-edit-footer"), {
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
            })

            $('#pdf-edit-record form').on('submit', function(e){
                e.preventDefault();
                var url = $(this).attr('action')+'?json=1';

                var $that = $(this);
                var formData = $(this).serializeArray();
                $.each(formData,function(){
                    if (this.name == 'footer') {
                        this.value = editor_footer.getValue();
                    }
                    if (this.name == 'header') {
                        this.value = editor_header.getValue();
                    }
                    if (this.name == 'body') {
                        this.value = editor_body.getValue();
                    }
                });

                jQuery.ajax({
                    url: url,
                    data: formData,
                    type: "POST",
                    success: function (data) {
                        var obj = jQuery.parseJSON($.trim(data));
                        if (!obj.error) {
                            $('#pdf-edit-record').modal('hide');
                            $('#pdf-data-table').bootstrapTable('updateByUniqueId', {
                                id: obj.values.id,
                                row: obj.values
                            });

                            $that.find('input[type="text"], textarea').val('');
                            $that.find('input[type="checkbox"]').removeAttr("checked");

                            $.notify("Запись сохранена");
                        }
                    },
                    error: function (data) {
                        console.log(data.responseText);
                    }
                });

                return false;
            });
        });
    </script>
</div>
