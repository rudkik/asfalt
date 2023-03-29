<form action="/market/shopproduct/set_child_product" class="box-body no-padding padding-bottom-10px">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="article1">Артикул 1</label>
                        <input id="article1" class="form-control" name="article1" placeholder="Артикул 1" type="text" value="<?php echo htmlspecialchars(Request_RequestParams::getParamStr('article1'), ENT_QUOTES); ?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="article2">Артикул 2</label>
                        <input id="article2" class="form-control" name="article2" placeholder="Артикул 2" type="text" value="<?php echo htmlspecialchars(Request_RequestParams::getParamStr('article2'), ENT_QUOTES); ?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group" style="padding-top: 23px">
                        <button type="submit" class="btn bg-orange btn-flat">Соединить</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>