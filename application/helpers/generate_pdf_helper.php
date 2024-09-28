<?php

use Dompdf\Dompdf;

function generate_pdf($html = '', $file_name = 'Laporan_reservasi', $size = 'A4', $orientation = 'potrait', $attachment = false) {
    $dompdf = new Dompdf();
    $dompdf->LoadHtml($html);
    $dompdf->setPaper($size, $orientation);
    $dompdf->render();
    $dompdf->stream($file_name.['Attachment' => $attachment]);
}