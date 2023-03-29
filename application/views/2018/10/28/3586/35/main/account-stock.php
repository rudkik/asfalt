<main>
    <div class="container">
        <div class="row justify-content-center no-gutters">
            <?php echo trim($siteData->globalDatas['view::View_Ads_Shop_Parcels\-account-stock-na-sklade']); ?>
        </div>
    </div>
</main>
<script>
    $('select[data-id="address"]').change(function () {
        var parent = $(this).parents('div[data-id="address_id"]');

        jQuery.ajax({
            url: '/adsgs/save_parcel',
            data: ({
                'id': parent.data('value'),
                'address': $(this).val(),
            }),
            type: "POST",
            success: function (data) {
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    });
</script>