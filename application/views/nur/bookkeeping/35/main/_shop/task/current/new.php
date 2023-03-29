<div class="page-header">
    <div class="page-header-title">
        <?php
        switch (Request_RequestParams::getParamStr('period')){
            case 'day':
                echo '<h4>Новые задачи на три дня</h4>';
                break;
            case 'week':
                echo '<h4>Новые задачи на одну неделю</h4>';
                break;
            case 'month':
                echo '<h4>Новые задачи на один месяц</h4>';
                break;
        }
        ?>
    </div>
</div>
<div class="page-body">
    <?php echo trim($data['view::_shop/task/current/list/new']); ?>
</div>