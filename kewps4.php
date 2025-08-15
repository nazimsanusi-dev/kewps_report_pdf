<?php
require_once __DIR__ . '/tcpdf/tcpdf.php';

class MYPDF extends TCPDF {
  public function Header() {
    $this->SetFont('helvetica','',9);
    $this->Cell(0,5,'Pekeliling Perbendaharaan Malaysia',0,0,'L');
    $this->Cell(0,5,'AM 6.3 Lampiran B',0,1,'R');

    $this->SetFont('helvetica','B',12);
    $this->Cell(0,6,'KEW.PS-4',0,1,'R');

    $this->Ln(2);
    $this->SetFont('helvetica','B',13);
    $this->Cell(0,7,'SENARAI DAFTAR  STOK',0,1,'C');
    $this->Ln(2);
  }
  public function Footer() {
    $this->SetY(-15);
    $this->SetFont('helvetica','I',8);
    $this->Cell(0,10,'Page '.$this->getAliasNumPage().' / '.$this->getAliasNbPages(),0,0,'C');
  }
}

$pdf = new MYPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('NAZIMSAN');
$pdf->SetTitle('KEW.PS-4 - Senarai Daftar Stok');

$pdf->SetMargins(14, 40, 14);
$pdf->SetHeaderMargin(6);
$pdf->SetAutoPageBreak(true, 18);
$pdf->SetFont('helvetica','',10);
$pdf->AddPage();

$style = '
<style>
  .th{background-color:#d9d9d9; font-weight:bold; text-align:center;}
  .thin-border td, .thin-border th { border:0.5px solid #000; }
  .tdr{text-align:right;}
</style>
';

/* ---------- TABLE ---------- */
$tbl = '
<table class="thin-border" width="100%" cellpadding="5" cellspacing="0" style="border-collapse:collapse; margin-top:6px;">
  <tr>
    <th class="th" width="6%">Bil.</th>
    <th class="th" width="14%">No. Kad</th>
    <th class="th" width="14%">No. Kod</th>
    <th class="th" width="40%">Perihal Stok</th>
    <th class="th" width="13%">Nilai Baki<br>Semasa (RM)</th>
    <th class="th" width="13%">Status Stok<br>(Aktif/ Tidak Aktif/<br>Kad Dibatalkan)</th>
  </tr>
';

// generate empty listing rows (adjust count as you like)
$rows = 22;
for ($i=1; $i<=$rows; $i++) {
  $tbl .= '
  <tr>
    <td height="18"></td>
    <td></td>
    <td></td>
    <td></td>
    <td class="tdr"></td>
    <td></td>
  </tr>';
}

// total row
$tbl .= '
  <tr>
    <td colspan="4" class="th" style="text-align:left; font-weight:bold;">JUMLAH KESELURUHAN</td>
    <td class="tdr"></td>
    <td style="background-color:#000;">&nbsp;</td>
  </tr>
</table>
';

$pdf->writeHTML($style.$tbl, true, false, true, false, '');
$pdf->Output('kew_ps_4_senarai_daftar_stok.pdf', 'I');
