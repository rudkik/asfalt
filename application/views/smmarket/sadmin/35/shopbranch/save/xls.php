<Row>
    <Cell ss:StyleID="s22"><Data ss:Type="String"><?php echo htmlspecialchars($data->values['name'], ENT_XML1); ?></Data></Cell>
    <Cell ss:StyleID="s22"><Data ss:Type="String"><?php echo htmlspecialchars(Arr::path($data->values['options'], 'legal_name', ''), ENT_XML1); ?></Data></Cell>
    <Cell ss:StyleID="s22"><Data ss:Type="String"><?php echo htmlspecialchars(Arr::path($data->values['options'], 'site_email', ''), ENT_XML1); ?></Data></Cell>
    <Cell ss:StyleID="s22"><Data ss:Type="String"><?php
             $phones = Arr::path($data->values['options'], 'site_phones', array());
             if(is_array($phones)){
                 $s = '';
                 foreach($phones as $phone){
                     $tmp = Arr::path($phone, 'phone', '');
                     if(! empty($tmp)) {
                         $s = $s . $tmp . ', ';
                     }
                 }
                 $s = substr($s, 0, strlen($s) - 2);
             }else{
                 $s = '';
             }
             echo htmlspecialchars($s, ENT_XML1);
            ?></Data></Cell>
    <Cell ss:StyleID="s22"><Data ss:Type="String"><?php echo htmlspecialchars(Arr::path($data->values['options'], 'site_address', ''), ENT_XML1);  ?></Data></Cell>
    <Cell ss:StyleID="s22"><Data ss:Type="String"><?php echo htmlspecialchars(Arr::path($data->values['options'], 'manager_company_name', ''), ENT_XML1); ?></Data></Cell>
</Row>