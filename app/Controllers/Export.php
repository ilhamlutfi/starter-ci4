<?php

namespace App\Controllers;

use TCPDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Export extends BaseController
{
    protected $db, $builder;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->builder = $this->db->table('peoples');
    }

    public function export_pdf()
    {
        $data = [
            'pdf_peoples' => $this->builder->get()->getResultArray()
        ];

        $html = view('export/pdf', $data);

        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_RIGHT);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

        // Print text using writeHTMLCell()
        $pdf->writeHTML($html);
        $this->response->setContentType('application/pdf');
        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $pdf->Output('peoples.pdf', 'I');
    }

    public function export_excel()
    {
        $peoples = $this->builder->get()->getResultArray();

        $spreadsheet = new Spreadsheet();
        // tulis header/nama kolom 
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Name')
            ->setCellValue('C1', 'Address')
            ->setCellValue('D1', 'Email')
            ->setCellValue('E1', 'Birthdate');

        $column = 2;
        // tulis data mobil ke cell
        $no = 1;
        foreach ($peoples as $data) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $column, $no++)
                ->setCellValue('B' . $column, $data['name'])
                ->setCellValue('C' . $column, $data['address'])
                ->setCellValue('D' . $column, $data['email'])
                ->setCellValue('E' . $column, $data['birthdate']);
            $column++;
        }
        // tulis dalam format .xlsx
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Peoples Data';

        // Redirect hasil generate xlsx ke web client
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
