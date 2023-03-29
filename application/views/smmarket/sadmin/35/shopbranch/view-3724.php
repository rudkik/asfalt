<h1><?php echo $data->values['name']; ?></h1>
<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs ui-sortable-handle">
                <li <?php if($select == 'supplier'){ echo 'class="active"'; }?>><a href="/sadmin/shopbranch/edit?id=<?php echo $data->values['id']; ?>">Поставщик</a></li>
                <li <?php if($select == 'goods'){ echo 'class="active"'; }?>><a href="/sadmin/shopgood/index?type=3722&shop_branch_id=<?php echo $data->values['id']; ?>">Товары</a></li>
                <li <?php if($select == 'discount'){ echo 'class="active"'; }?>><a href="/sadmin/shopdiscount/index?shop_branch_id=<?php echo $data->values['id']; ?>">Скидки</a></li>
                <li <?php if($select == 'manager'){ echo 'class="active"'; }?>><a href="/sadmin/shopoperation/index?shop_branch_id=<?php echo $data->values['id']; ?>">Менеджеры</a></li>
            </ul>
        </div>
    </div>
</div>