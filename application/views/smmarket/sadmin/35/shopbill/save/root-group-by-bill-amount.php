<Row>
    <Cell ss:StyleID="s22"><Data ss:Type="String"><?php echo htmlspecialchars(Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_root_id.name', ''), ENT_XML1);  ?></Data></Cell>
    <Cell ss:StyleID="s22"><Data ss:Type="Number"><?php echo htmlspecialchars($data->values['amount'], ENT_XML1);  ?></Data></Cell>
</Row>