<div id="modal-yandex-map" class="modal fade">
    <div class="modal-dialog" style="width: 1200px;">
        <div method="post" class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                <h4 class="modal-title">Яндекс карта</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <a style="font-size: 18px" class="text-blue" target="_blank" href="https://yandex.kz/maps/162/almaty/?rtext=<?php echo trim($data['view::yandex_map']); ?>&rtt=auto&z=12">Ссылка на карту</a>
                </div>
                <h4 class="text-green" style="margin: 0px;">Адреса</h4>
                <?php echo trim($data['view::_shop/bill/item/list/yandex-map']); ?>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default pull-left">Закрыть</button>
            </div>
        </div>
    </div>
</div>