<?php
$time1 = date('d.m.Y');
?>
<div class="col-md-12 padding-top-15px">
    <div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/'.$siteData->actionURLName.'/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content" style="display: inline-block; width: 100%">
            <h3>Печать прайс-листов</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopxml/save_invoices'); ?>" method="post" >
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="date">На дату</label>
                                <input id="date" class="form-control" name="date" type="datetime" date-type="date" value="<?php echo $time1; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-primary" onclick="saveAsphalt()">Асфальтобетон</button>
                            <button type="submit" class="btn btn-primary" onclick="saveConcrete()">Бетон</button>
                            <button type="submit" class="btn btn-primary" onclick="saveBitumen()">Битум</button>
                            <button type="submit" class="btn btn-primary" onclick="saveBitumenBranch()">Битум (филиал)</button>
                            <button type="submit" class="btn btn-primary" onclick="saveZhbiOther()">ЖБИ</button>
                            <button type="submit" class="btn btn-primary" onclick="saveZhbiFloorSlabs()">ЖБИ (плиты перекрытия)</button>
                            <button type="submit" class="btn btn-primary" onclick="saveStoneMaterial()">Каменные материалы</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function saveAsphalt(){
        $('form').attr('action', '<?php echo Func::getFullURL($siteData, '/shopreport/price_list_asphalt', array(), array('shop_product_rubric_id' => 84246)); ?>');
    }
    function saveConcrete(){
        $('form').attr('action', '<?php echo Func::getFullURL($siteData, '/shopreport/price_list_concrete', array(), array('shop_product_rubric_id' => 84606)); ?>');
    }
    function saveBitumen(){
        $('form').attr('action', '<?php echo Func::getFullURL($siteData, '/shopreport/price_list_bitumen', array(), array('shop_product_rubric_id' => 84250)); ?>');
    }
    function saveBitumenBranch(){
        $('form').attr('action', '<?php echo Func::getFullURL($siteData, '/shopreport/price_list_bitumen_branch', array(), array('shop_product_rubric_id' => 84250)); ?>');
    }
    function saveZhbiOther(){
        $('form').attr('action', '<?php echo Func::getFullURL($siteData, '/shopreport/price_list_zhbi_other', array(), array('shop_product_rubric_id' => 84598, 'shop_product_pricelist_rubric_id' => 3)); ?>');
    }
    function saveZhbiFloorSlabs(){
        $('form').attr('action', '<?php echo Func::getFullURL($siteData, '/shopreport/price_list_zhbi_floor_slabs', array(), array('shop_product_rubric_id' => 84598, 'shop_product_pricelist_rubric_id' => 3)); ?>');
    }
    function saveStoneMaterial(){
        $('form').attr('action', '<?php echo Func::getFullURL($siteData, '/shopreport/price_list_stone_material', array(), array('shop_product_rubric_id' => 84605)); ?>');
    }
</script>