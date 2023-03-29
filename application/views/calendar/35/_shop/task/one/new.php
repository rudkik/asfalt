<div class="inline-block">
    <h3 class="pull-left">Задача <small style="margin-right: 10px;">добавление</small></h3>
    <button type="button" class="btn bg-orange btn-flat pull-right" onclick="submitTask('shoptask');">Сохранить</button>
</div>
<form id="shoptask" action="<?php echo Func::getFullURL($siteData, '/shoptask/save'); ?>" method="post" style="padding-right: 5px;">
    <div class="row">
        <div class="col-lg-9">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date_from">Date start</label>
                                <input type="datetime" date-type="date" class="form-control" id="date_from" name="date_from" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date_to">Date end</label>
                                <input type="datetime" date-type="date" class="form-control" id="date_to" name="date_to" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cost">Cost USD</label>
                                <input type="text" class="form-control" id="cost" name="cost" placeholder="Cost USD">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="span-checkbox" style="margin-top: 32px;">
                                    <input name="is_calendar_outer" value="0" type="checkbox" data-id="1" class="minimal">
                                    Помещать в календарь
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="shop_product_name">Product</label>
                                <div class="box-typeahead">
                                    <input type="text" class="form-control" id="shop_product_name" name="shop_product_name" placeholder="Product" data-action="find-typeahead" data-url="/calendar/shopproduct/json?name=%QUERY&sort_by[name]=asc&limit=25&_fields[]=name">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="shop_rubric_name">Category</label>
                                <div class="box-typeahead">
                                    <input type="text" class="form-control" id="shop_rubric_name" name="shop_rubric_name" placeholder="Category" data-action="find-typeahead" data-url="/calendar/shoprubric/json?name=%QUERY&sort_by[name]=asc&limit=25&_fields[]=name">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="shop_partner_name">Partner</label>
                                <div class="box-typeahead">
                                    <input type="text" class="form-control" id="shop_partner_name" name="shop_partner_name" placeholder="Partner" data-action="find-typeahead" data-url="/calendar/shoppartner/json?name=%QUERY&sort_by[name]=asc&limit=25&_fields[]=name">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Project</label>
                                <div class="box-typeahead">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Project" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="text">Description</label>
                        <textarea name="text" class="form-control" rows="3" placeholder="Description"></textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="shop_result_name">Result</label>
                                <div class="box-typeahead">
                                    <input type="text" class="form-control" id="shop_result_name" name="shop_result_name" placeholder="Result" data-action="find-typeahead" data-url="/calendar/shopresult/json?name=%QUERY&sort_by[name]=asc&limit=25&_fields[]=name">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mbc">MBC</label>
                                <input type="mbc" class="form-control" id="mbc" name="mbc" placeholder="MBC">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div hidden>
                    <input id="is_close" name="is_close" value="1">
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <h3 class="pull-left">Список файлов</h3>
            <?php
            $view = View::factory('calendar/35/file');
            $view->siteData = $siteData;
            $view->files = array();
            echo Helpers_View::viewToStr($view);
            ?>
        </div>
    </div>
</form>


<div class="inline-block">
    <button type="button" class="btn bg-orange btn-flat pull-right" onclick="submitTask('shoptask');">Сохранить</button>
</div>
<script>
    function submitTask(id) {
        var isError = false;
        if(!isError) {
            $('#'+id).submit();
        }
    }

</script>