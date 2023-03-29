<?php
$time1 = date('d.m.Y',strtotime('-1 day')).' 06:00';
$time2 = date('d.m.Y').' 06:00';
?>
<div class="col-md-12 padding-top-15px">
	<div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/cash/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content" style="display: inline-block; width: 100%">
            <h3 style="margin-top: 50px">Выгрузка</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopxml/save_invoices'); ?>" method="get" >
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="date">Период от</label>
                                <input id="date" class="form-control" name="date" type="datetime" date-type="datetime" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-primary" onclick="saveInvoices()">Выгрузить накладные</button>
                            <button type="submit" class="btn btn-primary" onclick="saveActServices()">Выгрузить акты выполненых работ</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
	</div>
</div>
<script>
    function saveInvoices(){
        $('form').attr('action', '<?php echo Func::getFullURL($siteData, '/shopxml/save_invoices'); ?>');
    }
    function saveActServices(){
        $('form').attr('action', '<?php echo Func::getFullURL($siteData, '/shopxml/save_act_services'); ?>');
    }
</script>