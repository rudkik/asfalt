<div class="col-md-12 padding-top-15px">
    <div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/admin/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
            <div class="tab-pane active">
                <h3>Категория договора <small style="margin-right: 10px;">редактирование</small></h3>
                <form action="<?php echo Func::getFullURL($siteData, '/clientcontracttype/save_pdf'); ?>" method="post" style="padding-right: 5px;">
                    <?php echo trim($data['view::client-contract/type/one/template/pdf']); ?>
                </form>
            </div>
        </div>
    </div>
</div>