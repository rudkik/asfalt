<h3>Ревизии</h3>
<div class="row">
    <div class="col-md-12">
        <form class="box-find" action="/stock_write/shoptablerevision/index" method="get">
            <div class="input-group">
                <input name="name" class="form-control" placeholder="Название">
                <div class="input-group-btn">
                    <input name="type" value="<?php echo Request_RequestParams::getParamInt('type') ?>" style="display: none">
                    <input name="goods-type" value="<?php echo Request_RequestParams::getParamInt('goods-type') ?>" style="display: none">
                    <button type="submit" class="btn btn-success">Поиск</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-12">
        <a href="/stock_write/shoptablerevision/new?type=<?php echo Request_RequestParams::getParamInt('type') ?>&goods-type=<?php echo Request_RequestParams::getParamInt('goods-type') ?>" class="btn btn-info">Новая ревизия</a>
    </div>
</div>
<ul class="products-list product-list-in-box">
	<?php echo trim($data['view::_shop/_table/revision/list/index']); ?>
</ul>
