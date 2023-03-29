<Row>
    <Cell ss:StyleID="s22"><Data ss:Type="String"><?php echo htmlspecialchars($data->values['name'], ENT_XML1); ?></Data></Cell>
    <Cell ss:StyleID="s22"><Data ss:Type="String"><?php echo htmlspecialchars(Helpers_DateTime::getDateTimeRusWithoutSeconds(Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_bill_id.created_at', '')), ENT_XML1); ?></Data></Cell>
    <Cell ss:StyleID="s22"><Data ss:Type="Number"><?php echo htmlspecialchars(Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_bill_id.amount', ''), ENT_XML1); ?></Data></Cell>
    <Cell ss:StyleID="s22"><Data ss:Type="Number"><?php echo htmlspecialchars(Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_bill_id.id', ''), ENT_XML1); ?></Data></Cell>
</Row>