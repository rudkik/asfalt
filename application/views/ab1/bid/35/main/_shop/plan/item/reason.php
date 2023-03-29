<div class="col-md-12 padding-top-15px">
    <div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/bid/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content">
            <div class="tab-pane active">
                <?php
                $view = View::factory('ab1/bid/35/main/_shop/plan/item/filter');
                $view->siteData = $siteData;
                $view->data = $data;
                echo Helpers_View::viewToStr($view);
                ?>
            </div>
            <div class="nav-tabs-custom" style="margin-bottom: 0px;">
                <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
                    <li class="active"><a href="<?php echo Func::getFullURL($siteData, '/shopplanitem/reason', array(), array());?>">Все <i class="fa fa-fw fa-info text-blue"></i></a></li>
                    <li class="pull-left header">
                        <a data-action="calc-quantity-fact" href="<?php echo Func::getFullURL($siteData, '/shopplanitem/calc_quantity_fact', array());?>" class="btn bg-purple btn-flat">
                            <i class="fa fa-fw fa-plus"></i>
                            Пересчитать фактическую реализацию
                        </a>
                    </li>
                </ul>
            </div>
            <div class="body-table">
                <div class="box-body table-responsive" style="padding-top: 0px;">
                    <?php echo trim($data['view::_shop/plan/item/list/reason']); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('a[data-action="calc-quantity-fact"]').click(function (e) {
        e.preventDefault();

        var date = $('#date').val();
        var href = $(this).attr('href');
        window.location.href = href + '?date=' + date;

        return false;
    });
</script>
