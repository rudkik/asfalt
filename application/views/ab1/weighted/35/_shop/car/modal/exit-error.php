<div id="dialog-exit-error" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #c23321;color: #fff;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Ошибка, вес машины не получилось определить</h4>
            </div>
            <form action="<?php echo Func::getFullURL($siteData, '/shopcar/save'); ?>" method="post" >
                <div class="modal-body">
                    <h5>Убедитесь, что весы исправно работают.</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                </div>
            </form>
        </div>
    </div>
</div>