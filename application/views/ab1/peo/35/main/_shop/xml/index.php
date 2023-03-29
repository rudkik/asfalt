<div class="col-md-12 padding-top-15px">
	<div class="nav-tabs-custom nav-tabs-navy">
        <?php
        $view = View::factory('ab1/peo/35/main/menu');
        $view->siteData = $siteData;
        $view->data = $data;
        echo Helpers_View::viewToStr($view);
        ?>
        <div class="tab-content" style="display: inline-block; width: 100%">
            <h3>Загрузка</h3>
            <div class="col-md-12">
                <form action="<?php echo Func::getFullURL($siteData, '/shopxml/loadproduct'); ?>" method="post" enctype="multipart/form-data" >
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                Начало действия прайс-листа
                            </label>
                        </div>
                        <div class="col-md-3">
                            <input id="date" class="form-control" name="date" type="datetime" date-min="<?php echo date('d.m.Y'); ?>" date-type="date" value="<?php echo date('d.m.Y'); ?>">
                        </div>
                    </div>
                    <div class="row record-input record-list">
                        <div class="col-md-3 record-title">
                            <label>
                                Файл
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="file-upload" data-text="Выберите файл">
                                <input type="file" name="file">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-primary" onclick="loadDeliveries()">Загрузить доставку</button>
                            <button type="submit" class="btn btn-primary" onclick="loadProducts()">Загрузить товары</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
	</div>
</div>
<script>
    function loadDeliveries(){
        $('form').attr('action', '<?php echo Func::getFullURL($siteData, '/shopxml/loaddelivery'); ?>');
    }
    function loadProducts(){
        $('form').attr('action', '<?php echo Func::getFullURL($siteData, '/shopxml/loadproduct'); ?>');
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