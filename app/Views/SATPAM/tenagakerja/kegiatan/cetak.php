<?php
// $no = 1;
// if (isset($dtInspeksi)) {
//     foreach ($dtInspeksi as $row) {

//     }
// }

$html = view('pages/pengawasan/laporan', $dtInspeksi);

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('CoIS');
$pdf->SetTitle('Laporan');
$pdf->SetSubject('Inspeksi Rutin');


$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
$pdf->addPage();
// output the HTML content
$pdf->writeHTML($html);
//line ini penting
//Close and output PDF document
$pdf->Output('laporan.pdf', 'D');
