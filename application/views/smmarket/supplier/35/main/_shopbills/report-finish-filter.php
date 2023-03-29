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
                                <input name="to_create_at" type="text" placeholder=""
                                       class="form-control">
                            </div>
                        </div>
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
                                <input name="to_delivery_at" type="text" placeholder=""
                                       class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-group">
                                <label>Телефон </label>
                                <input name="receiver_phone" type="text" placeholder=""
                                       class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-group">
                                <label>E-mail </label>
                                <input name="sender_email" type="email" placeholder=""
                                       class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-group filtr-btn">
                                <label>
                                    <input type="submit" class="btn btn-primary" value="Поиск">
                                </label>
                            </div>
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
