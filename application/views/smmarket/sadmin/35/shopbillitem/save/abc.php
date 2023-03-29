<Row>
    <Cell ss:StyleID="s63"><Data ss:Type="String"><?php echo htmlspecialchars(Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_id.name', ''), ENT_XML1);  ?></Data></Cell>
    <Cell ss:StyleID="s63"><Data ss:Type="String"><?php echo htmlspecialchars(Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_good_id.name', ''), ENT_XML1);  ?></Data></Cell>
    <Cell ss:StyleID="s63"><Data ss:Type="Number"><?php echo htmlspecialchars($data->values['amount'], ENT_XML1);  ?></Data></Cell>
    <Cell ss:StyleID="s63"><Data ss:Type="Number"><?php echo htmlspecialchars($data->additionDatas['percent_amount'], ENT_XML1); ?></Data></Cell>
    <Cell ss:StyleID="s63"><Data ss:Type="String"><?php echo htmlspecialchars($data->additionDatas['category_amount'], ENT_XML1); ?></Data></Cell>
    <Cell ss:StyleID="s63"><Data ss:Type="Number"><?php echo htmlspecialchars($data->values['count'], ENT_XML1);  ?></Data></Cell>
    <Cell ss:StyleID="s63"><Data ss:Type="Number"><?php echo htmlspecialchars($data->additionDatas['percent_count'], ENT_XML1); ?></Data></Cell>
    <Cell ss:StyleID="s63"><Data ss:Type="String"><?php echo htmlspecialchars($data->additionDatas['category_count'], ENT_XML1); ?></Data></Cell>
</Row>