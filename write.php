<?php
require_once 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$filename = dirname(__FILE__) . "\\example.xlsx";
$spreadsheet = IOFactory::load($filename);

$worksheet = $spreadsheet->getActiveSheet();
$rows = $worksheet->toArray();
echo '<pre>';
print_r($rows);
exit;
foreach ($rows as $rowNum => $rowData) {
  if ($rowNum == 0) {
    continue;
  }
  $worksheet->setCellValueByColumnAndRow(2, $rowNum + 1, $rowData[1] * 2);
}

$writer = new Xlsx($spreadsheet);
$writer->save('output.xlsx');
