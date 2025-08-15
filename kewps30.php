<?php
require_once __DIR__ . '/tcpdf/tcpdf.php';

class MYPDF extends TCPDF
{
    public function Header()
    {
        // Top meta
        $this->SetFont('helvetica', '', 9);
        $this->Cell(0, 5, 'Pekeliling Perbendaharaan Malaysia', 0, 0, 'L');
        $this->Cell(0, 5, 'AM 6.9 Lampiran L', 0, 1, 'R');

        // Form code
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 6, 'KEW.PS-30', 0, 1, 'R');

        // Title
        $this->Ln(2);
        $this->SetFont('helvetica', 'B', 13);
        $this->Cell(0, 7, 'SENARAI STOK YANG DILELONG', 0, 1, 'C');
        $this->Ln(2);
    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().' / '.$this->getAliasNbPages(), 0, 0, 'C');
    }
}

/* ------------ Optional dynamic values ------------- */
$kementerian = ''; // e.g. "Kementerian XYZ / Jabatan ABC"
$rows = 10;        // number of lot rows

/* ------------ helpers ------------ */
function Uline($text = '', $minWidth = 260)
{
    $txt = htmlspecialchars($text);
    return '<span style="display:inline-block;border-bottom:0.5px solid #000;min-width:'.$minWidth.'px;">'.($txt ?: '&nbsp;').'</span>';
}

/* ------------ styles ------------ */
$css = '
<style>
  .th { background-color:#d9d9d9; font-weight:bold; text-align:center; border:0.5px solid #000; }
  .tc { text-align:center; }
  .tr { text-align:right; }
  table { border-collapse:collapse; }
  .small { font-size:9pt; }
</style>
';

$pdf = new MYPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('NAZIMSAN');
$pdf->SetTitle('KEW.PS-30 - Senarai Stok Yang Dilelong');

$pdf->SetMargins(15, 38, 15);
$pdf->SetHeaderMargin(8);
$pdf->SetAutoPageBreak(true, 18);
$pdf->SetFont('helvetica', '', 11);

$pdf->AddPage();

/* ------------ top line (Kementerian/Jabatan) ------------ */
$html  = $css;
$html .= '
<div style="margin-bottom:6px;">
  <span style="font-weight:bold;">KEMENTERIAN / JABATAN:</span> '.Uline($kementerian, 300).'
</div>
<div></div>
';

/* ------------ table ------------ */
/* widths sum to 100%: 8 + 42 + 12 + 20 + 18 */
$html .= '
<table cellpadding="5" cellspacing="0" width="100%" style="border:0.5px solid #000; margin-top:4px;">
  <tr>
    <td class="th" width="8%">Lot</td>
    <td class="th" width="42%">Perihal Stok</td>
    <td class="th" width="12%">Kuantiti</td>
    <td class="th" width="20%">Harga Simpanan<br>(RM)</td>
    <td class="th" width="18%">Deposit</td>
  </tr>
';

for ($i = 1; $i <= $rows; $i++) {
    $html .= '
    <tr>
      <td class="tc" style="border-top:0.5px solid #000; border-right:0.5px solid #000; border-left:0.5px solid #000;">'.$i.'.</td>
      <td style="border-top:0.5px solid #000; border-right:0.5px solid #000;"></td>
      <td class="tc" style="border-top:0.5px solid #000; border-right:0.5px solid #000;"></td>
      <td class="tr" style="border-top:0.5px solid #000; border-right:0.5px solid #000;"></td>
      <td class="tr" style="border-top:0.5px solid #000; border-right:0.5px solid #000;"></td>
    </tr>';
}
$html .= '</table>';

/* ------------ signature block ------------ */
$html .= '
<br><br><br>
<table width="100%" cellpadding="2" cellspacing="0" border="0">
  <tr>
    <td width="45%">
      <div>________________________</div>
      <div class="small">(Tandatangan Ketua Jabatan)</div>
      <br>
      <table width="100%" cellpadding="2" cellspacing="0" border="0">
        <tr>
          <td width="22%">Nama</td><td width="5%">:</td>
        </tr>
        <tr>
          <td>Jawatan</td><td>:</td>
        </tr>
        <tr>
          <td>Tarikh</td><td>:</td>
        </tr>
      </table>
      <br>
      <div>Cap Kementerian/ Jabatan :</div>
    </td>
    <td width="55%"></td>
  </tr>
</table>
';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('kew_ps_30.pdf', 'I');

