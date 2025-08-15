<?php
require_once __DIR__ . '/tcpdf/tcpdf.php';

class MYPDF extends TCPDF {
  public function Header() {
    // Top meta
    $this->SetFont('helvetica','',9);
    $this->Cell(0,5,'Pekeliling Perbendaharaan Malaysia',0,0,'L');
    $this->Cell(0,5,'AM 6.4 Lampiran A',0,1,'R');

    // Right code + small yellow label
    $this->SetFont('helvetica','B',12);
    // little Lampiran 2 tag (optional)
    $this->SetXY($this->getPageWidth()-80, 16);
    $this->SetFillColor(255, 235, 59); // yellow
    $this->Cell(30, 8, 'Lampiran 2', 0, 0, 'C', true);

    $this->SetXY(0, 16);
    $this->Cell(0, 8, 'KEW.PS-6', 0, 1, 'R');

    // Title
    $this->Ln(2);
    $this->SetFont('helvetica','B',13);
    $this->Cell(0, 7, 'SENARAI STOK BERTARIKH LUPUT', 0, 1, 'C');
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
$pdf->SetTitle('KEW.PS-6 — Senarai Stok Bertarikh Luput');

$pdf->SetMargins(12, 42, 12);
$pdf->SetHeaderMargin(6);
$pdf->SetAutoPageBreak(true, 16);
$pdf->SetFont('helvetica','',10);
$pdf->AddPage();

$style = '
<style>
  .th{ background-color:#d9d9d9; font-weight:bold; text-align:center; }
  .thin-border td, .thin-border th { border:0.5px solid #000; }
  .small{ font-size:9pt; }
  .sp{ height:8px; }
</style>
';

/* ---------- HEADER FIELDS ---------- */
$fields = '
<table width="100%" cellpadding="2" cellspacing="0">
  <tr>
    <td width="18%"><b>Kementerian/Jabatan:</b></td>
    <td width="82%"><span style="display:inline-block;border-bottom:0.5px solid #000; width:96%">&nbsp;</span></td>
  </tr>
  <tr>
    <td><b>Kategori Stor:</b></td>
    <td><span style="display:inline-block;border-bottom:0.5px solid #000; width:96%">&nbsp;</span></td>
  </tr>
  <tr>
    <td><b>Bulan:</b></td>
    <td><span style="display:inline-block;border-bottom:0.5px solid #000; width:96%">&nbsp;</span></td>
  </tr>
</table>
<div class="sp"></div>
';

/* ---------- MAIN TABLE ---------- */
$tbl = '
<table class="thin-border" width="100%" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
  <tr>
    <th class="th" width="4%"  rowspan="2">Bil.</th>
    <th class="th" width="17%" rowspan="2">Perihal Stok</th>
    <th class="th" width="8%"  rowspan="2">No. Kod</th>
    <th class="th" width="10%" rowspan="2">Lokasi Stok</th>
    <th class="th" width="9%"  rowspan="2">Kuantiti Terimaan</th>
    <th class="th" width="8%"  rowspan="2">Tarikh Luput</th>

    <th class="th" width="36%" colspan="6">
      Baki Stok Bagi 6 Bulan Sebelum Tamat Tempoh Luput<br>
      <span class="small">*(Kuantiti dan tarikh kemaskini)</span>
    </th>

    <th class="th" width="8%" rowspan="2">Catatan</th>
  </tr>
  <tr>
    <th class="th" width="6%">6 bulan</th>
    <th class="th" width="6%">5 bulan</th>
    <th class="th" width="6%">4 bulan</th>
    <th class="th" width="6%">3 bulan</th>
    <th class="th" width="6%">2 bulan</th>
    <th class="th" width="6%">1 bulan</th>
  </tr>
';

/* blank lines (add more if needed) */
for ($i=0; $i<12; $i++) {
  $tbl .= '
  <tr>
    <td height="18"></td>
    <td></td><td></td><td></td><td></td><td></td>
    <td></td><td></td><td></td><td></td><td></td><td></td>
    <td></td>
  </tr>';
}

$tbl .= '</table>
<div class="small" style="margin-top:6px;">* Dikemaskini kuantiti dan tarikh oleh Pegawai Stor dalam bulan yang sama.</div>
';

$pdf->writeHTML($style.$fields.$tbl, true, false, true, false, '');
$pdf->Output('kew_ps_6_senarai_stok_bertarikh_luput.pdf', 'I');
