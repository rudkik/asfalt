<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Год
        </label>
    </div>
    <div class="col-md-9">
        <input name="year" type="text" class="form-control" placeholder="Год" required value="<?php echo htmlspecialchars($data->values['year'], ENT_QUOTES);?>">
    </div>
</div>
<?php echo $siteData->globalDatas['view::holiday/list/index'];?>
<div class="row">
    <div hidden>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php } ?>
    </div>
    <div class="modal-footer text-center">
        <button type="button" class="btn btn-primary" onclick="submitButton('holiday-year')">Сохранить</button>
    </div>
</div>
<script>
    function submitButton(id) {
        var isError = false;

        var element = $('#'+id+' [name="year"]');
        if (!$.isNumeric(element.val()) || parseInt(element.val()) < 2000 || parseInt(element.val()) > 2222){
            element.parent().addClass('has-error');
            isError = true;
        }else{
            element.parent().removeClass('has-error');
        }

        if(!isError) {
            var holidays = getCalendarVal();
            jQuery.ajax({
                url: $('#'+id).attr('action')+'?'+$('#'+id).serialize(),
                data: ({
                    'holidays': (holidays),
                }),
                type: "POST",
                success: function (data) {
                    window.location.href = '/<?php echo $siteData->actionURLName; ?>/holidayyear/index';
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });
        }
    }
</script>