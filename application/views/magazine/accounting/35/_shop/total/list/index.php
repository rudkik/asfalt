<table id="table-1" class="table-input table table-hover table-db table-tr-line" data-action="table-select">
    <thead>
    <tr class="">
        <th>Товар</th>
        <th class="text-center width-95">Остаток на начало</th>
        <th class="text-center width-95">Приход</th>
        <th class="text-center" style="width: 107px;">Перемещение поступление</th>
        <th class="text-center width-95">Возврат реализации</th>
        <th class="text-center width-95">Реализация</th>
        <th class="text-center width-95">Возврат поставщику</th>
        <th class="text-center" style="width: 107px;">Перемещение выбытие</th>
        <th class="text-center width-95">Списание выбытие</th>
        <th class="text-center" style="width: 153px;">Корректировки (нормы/сверхнормы)</th>
        <th class="text-center width-95">Остаток на конец</th>
    </tr>
    </thead>
    <tbody id="products">
    <?php
    foreach ($data['view::_shop/total/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>
    </tbody>
</table>
<table id="header-fixed" class="table-input table table-hover table-db table-tr-line" data-action="table-select"></table>
<style>
    .table-input tr > td:nth-child(even){
        background-color: rgba(103, 168, 106, 0.2);
    }
    .table-input tr > th:nth-child(even){
        background-color: rgba(53, 124, 165, 0.8);
        color: #fff;
    }
    .table-input tr > th:nth-child(odd){
        background-color: #357ca5 !important;
        color: #fff;
    }
    body { height: 1000px; }
    #header-fixed {
        position: fixed;
        top: 0px; display:none;
        background-color:white;
    }
</style>
<script>
    var tableOffset = $("#table-1").offset().top;
    var $header = $("#table-1 > thead").clone();
    var $fixedHeader = $("#header-fixed").append($header);

    $(window).bind("scroll", function() {
        var offset = $(this).scrollTop();

        if (offset >= tableOffset && $fixedHeader.is(":hidden")) {
            $fixedHeader.show();
            $fixedHeader.width($("#table-1").width());
        }
        else if (offset < tableOffset) {
            $fixedHeader.hide();
        }
    });
</script>