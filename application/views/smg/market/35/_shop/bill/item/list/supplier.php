<div class="modal-body">
    <?php
    $data = $data['view::_shop/bill/item/one/supplier'];
    $i = 1;
    foreach ($data->childs as $value) {
        echo str_replace('#index#', $i++, $value->str);
    }
    ?>
</div>
<div class="modal-footer">
    <button type="button" data-dismiss="modal" class="btn btn-default pull-left">Закрыть</button>
    <a href="#" class="btn btn-primary">Запрос поставщикам</a>
</div>