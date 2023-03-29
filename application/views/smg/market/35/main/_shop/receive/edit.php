<?php $siteData->titleTop = 'Закуп товаров (редактирование)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopreceive/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/receive/one/edit']); ?>
</form>
<script>
    /**
     * Элемент который нужно перемещать
     * @param elements
     */
    function iniDraggableESFProducts(elements) {
        elements.each(function () {
            var eventObject = {
                title: $.trim($(this).text())
            };
            $(this).data('eventObject', eventObject);
            $(this).css('cursor', 'pointer');
            $(this).draggable({
                zIndex: 1070,
                revert: true,
                revertDuration: 0,
                top: -90,
            });

        });
    }

    function setBillItem(from, to){
        var toElementID = $(to).find('[data-id="shop-bill-item-id"] span');

        var fromID = $.trim($(from).data('id'));
        var toID = $.trim(toElementID.text());

        if(fromID == toID) {
            return;
        }

        if(toID != '' &&  $(to).data('quantity') == $(from).data('quantity')) {
            $('[data-action="receive-move"][data-id="' + toID + '"]').prependTo($('#receive-new'));
        }

        toElementID.text(fromID);
        $(from).prependTo($('#receive-edit'));

        jQuery.ajax({
            url: '<?php echo Func::getFullURL($siteData, '/shopreceive/set_bill_item'); ?>',
            data: ({
                'shop_receive_item_id': ($(to).data('id')),
                'shop_bill_item_id': (fromID),
            }),
            type: "POST",
            success: function (data) {
            },
            error: function (data) {
            }
        });
    }

    /**
     * Элемент куда нужно перемещать
     * @param elements
     */
    function iniDroppableProducts(elements) {
        elements.each(function () {
            $(this).droppable({
                drop: function( event, ui ) {
                    var from = ui.draggable;
                    var to = this;

                    setBillItem(from, to);
                }
            });

        });
    }

    $('[data-action="set-drop"] [data-id="shop-bill-item-id"]').click(function (){
        $('#receive-edit [data-id="shop-bill-item"]').removeClass('bg-blue');
        $('[data-action="set-drop"] [data-id="shop-bill-item-id"]').removeClass('bg-blue');

        $(this).addClass('bg-blue');

        var id = $.trim($(this).text());

        $('#receive-edit [data-id="shop-bill-item"]').each(function (){
            if($.trim($(this).text()) == id){
                $(this).addClass('bg-blue');
                return;
            }
        });
    }).css('cursor', 'pointer');

    $('[data-action="del-bill-item"]').click(function (e){
        e.preventDefault();

        var element = $(this).closest('td').find('span');
        var id = $.trim(element.text());
        jQuery.ajax({
            url: $(this).attr('href'),
            data: ({}),
            type: "POST",
            success: function (data) {
                $('[data-action="receive-move"][data-id="' + id + '"]').prependTo($('#receive-new'));
                element.text('');
            },
            error: function (data) {
            }
        });
    });

    iniDraggableESFProducts($('[data-action="receive-move"]'));
    iniDroppableProducts($('[data-action="set-drop"]'));

    var selectReceiveItem = null;

    $('[data-action="select-receive-item"]').click(function (e){
        e.preventDefault();

        $('#receive-items td').removeClass('select-item');
        $(this).closest('td').addClass('select-item');

        selectReceiveItem = $(this).closest('tr');
    });

    $('[data-action="select-bill-item"]').click(function (e){
        e.preventDefault();
        setBillItem($(this).closest('tr'), selectReceiveItem);

        $('html, body').animate({
            scrollTop: selectReceiveItem.offset().top
        }, 0);
    });
</script>
<style>
    .ui-draggable.ui-draggable-handle {
        border-bottom: 2px solid #ddd !important;
    }
    .select-item{
        font-weight: bold;
    }
</style>