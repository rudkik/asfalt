<?php if(count($data['view::shoppaidtype/shopbill']->childs) > 0){ ?>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Оплата</label>
            <select name="shop_delivery_type_id" class="form-control select2" style="width: 100%;">
                <?php
                foreach ($data['view::shoppaidtype/shopbill']->childs as $value){
                    echo $value->str;
                }
                ?>
            </select>
        </div>
    </div>
</div>
<?php } ?>

