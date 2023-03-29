<?php
$time1 = Helpers_DateTime::getDateFormatRus($siteData->replaceDatas['view::date']);
?>
<div class="col-md-12 padding-top-15px">
	<div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/sales/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content" style="display: inline-block; width: 100%">
            <h3>Выгрузка</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopxml/save_invoices'); ?>" method="get" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="date_from">Период от</label>
                                <input id="date_from" class="form-control" name="date_from" type="datetime" date-type="date">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="date_to">Период до</label>
                                <input id="date_to" class="form-control" name="date_to" type="datetime" date-type="date">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-primary" onclick="saveAll()">Выгрузить все</button>
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
    function saveAll(){
        $('form').attr('action', '<?php echo Func::getFullURL($siteData, '/shopxml/save_all'); ?>');
    }
    function saveInvoices(){
        $('form').attr('action', '<?php echo Func::getFullURL($siteData, '/shopxml/save_invoices'); ?>');
    }
    function saveActServices(){
        $('form').attr('action', '<?php echo Func::getFullURL($siteData, '/shopxml/save_act_services'); ?>');
    }
</script>