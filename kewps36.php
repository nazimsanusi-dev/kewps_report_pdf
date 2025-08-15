<?php
require_once __DIR__ . '/tcpdf/tcpdf.php';

class MYPDF extends TCPDF
{
    public function Header()
    {
        // Top meta
        $this->SetFont('helvetica', '', 9);
        $this->Cell(0, 5, 'Pekeliling Perbendaharaan Malaysia', 0, 0, 'L');
        $this->Cell(0, 5, 'AM 6.10 Lampiran E', 0, 1, 'R');

        // Form code
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 6, 'KEW.PS-36', 0, 1, 'R');

        // Title (2 lines)
        $this->Ln(2);
        $this->SetFont('helvetica', 'B', 13);
        $this->Cell(0, 6, 'LAPORAN KEHILANGAN DAN HAPUS KIRA STOK', 0, 1, 'C');
        $this->Cell(0, 6, 'BAGI TAHUN …………..', 0, 1, 'C');
        $this->Ln(2);
    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().' / '.$this->getAliasNbPages(), 0, 0, 'C');
    }
}

/* -------- optional dynamic values -------- */
$kementerian = '';   // e.g., "Kementerian XYZ / Jabatan ABC"
$rows = 5;           // number of detail rows

/* -------- helpers -------- */
function Uline($text = '', $minWidth = 360) {
    $t = htmlspecialchars($text);
    return '<span style="display:inline-block;border-bottom:0.5px solid #000;min-width:'.$minWidth.'px;">'.($t ?: '&nbsp;').'</span>';
}

/* -------- styles -------- */
$css = '
<style>
  .th { background-color:#d9d9d9; font-weight:bold; text-align:center; border:0.5px solid #000; }
  .tc { text-align:center; }
  .tr { text-align:right; }
  .tl { text-align:left; }
  .small { font-size:9pt; }
  table { border-collapse:collapse; }
</style>
';

$pdf = new MYPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false); // Landscape
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('NAZIMSAN');
$pdf->SetTitle('KEW.PS-36 - Laporan Kehilangan dan Hapus Kira Stok');

$pdf->SetMargins(15, 48, 15);
$pdf->SetHeaderMargin(8);
$pdf->SetAutoPageBreak(true, 16);
$pdf->SetFont('helvetica', '', 10);

$pdf->AddPage();

/* -------- Kementerian/Jabatan line -------- */
$html  = $css;
$html .= '
<div style="margin-bottom:6px;">
  <span style="font-weight:bold;">Kementerian/ Jabatan:</span> '.Uline($kementerian, 420).'
</div>
';

/* -------- Main table (widths sum to 100%) --------
   Kementerian/Jabatan: 22%
   Tindakan Hapus Kira: 33%  (A=11% each x3)
   Tindakan Surcaj:     22%  (11% each x2)
   Tindakan Tatatertib: 23%  (single column)
--------------------------------------------------- */
$html .= '
<table cellpadding="4" cellspacing="0" width="100%" style="border:0.5px solid #000; margin-top:4px;">
  <tr>
    <td class="th" width="22%" rowspan="2">KEMENTERIAN/ JABATAN</td>
    <td class="th" width="33%" colspan="3">TINDAKAN HAPUS KIRA</td>
    <td class="th" width="22%" colspan="2">TINDAKAN SURCAJ</td>
    <td class="th" width="23%" rowspan="2">TINDAKAN TATATERTIB<br>JUMLAH BILANGAN KES</td>
  </tr>
  <tr>
    <td class="th" width="11%">JUMLAH<br>BILANGAN<br>KES</td>
    <td class="th" width="11%">NILAI<br>PEROLEHAN<br>ASAL (RM)</td>
    <td class="th" width="11%">NILAI<br>SEMASA (RM)</td>
    <td class="th" width="11%">JUMLAH<br>BILANGAN<br>KES</td>
    <td class="th" width="11%">NILAI<br>SURCAJ (RM)</td>
  </tr>
';

for ($i = 0; $i < $rows; $i++) {
    $html .= '
    <tr>
      <td style="border-top:0.5px solid #000; border-left:0.5px solid #000; border-right:0.5px solid #000;"></td>
      <td class="tr" style="border-top:0.5px solid #000; border-right:0.5px solid #000;"></td>
      <td class="tr" style="border-top:0.5px solid #000; border-right:0.5px solid #000;"></td>
      <td class="tr" style="border-top:0.5px solid #000; border-right:0.5px solid #000;"></td>
      <td class="tr" style="border-top:0.5px solid #000; border-right:0.5px solid #000;"></td>
      <td class="tr" style="border-top:0.5px solid #000; border-right:0.5px solid #000;"></td>
      <td class="tr" style="border-top:0.5px solid #000; border-right:0.5px solid #000;"></td>
    </tr>';
}

/* -------- Total row -------- */
$html .= '
  <tr>
    <td class="th tl" style="border-top:0.5px solid #000;">JUMLAH KESELURUHAN</td>
    <td style="border-top:0.5px solid #000; border-right:0.5px solid #000;"></td>
    <td style="border-top:0.5px solid #000; border-right:0.5px solid #000;"></td>
    <td style="border-top:0.5px solid #000; border-right:0.5px solid #000;"></td>
    <td style="border-top:0.5px solid #000; border-right:0.5px solid #000;"></td>
    <td style="border-top:0.5px solid #000; border-right:0.5px solid #000;"></td>
    <td style="border-top:0.5px solid #000; border-right:0.5px solid #000;"></td>
  </tr>
</table>
';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('kew_ps_36.pdf', 'I');
