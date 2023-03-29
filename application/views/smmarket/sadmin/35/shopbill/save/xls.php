<Row>
    <Cell ss:StyleID="s22"><Data ss:Type="Number"><?php echo htmlspecialchars($data->id, ENT_XML1); ?></Data></Cell>
    <Cell ss:StyleID="s22"><Data ss:Type="String"><?php echo htmlspecialchars(Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['created_at']), ENT_XML1); ?></Data></Cell>
    <Cell ss:StyleID="s22"><Data ss:Type="String"><?php echo htmlspecialchars(Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['client_delivery_date']), ENT_XML1); ?></Data></Cell>
    <Cell ss:StyleID="s22"><Data ss:Type="String"><?php echo htmlspecialchars(Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_bill_status_id.name', ''), ENT_XML1); ?></Data></Cell>
    <Cell ss:StyleID="s22"><Data ss:Type="String"><?php echo htmlspecialchars(Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_id.name', ''), ENT_XML1);  ?></Data></Cell>
    <Cell ss:StyleID="s22"><Data ss:Type="String"><?php echo htmlspecialchars(Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_root_id.name', ''), ENT_XML1);  ?></Data></Cell>
    <Cell ss:StyleID="s22"><Data ss:Type="Number"><?php echo htmlspecialchars($data->values['amount'], ENT_XML1);  ?></Data></Cell>
    <Cell ss:StyleID="s22"><Data ss:Type="String"><?php echo htmlspecialchars(Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_root_id.options.manager_company_name', ''), ENT_XML1); ?></Data></Cell>
</Row>