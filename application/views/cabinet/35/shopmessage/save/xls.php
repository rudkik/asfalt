<Row>
    <Cell ss:StyleID="s23"><Data ss:Type="Number"><?php echo $data->id; ?></Data></Cell>
    <Cell ss:StyleID="s23"><Data ss:Type="String"><?php echo htmlspecialchars($data->values['email'], ENT_XML1); ?></Data></Cell>
    <Cell ss:StyleID="s23"><Data ss:Type="String"><?php echo htmlspecialchars($data->values['text'], ENT_XML1); ?></Data></Cell>
</Row>