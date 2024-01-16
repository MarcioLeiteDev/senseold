<?php

require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Hello World !');
$sheet->setCellValue('B1', 'Outra Celula');
$sheet->setCellValue('C1', 'Outra Celula');
$sheet->setCellValue('D1', 'Outra Celula');

$writer = new Xlsx($spreadsheet);
$writer->save('teste.xlsx');

echo "Ola mundo";

