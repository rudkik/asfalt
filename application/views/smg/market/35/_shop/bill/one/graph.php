<div class="body-table dataTables_wrapper">
    <div class="box-body border-radius-none">
        <canvas id="chart"></canvas>
    </div>
</div>
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/chart/dist/chart.min.js"></script>

<?php
$days = [];
$dataAll = [];
foreach ($data->additionDatas['all']->childs as $child) {
    $child->values['approve_source_at_date'] = Helpers_DateTime::getDateFormatRus($child->values['approve_source_at_date']);
    $days[] = $child->values['approve_source_at_date'];

    $dataAll[$child->values['approve_source_at_date']] = $child->values['count'];
}

$dataCompleted = [];
foreach ($data->additionDatas['completed']->childs as $child) {
    $child->values['approve_source_at_date'] = Helpers_DateTime::getDateFormatRus($child->values['approve_source_at_date']);
    $dataCompleted[$child->values['approve_source_at_date']] = $child->values['count'];
}

$dataReturn = [];
foreach ($data->additionDatas['return']->childs as $child) {
    $child->values['approve_source_at_date'] = Helpers_DateTime::getDateFormatRus($child->values['approve_source_at_date']);
    $dataReturn[$child->values['approve_source_at_date']] = $child->values['count'];
}

$dataCancel = [];
foreach ($data->additionDatas['cancel']->childs as $child) {
    $child->values['approve_source_at_date'] = Helpers_DateTime::getDateFormatRus($child->values['approve_source_at_date']);
    $dataCancel[$child->values['approve_source_at_date']] = $child->values['count'];
}
?>
<script>
    var ctx = document.getElementById('chart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($days); ?>,
            datasets: [
                {
                    label: 'Общее кол-во',
                    backgroundColor: '#4bc0c0',
                    borderColor: '#4bc0c0',
                    data: <?php echo json_encode($dataAll); ?>
                },
                {
                    label: 'Кол-во отмен',
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: <?php echo json_encode($dataCancel); ?>
                },
                {
                    label: 'Кол-во выданых',
                    backgroundColor: '#36a2eb',
                    borderColor: '#36a2eb',
                    data: <?php echo json_encode($dataCompleted); ?>
                },
                {
                    label: 'Кол-во возвратов',
                    backgroundColor: '#ff9f40',
                    borderColor: '#ff9f40',
                    data: <?php echo json_encode($dataReturn); ?>
                },
            ]
        },
        options: {}
    });
</script>