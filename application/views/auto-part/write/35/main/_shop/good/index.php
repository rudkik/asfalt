<h3>Продукция</h3>
<div class="row">
    <div class="col-md-12">
        <form class="box-find" action="/stock_write/shopgood/index" method="get">
            <div class="input-group">
                <input name="stock_name" class="form-control" placeholder="Штрихкод" value="<?php echo Request_RequestParams::getParamStr('stock_name') ?>">
                <div class="input-group-btn">
                    <button type="submit" class="btn btn-success">Поиск</button>
                </div>
            </div>
            <div class="input-group" style="margin-top: 10px">
                <input name="article" class="form-control" placeholder="Каталожный номер" value="<?php echo Request_RequestParams::getParamStr('article') ?>">
                <div class="input-group-btn">
                    <button type="submit" class="btn btn-success">Поиск</button>
                </div>
            </div>
            <div class="input-group" style="margin-top: 10px">
                <input name="names_articles" class="form-control" placeholder="Название" value="<?php echo Request_RequestParams::getParamStr('names_articles') ?>">
                <div class="input-group-btn">
                    <button type="submit" class="btn btn-success">Поиск</button>
                </div>
            </div>
            <input name="type" value="<?php echo Request_RequestParams::getParamInt('type') ?>" style="display: none">
        </form>
    </div>
</div>
<ul class="products-list product-list-in-box">
	<?php echo trim($data['view::_shop/good/list/index']); ?>
</ul>
