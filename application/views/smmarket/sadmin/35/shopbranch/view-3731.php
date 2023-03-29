<h1><?php echo $data->values['name']; ?></h1>
<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs ui-sortable-handle">
                <li <?php if($select == 'supplier'){ echo 'class="active"'; }?>><a href="/sadmin/shopbranch/edit?id=<?php echo $data->values['id']; ?>">Торговая точка</a></li>
                <li <?php if($select == 'manager'){ echo 'class="active"'; }?>><a href="/sadmin/shopoperation/index?shop_branch_id=<?php echo $data->values['id']; ?>">Менеджеры</a></li>
            </ul>
        </div>
    </div>
</div>