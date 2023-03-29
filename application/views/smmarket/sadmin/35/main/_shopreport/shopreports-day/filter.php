<section class="content hidden-panel">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Дата создания заказа</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-group">
                                <label>&nbsp; </label>
                                <input type="text" name="name" placeholder=""
                                       class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12"></div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Дата доставки заказа</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-group">
                                <label>&nbsp; </label>
                                <input type="text" placeholder="" name="name"
                                       class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-group filtr-btn">
                                <label>&nbsp;</label>
                                <input type="submit" class="btn btn-primary" value="Поиск"
                                       onclick="actionTableFind('<?php echo $siteData->urlBasic . $siteData->url ?>?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?>', 'find_panel', 'table_panel')">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <input type="checkbox" class="flat-red" checked> Группировать по датам
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="row">
                    </div>
                </div>
                <div class="box-header with-border">
                    <!-- <div class="box-tools pull-right">
                      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div> -->
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-angle-up"></i></button>
                </div>
            </div>
        </div>
    </div>
    <!--    Date range picker-->
    <script>
        $('#reservation').datepicker({
            language: 'ru',
            format: "dd MM yyyy"
        });
        $('#reservation2').datepicker({
            language: 'ru',
            format: "dd MM yyyy"
        });

        $.widget.bridge('uibutton', $.ui.button);
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
            radioClass: 'iradio_flat-blue'
        });
    </script>
</section>
