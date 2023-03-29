<div class="col-md-12 padding-top-15px">
	<div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('magazine/bar/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content" style="display: inline-block; width: 100%">
            <h3>Загрузка</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopxml/loadproduct'); ?>" method="post" enctype="multipart/form-data">
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                Файл
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="file-upload" data-text="Выберите файл">
                                <input type="file" name="file[]" multiple>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-primary" onclick="loadESFProducts()" style="display: none">Загрузить продукты из ЭСФ</button>
                            <button type="submit" class="btn btn-primary" onclick="loadTalons()">Загрузить талоны</button>
                        </div>
                    </div>
                </form>
            </div>
            <h3 style="margin-top: 50px">Выгрузка</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopxml/loadproduct'); ?>" method="get" >
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Период от</label>
                                <input id="input-name" class="form-control" name="created_at_from" type="datetime" date-type="datetime" value="<?php //echo $time1; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Период до</label>
                                <input id="input-name" class="form-control" name="created_at_to" type="datetime" date-type="datetime" value="<?php //echo $time2; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-primary" onclick="saveAll()">Выгрузить всё</button>
                            <button type="submit" class="btn btn-primary" onclick="saveReceives()">Выгрузить приход</button>
                            <button type="submit" class="btn btn-primary" onclick="saveRealizations()">Выгрузить реализацию</button>
                            <button type="submit" class="btn btn-primary" onclick="saveWriteOffs()">Выгрузить списание</button>
                            <button type="submit" class="btn btn-primary" onclick="saveReturns()">Выгрузить возврат</button>
                            <button type="submit" class="btn btn-primary" onclick="saveMoveOuts()">Выгрузить перемещение в столовую</button>
                            <button type="submit" class="btn btn-primary" onclick="saveMoveIns()">Выгрузить перемещение в магазин</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
	</div>
</div>
<script>
    function loadESFProducts(){
        $('form').attr('action', '<?php echo Func::getFullURL($siteData, '/shopxml/load_esf_products'); ?>');
    }
    function loadTalons(){
        $('form').attr('action', '<?php echo Func::getFullURL($siteData, '/shopxml/load_talons'); ?>');
    }

    function saveReceives(){
        $('form').attr('action', '<?php echo Func::getFullURL($siteData, '/shopxml/save_receives'); ?>');
    }
    function saveRealizations(){
        $('form').attr('action', '<?php echo Func::getFullURL($siteData, '/shopxml/save_realizations'); ?>');
    }
    function saveWriteOffs(){
        $('form').attr('action', '<?php echo Func::getFullURL($siteData, '/shopxml/save_write_offs'); ?>');
    }
    function saveReturns(){
        $('form').attr('action', '<?php echo Func::getFullURL($siteData, '/shopxml/save_returns'); ?>');
    }
    function saveMoveOuts(){
        $('form').attr('action', '<?php echo Func::getFullURL($siteData, '/shopxml/save_move_outs'); ?>');
    }
    function saveMoveIns(){
        $('form').attr('action', '<?php echo Func::getFullURL($siteData, '/shopxml/save_move_ins'); ?>');
    }
    function saveAll(){
        $('form').attr('action', '<?php echo Func::getFullURL($siteData, '/shopxml/save_all'); ?>');
    }

    // выбираем новый файл
    $('input[type="file"]').change(function () {
        s = '';
        for(i = 0; i < this.files.length; i++){
            s = s + this.files[i].name + '; '
        }
        s = s.substr(0, s.length - 2);
        p = $(this).parent().attr('data-text', s);
    });
</script>