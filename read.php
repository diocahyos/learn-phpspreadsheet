<?php
require 'vendor/autoload.php';

// How to read file excel when use getCellByColumnAndRow

//File to be read.
$inputFileName = dirname(__FILE__) . "\\example.xlsx";
// $sheetname = "Destructuring Data For API";

$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
$reader->setReadDataOnly(TRUE);

//Load the excel file to be read.
$spreadsheet = $reader->load($inputFileName);
//Get the sheet by name.
// $sheet = $spreadsheet->getSheetByName($sheetname);

$worksheet = $spreadsheet->getActiveSheet();
$highestRow = $worksheet->getHighestRow();
$highestColumn = $worksheet->getHighestColumn();

// For Header
// Read rows until an empty one is hit.
$columnNameRow = 1;
//The row number where our data starts.
$colsName = array();
$currentCellData = "/";
// The First Cell will be use in column name object array
for ($i = $columnNameRow; $currentCellData != ""; $i++) {
  $currentCellData = $worksheet->getCellByColumnAndRow($i, 1)->getCalculatedValue() == null ? "" : strtolower(str_replace(" ", "_", str_replace(["(", ")"], "", $worksheet->getCellByColumnAndRow($i, 1)->getCalculatedValue())));
  //If data is present add it to the data array. 
  if ($currentCellData != null)
    $colsName[] = $currentCellData;
}

$dataAll = array();
for ($row = 2; $row <= $highestRow; $row++) {
  $dataRow = array();

  $i = 0;
  for ($col = 1; $col <= count($colsName); $col++) {
    // for ($col = 'A'; $col <= $highestColumn; $col++) {
    $dataRow += array($colsName[$i] => $worksheet->getCellByColumnAndRow($col, $row)->getCalculatedValue() == NULL ? NULL : $worksheet->getCellByColumnAndRow($col, $row)->getCalculatedValue());
    // $dataRow += array($colsName[$i] => $worksheet->getCell($col . $row)->getValue());
    $i++;
  }
  $dataAll[] = $dataRow;
}

echo '<pre>';
print_r($dataAll);
