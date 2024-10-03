<?php

require_once 'vendor/autoload.php';
use Dompdf\Dompdf;

function generate_pdf($html = '', $file_name = 'Laporan Reservasi', $size = 'A4', $orientation = 'Potrait', $attachment = false) {
    $dompdf = new Dompdf;
    $dompdf->LoadHtml($html);
    $dompdf->setPaper($size, $orientation);
    $dompdf->render();
    $dompdf->stream($file_name, ['Attachment' => $attachment]);
}