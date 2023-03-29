<div class="form-group row">
    <label for="is_invoice_proforma" class="col-3 col-form-label">Привязать к счету на оплату №<?php echo $data->values['number']; ?>?</label>
    <div class="col-9 col-form-label" style="text-align: left;">
        <input name="is_invoice_proforma" value="0" style="display: none">
        <label class="ks-checkbox-slider ks-on-off ks-primary" style="margin-top: 10px">
            <input name="is_invoice_proforma" type="checkbox" value="1" checked>
            <span class="ks-indicator"></span>
            <span class="ks-on">да</span>
            <span class="ks-off">нет</span>
        </label>
    </div>
    <input name="shop_invoice_proforma_id" value="<?php echo $data->id; ?>" style="display: none">
</div>