<Row>
    <Cell ss:StyleID="s22"><Data ss:Type="String"><?php echo htmlspecialchars($data->values['name'], ENT_XML1); ?></Data></Cell>
    <Cell ss:StyleID="s22"><Data ss:Type="String"><?php echo htmlspecialchars(Arr::path($data->values['options'], 'manager_number_plane_table', ''), ENT_XML1); ?></Data></Cell>
    <Cell ss:StyleID="s22"><Data ss:Type="String"><?php echo htmlspecialchars(Arr::path($data->values['options'], 'manager_date_plane_table', ''), ENT_XML1); ?></Data></Cell>
    <Cell ss:StyleID="s22"><Data ss:Type="String"><?php echo htmlspecialchars(Arr::path($data->values['options'], 'manager_company_name', ''), ENT_XML1); ?></Data></Cell>
</Row>