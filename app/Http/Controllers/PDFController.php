<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use TCPDF;

class PDFController extends Controller
{
    public function GeneratePDF(Request $request)
    {
        $selectedWorkers = $request->input('checkbox', []);
        $pdf = new TCPDF();
        $pdf->SetTitle('Karty dostępu dla pracowników');
        $pdf->SetSubject('Karty dostępu');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetFont('helvetica', '', 12);
        foreach ($selectedWorkers as $workerId) {
            $workerResults = DB::select('SELECT * FROM workers WHERE id = ?', [$workerId]);
            $worker = !empty($workerResults) ? $workerResults[0] : null;
            $pdf->AddPage();
            $pdf->SetFont('helvetica', 'B', 16);
            $pdf->Cell(0, 10, $worker->firstName . ' ' . $worker->lastName, 0, 1, 'C');
            $pdf->SetFont('helvetica', '', 12);
            $pdf->Cell(0, 10, $worker->departament, 0, 1, 'C');
            $authLevel = $worker->authDegree;
            $qrData = $worker->firstName . $worker->lastName . $authLevel;
            $style = [
                'border' => 2,
                'vpadding' => 'auto',
                'hpadding' => 'auto',
                'fgcolor' => [0,0,0],
                'bgcolor' => false,
                'module_width' => 1,    //szerokość kodu QR
                'module_height' => 1    //wysokość kodu QR
            ];
            $pdf->write2DBarcode($qrData, 'QRCODE,H', 80, 50, 50, 50, $style, 'N');
            $pdf->Ln();
        }
        $pdf->Output('karty_dostepu.pdf', 'I');
    }
}
