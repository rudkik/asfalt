<div id="dialog-edit-tare" class="modal">
    <div class="modal-dialog" style="max-width: 600px; width: 100%">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #0097bc;color: #fff;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Изменить тару машину</h4>
            </div>
            <div class="modal-body">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Номер машины</label>
                                <input class="form-control text-number" name="name" data-type="auto-number" placeholder="Номер машины" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Брутто</label>
                                <input class="form-control" name="brutto" placeholder="Брутто" type="text" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Тара</label>
                                <input class="form-control" name="tarra" placeholder="Тара" type="text" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Нетто</label>
                                <input class="form-control text-number" name="netto" placeholder="Нетто" type="text" readonly>
                            </div>
                        </div>
                    </div>
                    <input name="id" style="display: none">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary pull-right" onclick="sendTare()">Зафиксировать</button>
            </div>
        </div>
    </div>
</div>