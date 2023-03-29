<?php
foreach ($data['view::_shop/plan/one/statistics']->childs as $value) {
    echo $value->str;
}
?>
<script>
    $('[data-action="show-tr"]').click(function () {
        if($(this).data('show') == 1){
            $('[data-child-id="'+$(this).data('id')+'"]').css('display', 'none');
            $(this).data('show', 0);
        }else{
            $('[data-child-id="'+$(this).data('id')+'"]').css('display', '');
            $(this).data('show', 1);
        }
    });
</script>
<style>
    .rotate-270{
        height: 153px;
    }
    .rotate-270 > *{
        -webkit-transform: rotate(270deg);
        -moz-transform: rotate(270deg);
        -ms-transform: rotate(270deg);
        -o-transform: rotate(270deg);
        transform: rotate(270deg);
        display: inline-block;
        max-width: 130px;
    }
</style>
