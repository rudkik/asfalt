<div class="header header-rubrics">
    <div class="container">
        <div class="row" style="margin-top: 30px">
                <?php echo trim($data['view::_shop/rubric/list/index']); ?>
        </div>
    </div>
</div>
<div class="header header-products">
    <div class="container">
        <h2>Результаты поиска по запросу "<?php echo Request_RequestParams::getParam('name_lexicon');?>"</h2>
        <div class="body-table dataTables_wrapper ">
                <?php echo trim($data['view::_shop/product/list/index']); ?>
        </div>
    </div>
</div>
