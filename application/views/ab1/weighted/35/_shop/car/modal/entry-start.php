<div id="dialog-entry-start" class="modal">
    <div class="modal-dialog" style="max-width: 600px; width: 100%">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #0097bc;color: #fff;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Взвесить машину</h4>
            </div>
            <div class="modal-body">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Номер машины</label>
                                <input class="form-control text-number" data-type="auto-number" name="name" placeholder="Номер машины" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Тара</label>
                                <input class="form-control text-number" name="tarra" placeholder="Тара" type="text" readonly>
                            </div>
                        </div>
                    </div>
                    <input name="id" style="display: none">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary pull-right" onclick="sendTarra()">Зафиксировать</button>
            </div>
        </div>
    </div>
</div>