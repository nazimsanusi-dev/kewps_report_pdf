<?php
require_once __DIR__ . '/tcpdf/tcpdf.php';

class MYPDF extends TCPDF
{
    // Page header
    public function Header()
    {
        // KEW.PS-11 top right
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 5, 'KEW.PS-11', 0, 1, 'R');

        $this->Cell(0, 5, '', 0, 1, 'R');

        // No. Permohonan
        $this->SetFont('helvetica', '', 10);
        $this->Cell(0, 5, 'No. Permohonan : ...........................................', 0, 1, 'R');

        // Title
        $this->Ln(2);
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 6, 'BORANG PERMOHONAN STOK', 0, 1, 'C');

        // Subtext
        $this->SetFont('helvetica', '', 10);
        $this->Cell(0, 5, '(Tatacara Pengurusan Stor 143)', 0, 1, 'C');
        $this->Cell(0, 5, '(Untuk kegunaan di Stor Unit-diisi dalam 2 salinan)', 0, 1, 'C');

        $this->Ln(6); // space before body
    }

    // Optional footer
    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().' / '.$this->getAliasNbPages(), 0, 0, 'C');
    }
}

// Create PDF
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Document settings
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('NAZIMSAN');
$pdf->SetTitle('Borang Permohonan Stok');

// Margins (top margin must be big enough for header)
$pdf->SetMargins(15, 55, 15);
$pdf->SetHeaderMargin(15);
$pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
$pdf->SetFont('helvetica', '', 9);

// Add page
$pdf->AddPage('P', 'A4');

// First table (Permohonan & Kelulusan)
$html = '
<table border="1" cellpadding="7" cellspacing="0" width="100%" style="border-width:0.5px;">
    <tr style="background-color:#d9d9d9; font-weight:bold; text-align:center;">
        <td rowspan="2" width="10%">Bil.</td>
        <td colspan="2" width="40%">Permohonan</td>
        <td colspan="2" width="40%">Pegawai Pelulus</td>
        <td rowspan="2" width="10%">Catatan</td>
    </tr>
    <tr style="background-color:#d9d9d9; font-weight:bold; text-align:center;">
        <td width="20%">Perihal Stok</td>
        <td width="20%">Kuantiti Dipesan</td>
        <td width="20%">Kuantiti Diluluskan</td>
        <td width="20%">Baki Kuantiti Dipesan</td>
    </tr>
    <tr><td height="25"></td><td></td><td></td><td></td><td></td><td></td></tr>
    <tr><td height="25"></td><td></td><td></td><td></td><td></td><td></td></tr>
    <tr><td height="25"></td><td></td><td></td><td></td><td></td><td></td></tr>
    <tr><td height="25"></td><td></td><td></td><td></td><td></td><td></td></tr>
    <tr><td height="25"></td><td></td><td></td><td></td><td></td><td></td></tr>
    <tr>
        <td colspan="3" valign="top" height="100">
            <br><br><br><br>
            .........................................<br>
            (Tandatangan Pemohon)<br><br>
            <table border="0" width="100%" cellpadding="2" cellspacing="0">
                <tr>
                    <td width="25%"><b>Nama</b></td>
                    <td width="5%">:</td>
                </tr>
                <tr>
                    <td><b>Jawatan</b></td>
                    <td>:</td>
                </tr>
                <tr>
                    <td><b>Tarikh</b></td>
                    <td>:</td>
                </tr>
            </table>
        </td>
        <td colspan="3" valign="top">
            <b>Kelulusan:</b><br>
            Permohonan diluluskan / tidak diluluskan*<br><br>
            .........................................<br>
            (Tandatangan Pegawai Pelulus)<br><br>
            <table border="0" width="100%" cellpadding="2" cellspacing="0">
                <tr>
                    <td width="25%"><b>Nama</b></td>
                    <td width="5%">:</td>
                </tr>
                <tr>
                    <td><b>Jawatan</b></td>
                    <td>:</td>
                </tr>
                <tr>
                    <td><b>Tarikh</b></td>
                    <td>:</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<div style="font-size:9pt;">* sila potong yang berkenaan</div>
<br><br>
';

// Second table (Kemaskini Rekod & Perakuan Penerimaan)
$html .= '
<table border="1" cellpadding="4" cellspacing="0" width="100%" style="border-width:0.5px;">
    <tr>
        <td valign="top" width="50%">
            <b>Kemaskini Rekod:</b><br>
            Stok telah dikeluarkan dan direkod<br>
            di Kad Petak No ...............<br><br>
            .........................................<br>
            (Tandatangan Pegawai Stor)<br><br>
            <table border="0" width="100%" cellpadding="2" cellspacing="0">
                <tr>
                    <td width="25%"><b>Nama</b></td>
                    <td width="5%">:</td>
                </tr>
                <tr>
                    <td><b>Jawatan</b></td>
                    <td>:</td>
                </tr>
                <tr>
                    <td><b>Tarikh</b></td>
                    <td>:</td>
                </tr>
            </table>
        </td>
        <td valign="top" width="50%">
            <b>Perakuan Penerimaan:</b><br>
            Disahkan bahawa stok yang diluluskan telah diterima.<br>
            <br><br>
            .........................................<br>
            (Tandatangan Pemohon)<br><br>
            <table border="0" width="100%" cellpadding="2" cellspacing="0">
                <tr>
                    <td width="25%"><b>Nama</b></td>
                    <td width="5%">:</td>
                </tr>
                <tr>
                    <td><b>Jawatan</b></td>
                    <td>:</td>
                </tr>
                <tr>
                    <td><b>Tarikh</b></td>
                    <td>:</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
';

// Output content
$pdf->writeHTML($html, true, false, true, false, '');

// Output PDF
$pdf->Output('borang_permohonan_stok.pdf', 'I');
