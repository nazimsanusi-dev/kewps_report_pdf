<?php
require_once __DIR__ . '/tcpdf/tcpdf.php';

class MYPDF extends TCPDF
{
    public function Header()
    {
        // Top meta
        $this->SetFont('helvetica', '', 9);
        $this->Cell(0, 5, 'Pekeliling Perbendaharaan Malaysia', 0, 0, 'L');
        $this->Cell(0, 5, 'AM 6.9 Lampiran M', 0, 1, 'R');

        // Form code
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 6, 'KEW.PS-31', 0, 1, 'R');

        // Title (2 lines)
        $this->Ln(2);
        $this->SetFont('helvetica', 'B', 13);
        $this->Cell(0, 6, 'LAPORAN PELUPUSAN STOK', 0, 1, 'C');
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

/* -------- Optional dynamic values -------- */
$kementerian = '';   // e.g. "Kementerian XYZ / Jabatan ABC"
$rows = 6;           // number of detail rows

/* -------- helpers -------- */
function Uline($text = '', $minWidth = 260) {
    $txt = htmlspecialchars($text);
    return '<span style="display:inline-block;border-bottom:0.5px solid #000;min-width:'.$minWidth.'px;">'.($txt ?: '&nbsp;').'</span>';
}

/* -------- styles -------- */
$css = '
<style>
  .th { background-color:#d9d9d9; font-weight:bold; text-align:center; border:0.5px solid #000 }
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
$pdf->SetTitle('KEW.PS-31 - Laporan Pelupusan Stok');

$pdf->SetMargins(15, 48, 15);
$pdf->SetHeaderMargin(8);
$pdf->SetAutoPageBreak(true, 16);
$pdf->SetFont('helvetica', '', 10);

$pdf->AddPage();

/* -------- Kementerian/Jabatan line -------- */
$html  = $css;
$html .= '
<div style="margin-bottom:6px;">
  <span class="small" style="font-weight:bold;">Kementerian / Jabatan:</span> '.Uline($kementerian, 360).'
</div>
';

/* -------- Main table ------------ */
$html .= '
<table cellpadding="4" cellspacing="0" width="100%" style="border:0.5px solid #000; margin-top:4px;">
  <tr>
    <td class="th" width="20%" rowspan="2">KEMENTERIAN/ JABATAN</td>
    <td class="th" width="12%"  rowspan="2">NILAI<br>PEROLEHAN<br>ASAL<br>(RM)</td>
    <td class="th" width="40%" colspan="10">JUMLAH NILAI PEROLEHAN ASAL STOK MENGIKUT<br>KAEDAH (RM)</td>
    <td class="th" width="14%" rowspan="2">HASIL<br>PELUPUSAN<br>(RM)</td>
    <td class="th" width="14%" rowspan="2">KOS<br>PENGENDALIAN<br>(RM)</td>
  </tr>
  <tr>
    <td class="th" width="4%">A</td>
    <td class="th" width="4%">B</td>
    <td class="th" width="4%">C</td>
    <td class="th" width="4%">D</td>
    <td class="th" width="4%">E</td>
    <td class="th" width="4%">F</td>
    <td class="th" width="4%">G</td>
    <td class="th" width="4%">H</td>
    <td class="th" width="4%">I</td>
    <td class="th" width="4%">J</td>
  </tr>
';

for ($i = 0; $i < $rows; $i++) {
    $html .= '
    <tr>
      <td style="border-top:0.5px solid #000; border-right:0.5px solid #000; border-left:0.5px solid #000;"></td>
      <td class="tr" style="border-top:0.5px solid #000; border-right:0.5px solid #000;"></td>';
    for ($k = 0; $k < 10; $k++) {
        $html .= '<td class="tr" style="border-top:0.5px solid #000; border-right:0.5px solid #000;"></td>';
    }
    $html .= '
      <td class="tr" style="border-top:0.5px solid #000; border-right:0.5px solid #000;"></td>
      <td class="tr" style="border-top:0.5px solid #000; border-right:0.5px solid #000;"></td>
    </tr>';
}

/* -------- Total row -------- */
$html .= '
  <tr>
    <td class="th tl" colspan="2" style="border-top:0.5px solid #000;">JUMLAH KESELURUHAN</td>';
for ($k = 0; $k < 10; $k++) {
    $html .= '<td class="th" style="border-top:0.5px solid #000; border-right:0.5px solid #000;"></td>';
}
$html .= '
    <td class="th" style="border-top:0.5px solid #000; border-right:0.5px solid #000;"></td>
    <td class="th" style="border-top:0.5px solid #000; border-right:0.5px solid #000;"></td>
  </tr>
</table>
';

/* -------- PETUNJUK -------- */
$html .= '
<br>
<div class="small"><b>PETUNJUK:</b><br>
A: JUALAN (TENDER, SEBUT HARGA, LELONG)<br>
B: BUANGAN TERJADUAL (E-WASTE DAN SISA PEPEJAL)<br>
C: JUALAN SISA (TENDER, SEBUT HARGA &amp; JUALAN TERUS)<br>
D: TUKAR BARANG/PERKHIDMATAN<br>
E: TUKAR BELI<br>
F: TUKAR GANTI<br>
G: HADIAH<br>
H: SERAHAN<br>
I: MUSNAH (TANAM, BAKAR, BUANG, TENGGELAM, LETUP, LEDAK DAN LEBUR)<br>
J: KAEDAH-KAEDAH LAIN
</div>
';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('kew_ps_31.pdf', 'I');
