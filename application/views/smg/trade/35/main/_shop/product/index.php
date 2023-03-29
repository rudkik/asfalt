<div class="header header-breakpoint" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" data-qaid="breadcrumbs">
    <div class="container">
        <?php echo trim($data['view::_shop/rubric/list/breadcrumb']); ?>
    </div>
</div>
<div class="header header-rubrics">
    <div class="container">
        <?php echo trim($data['view::_shop/rubric/one/show']); ?>
        <div class="row">
                <?php echo trim($data['view::_shop/rubric/list/index']); ?>
        </div>
    </div>
</div>
<div class="header header-products">
    <div class="container">
        <h2>Товары этой категории</h2>
        <div class="body-table dataTables_wrapper ">
                <?php echo trim($data['view::_shop/product/list/index']); ?>
        </div>
    </div>
</div>
<div class="header header-select-product" >
    <div class="container">
        <h2>Актуальное сейчас в Алматы</h2>
        <div class="row products products-row-two">
            <?php echo trim($data['view::_shop/product/list/popular']); ?>
        </div>
    </div>
</div>