<?php if (count($data['view::View_Shop_Good\-products-brendy']->childs) > 0){ ?>
    <div class="box-menu-brand box box-solid collapsed-box">
        <div class="box-header ui-sortable-handle">
            <h3 class="box-title">Brands</h3>
            <div class="box-tools pull-right">
                <button data-widget="collapse" class="btn btn-block btn-danger btn-red"><i class="fa fa-minus"></i></button>
            </div>
            <div class="line-red"></div>
        </div>
        <div class="box-body border-radius-none">
            <ul class="box-menu">
                <?php
                foreach ($data['view::View_Shop_Good\-products-brendy']->childs as $value){
                    echo $value->str;
                }
                ?>
            </ul>
        </div>
    </div>
    <script>
        $('[data-widget="collapse"]').click(function (e) {
            e.preventDefault();

            var i = $(this).find('i');
            var body = $(this).parents('.collapsed-box').find('.box-body');

            if(i.hasClass('fa-minus')){
                i.addClass('fa-plus');
                i.removeClass('fa-minus');
                body.css('display', 'none');
            }else{
                i.addClass('fa-minus');
                i.removeClass('fa-plus');
                body.css('display', 'block');
            }

        })

    </script>
<?php } ?>