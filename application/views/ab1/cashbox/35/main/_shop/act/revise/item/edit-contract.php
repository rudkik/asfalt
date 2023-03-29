<?php $siteData->siteTitle = 'Акт сверок из 1С'; ?>
<div class="col-md-12 padding-top-15px">
	<div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/cashbox/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
            <div class="tab-pane active">
                <?php $siteData->titleTop = 'Приходники из 1С (присваиваем номер договора)'; ?>
                <?php
                $view = View::factory('ab1/cashbox/35/main/_shop/act/revise/item/filter/edit-contract');
                $view->siteData = $siteData;
                $view->data = $data;
                echo Helpers_View::viewToStr($view);
                ?>
            </div>
            <div class="body-table">
                <div class="box-body table-responsive" style="padding-top: 0px;">
                    <form action="<?php echo Func::getFullURL($siteData, '/shopactreviseitem/save_contracts'); ?>" method="post" style="padding-right: 5px;">
                        <?php echo trim($data['view::_shop/act/revise/item/list/edit-contract']); ?>
                    </form>
                </div>
            </div>
        </div>
	</div>
</div>
