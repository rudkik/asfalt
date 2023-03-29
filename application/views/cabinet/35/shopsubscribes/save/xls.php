<?xml version="1.0"?>
<?mso-application progid="Excel.Sheet"?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
          xmlns:o="urn:schemas-microsoft-com:office:office"
          xmlns:x="urn:schemas-microsoft-com:office:excel"
          xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
          xmlns:html="http://www.w3.org/TR/REC-html40">
    <DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">
        <Created>2016-11-20T13:59:47Z</Created>
        <Version>11.9999</Version>
    </DocumentProperties>
    <Styles>
        <Style ss:ID="Default" ss:Name="Normal">
            <Alignment ss:Vertical="Bottom"/>
            <Borders/>
            <Font ss:FontName="Arial Cyr" x:CharSet="204"/>
            <Interior/>
            <NumberFormat/>
            <Protection/>
        </Style>
        <Style ss:ID="s22">
            <Borders>
            <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
            </Borders>
              <Font ss:FontName="Arial Cyr" x:CharSet="204" ss:Bold="1"/>
        </Style>
        <Style ss:ID="s23">
            <Borders>
            <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
            </Borders>
        </Style>
    </Styles>
    <Worksheet ss:Name="Лист1">
        <Table ss:ExpandedColumnCount="3" ss:ExpandedRowCount="<?php echo count($data['view::shopsubscribe/save/xls']->childs) + 1; ?>" x:FullColumns="1"
               x:FullRows="1">
            <Column ss:AutoFitWidth="0" ss:Width="43.5"/>
            <Column ss:AutoFitWidth="0" ss:Width="128.25"/>
            <Column ss:AutoFitWidth="0" ss:Width="153.75"/>
            <Row>
                <Cell ss:StyleID="s22"><Data ss:Type="String">ID</Data></Cell>
                <Cell ss:StyleID="s22"><Data ss:Type="String">E-mail</Data></Cell>
                <Cell ss:StyleID="s22"><Data ss:Type="String">Примечание</Data></Cell>
            </Row>
            <?php
            foreach ($data['view::shopsubscribe/save/xls']->childs as $value) {
                echo $value->str."\r\n";
            }
            ?>
        </Table>
    </Worksheet>
</Workbook>