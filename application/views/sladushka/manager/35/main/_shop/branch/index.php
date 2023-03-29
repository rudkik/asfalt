<div class="row">
    <div class="col-md-12">
        <h3 class="pull-left">Торговые точки</h3>
        <a href="<?php echo Func::getFullURL($siteData, '/shopbranch/new', array('type'=>'type')); ?>" data-action="cart-add" class="btn btn-info btn-flat pull-right">Добавить</a>
    </div>
    <div class="col-md-12">
        <form class="box-find" action="/manager/shopbranch/index" method="get">
            <div class="input-group">
                <input name="name" class="form-control" placeholder="Название">
                <div class="input-group-btn">
                    <input name="type" value="51658" style="display: none">
                    <button type="submit" class="btn btn-success">Поиск</button>
                </div>
            </div>
        </form>
    </div>
</div>
<ul class="products-list product-list-in-box">
    <?php echo trim($data['view::_shop/branch/list/index']); ?>
</ul>
