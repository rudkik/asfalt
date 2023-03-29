<div id="dialog-entry-error" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #c23321;color: #fff;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Ошибка, вес машины не получилось определить</h4>
            </div>
            <form action="<?php echo Func::getFullURL($siteData, '/shopcar/save'); ?>" method="post" >
                <div class="modal-body">
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                № автомобиля
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input name="name" type="text" data-type="auto-number" class="form-control" placeholder="Введите гос. номер автомобиля">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-primary" onclick="sendTarraNext()">Еще раз</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function sendTarraNext() {
        id = $('#dialog-entry-error').data('id');
        var name = $('#dialog-entry-error input[name="name"]').val();

        jQuery.ajax({
            url: '/weighted/data/get',
            data: ({}),
            type: "POST",
            success: function (dataTarra) {
                var objTarra = jQuery.parseJSON($.trim(dataTarra));
                var tarra = objTarra.weight;
                jQuery.ajax({
                    url: '/weighted/shopcar/send_tarra',
                    data: ({
                        id: (id),
                        tarra: (tarra),
                        json: (1),
                        name: (name),
                    }),
                    type: "POST",
                    success: function (data) {
                        var obj = jQuery.parseJSON($.trim(data));
                        if(obj.error == 0){
                            $('#dialog-entry-error').modal('hide');
                            $('#html-entry-ok').html(obj.html);
                            $('#dialog-entry-ok').modal('show');
                        }else{
                            alert(obj.msg);
                        }
                    },
                    error: function (data) {
                        console.log(data.responseText);
                    }
                });
            },
            error: function (data) {
                console.log(data.responseText);
                alert('Ошибка запроса веса и номера машины.');
            }
        });
    }
</script>