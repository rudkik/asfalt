<div id="dialog-exit-ok" class="modal" data-id="0">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #0097bc;color: #fff;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Можно ли машину выпустить?</h4>
            </div>
            <div class="modal-body">
                <div id="html-exit-ok">
                    <div class="row">
                        <div data-status="error" class="text-red col-md-12" style="">
                            <div class="pull-left" style="font-size: 50px;"><i class="fa fa-fw fa-hand-stop-o"></i></div>
                            <h3 class="pull-left" style="padding-top: 22px;">Долг: 4 060 тг</h3>
                        </div>
                        <div data-status="ok" class="text-blue col-md-12">
                            <div class="pull-left" style="font-size: 50px"><i class="fa fa-fw fa-hand-peace-o"></i></div>
                            <h3 class="pull-left" style="padding-top: 22px;">Машину можно выпускать</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="btn-group pull-left">
                    <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        ТТН
                        <span class="caret"></span>
                        <span class="sr-only">ТТН</span>
                    </button>
                    <ul class="dropdown-menu" role="menu" style="font-size: 18px;">
                        <li><a href="javascript:PrintTTN('1')">1</a></li>
                        <li><a href="javascript:PrintTTN('1-2')">1-2</a></li>
                        <li><a href="javascript:PrintTTN('1-4')">1-4</a></li>
                        <li><a href="javascript:PrintTTN('1-5')">1-5</a></li>
                        <li><a href="javascript:PrintTTN('2-4')">2-4</a></li>
                    </ul>
                </div>
                <button type="button" class="btn btn-default pull-left" onclick="PrintTalon();"><i class="fa fa-fw fa-print"></i> Талон</button>
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal" onclick="window.location.reload();">Закрыть</button>
            </div>
        </div>
    </div>
</div>
<script>
    function PrintTTN(pages) {
        var id = $('#dialog-exit-ok').data('id');
        var type = $('#dialog-exit-ok').data('type');

        jQuery.ajax({
            url: '/weighted/data/save',
            data: ({
                'action': ('print'),
                'type': ('ttn'),
                'table_id': (type),
                'pages': (pages),
                'id': (id)
            }),
            type: "GET",
            success: function (dataBrutto) {
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    }

    function PrintTalon() {
        var id = $('#dialog-exit-ok').data('id');
        var type = $('#dialog-exit-ok').data('type');

        jQuery.ajax({
            url: '/weighted/data/save',
            data: ({
                'action': ('print'),
                'type': ('talon'),
                'table_id': (type),
                'id': (id)
            }),
            type: "GET",
            success: function (dataBrutto) {
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    }
</script>