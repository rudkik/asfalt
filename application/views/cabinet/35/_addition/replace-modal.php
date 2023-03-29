<div id="modal-replace" class="modal fade modal-image">
    <div class="modal-dialog" style="max-width: 600px">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть" style="margin: -40px -40px 0px 0px;"><span aria-hidden="true">×</span></button>
                <div class="modal-fields">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Что заменить?</label>
                                <input name="replace_search" type="text" class="form-control" placeholder="Введите значение, которое необходимо заменить">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>На что</label>
                                <input name="replace_new" type="text" class="form-control" placeholder="Введите значение, на которое необходимо заменить">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Выберите поля для редактирования</label>
                                <select name="replace_where" class="form-control select2" data-placeholder="Выберите где необходимо произвести замену" style="width: 100%;">
                                    <option value="0" data-id="0" selected>Везде</option>
                                    <?php echo trim($siteData->replaceDatas['view::editfields/list']); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <a href="javascript:actionReplaceData();" class="btn btn-primary pull-right">Заменить</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function actionReplaceData() {
        var search = $('input[name="replace_search"]').val();
        var newstr = $('input[name="replace_new"]').val();
        var where = $('select[name="replace_where"]').val().replace('.', '][');

        $('#edit-list td input[name], #edit-list td textarea[name]').each(function () {

            if((where == 0) || ($(this).attr('name').indexOf(where) > -1)){
                s = $(this).val().replace(search, newstr);

                $(this).val(s);
                $(this).attr('value', s);
            }
        });

        $('modal-replace').modal('hide');
        return;
    }
</script>