$(document).ready(function () {
    $('[data-action="insert-fields"]').click(function () {
        var data = "<?php echo $data->values['" + $('#' + $(this).data('select')).val() + "']; ?>";
        var textarea = $(this).data('textarea');
        $('#' + textarea).insertAtCaret(data);
        editor.replaceSelection(data, editor.getSelection());

        return false;
    });    
    $('[data-action="insert-functions"]').click(function () {
        var data = $('#' + $(this).data('select')).val();
        var textarea = $(this).data('textarea');
        $('#' + textarea).insertAtCaret(data);
        editor.replaceSelection(data, editor.getSelection());

        return false;
    });
    $('[data-action="insert-views"]').click(function () {
        var data = "<?php echo trim($siteData->globalDatas['view::" + $('#' + $(this).data('select')).val() + "']); ?>";
        var textarea = $(this).data('textarea');
        $('#' + textarea).insertAtCaret(data);
        if(textarea == 'header'){
            editor_header.replaceSelection(data, editor_header.getSelection());
        }else{
            if(textarea == 'body'){
                editor_body.replaceSelection(data, editor_body.getSelection());
            }else{
                if(textarea == 'footer'){
                    editor_footer.replaceSelection(data, editor_footer.getSelection());
                }else{
                    editor.replaceSelection(data, editor.getSelection());
                }
            }
        }
 
        return false;
    });
    $('[data-action="insert-files"]').click(function () {
        var data = '<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/' + $('#' + $(this).data('select')).val();
        var textarea = $(this).data('textarea');
        $('#' + textarea).insertAtCaret(data);
        if(textarea == 'header'){
            editor_header.replaceSelection(data, editor_header.getSelection());
        }else{
            if(textarea == 'body'){
                editor_body.replaceSelection(data, editor_body.getSelection());
            }else{
                if(textarea == 'footer'){
                    editor_footer.replaceSelection(data, editor_footer.getSelection());
                }else{
                    editor.replaceSelection(data, editor.getSelection());
                }
            }
        }

        return false;
    });
    $('[data-action="insert-urls"]').click(function () {
        var data = "<?php echo $siteData->urlBasic;?>/" + $('#' + $(this).data('select')).val();
        var textarea = $(this).data('textarea');
        $('#' + textarea).insertAtCaret(data);
        if(textarea == 'header'){
            editor_header.replaceSelection(data, editor_header.getSelection());
        }else{
            if(textarea == 'body'){
                editor_body.replaceSelection(data, editor_body.getSelection());
            }else{
                if(textarea == 'footer'){
                    editor_footer.replaceSelection(data, editor_footer.getSelection());
                }else{
                    editor.replaceSelection(data, editor.getSelection());
                }
            }
        }

        return false;
    });
});

function addList(data) {
    editor_list.replaceSelection(data.replace(/&#039;/g, '\''), editor_list.getSelection());
}