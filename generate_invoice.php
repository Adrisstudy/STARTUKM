<?php
require('fpdf/fpdf.php');
include 'db.php';

$bookingRef = $_GET['ref'];
$stmt = $conn->prepare("
    SELECT tb.*, k.nama_kolej 
    FROM tempahan_bilik tb 
    JOIN kolej k ON tb.id_kolej = k.id_kolej 
    WHERE tb.booking_ref = ?
");
$stmt->bind_param("s", $bookingRef);
$stmt->execute();
$booking = $stmt->get_result()->fetch_assoc();

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 20);
        $this->Cell(0, 10, 'STARTUKM', 0, 1, 'C');
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 10, 'Invois Tempahan Bilik', 0, 1, 'C');
        $this->Ln(10);
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Rujukan Tempahan: ' . $bookingRef, 0, 1);
$pdf->Cell(0, 10, 'Tarikh: ' . date('d/m/Y'), 0, 1);
$pdf->Ln(10);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(90, 10, 'Kolej: ' . $booking['nama_kolej'], 0, 1);
$pdf->Cell(90, 10, 'Tarikh Check-in: ' . date('d/m/Y', strtotime($booking['tarikh_mula'])), 0, 1);
$pdf->Cell(90, 10, 'Tarikh Check-out: ' . date('d/m/Y', strtotime($booking['tarikh_tamat'])), 0, 1);
$pdf->Cell(90, 10, 'Jumlah Bayaran: RM' . number_format($booking['total_amount'], 2), 0, 1);

$pdf->Output('I', 'invoice-' . $bookingRef . '.pdf');
?> 