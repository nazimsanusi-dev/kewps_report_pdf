<?php
require_once __DIR__ . '/tcpdf/tcpdf.php';

class MYPDF extends TCPDF {
  public function Header() {
    $this->SetFont('helvetica','',9);
    $this->Cell(0,5,'Pekeliling Perbendaharaan Malaysia',0,0,'L');
    $this->Cell(0,5,'AM 6.3 Lampiran C',0,1,'R');

    $this->SetFont('helvetica','B',12);
    $this->Cell(0,6,'KEW.PS-5',0,1,'R');

    $this->Ln(2);
    $this->SetFont('helvetica','B',13);
    $this->Cell(0,7,'PENENTUAN KUMPULAN STOK',0,1,'C');
    $this->Ln(2);
  }
  public function Footer() {
    $this->SetY(-15);
    $this->SetFont('helvetica','I',8);
    $this->Cell(0,10,'Page '.$this->getAliasNumPage().' / '.$this->getAliasNbPages(),0,0,'C');
  }
}

$pdf = new MYPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('NAZIMSAN');
$pdf->SetTitle('KEW.PS-5 – Penentuan Kumpulan Stok');

$pdf->SetMargins(12, 42, 12);
$pdf->SetHeaderMargin(6);
$pdf->SetAutoPageBreak(true, 16);
$pdf->SetFont('helvetica','',10);
$pdf->AddPage();

$style = '
<style>
  .th { background-color:#d9d9d9; font-weight:bold; text-align:center; }
  .thin-border td, .thin-border th { border:0.5px solid #000; }
  .left { text-align:left; }
</style>
';

/* ---------- NAMA STOR ---------- */
$namaStor = '
<table width="100%" cellpadding="2" cellspacing="0">
  <tr>
    <td width="12%"><b>Nama Stor:</b></td>
    <td width="88%"><span style="display:inline-block; border-bottom:0.5px solid #000; width:96%;">&nbsp;</span></td>
  </tr>
</table>
';

/* ---------- MAIN TABLE ---------- */
$tbl = '
<table class="thin-border" width="100%" cellpadding="5" cellspacing="0" style="border-collapse:collapse; margin-top:8px;">
  <tr>
    <th class="th" width="5%"  rowspan="2">Bil.</th>
    <th class="th" width="10%" rowspan="2">No. Kod</th>
    <th class="th" width="32%" rowspan="2">Perihal Stok</th>

    <th class="th" width="22%" colspan="2">Jumlah Nilai Pembelian<br>Bagi<br>2 Tahun Lepas</th>

    <th class="th" width="11%" rowspan="2">Purata Nilai<br>Pembelian<br>[ a + b ] ÷ 2<br>(c)</th>
    <th class="th" width="12%" rowspan="2">Peratusan<br>[ c ÷ Σ ] × 100<br>(%)<br>(d)</th>
    <th class="th" width="8%"  rowspan="2">Kumpulan<br>Barang<br>A atau B</th>
  </tr>
  <tr>
    <th class="th" width="11%">20 …..<br>(RM)<br>(a)</th>
    <th class="th" width="11%">20 ….<br>(RM)<br>(b)</th>
  </tr>
';

/* example empty rows: add as many as you need */
for ($i=0; $i<8; $i++) {
  $tbl .= '
  <tr>
    <td height="18"></td><td></td><td></td>
    <td></td><td></td>
    <td></td><td></td><td></td>
  </tr>';
}

/* bottom total + notes */
$tbl .= '
  <tr>
    <td class="th left" colspan="5">∑ = JUMLAH KESELURUHAN</td>
    <td></td>
    <td colspan="2" class="left" valign="top">
      <b>Catatan:</b><br>
      Kumpulan A = 30%<br>
      Kumpulan B = 70%
    </td>
  </tr>
</table>
';

$pdf->writeHTML($style.$namaStor.$tbl, true, false, true, false, '');
$pdf->Output('kew_ps_5_penentuan_kumpulan_stok.pdf', 'I');
