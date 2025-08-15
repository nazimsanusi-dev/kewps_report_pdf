<?php
require_once __DIR__ . '/tcpdf/tcpdf.php';

class MYPDF extends TCPDF {
  public function Header() {
    // Top meta
    $this->SetFont('helvetica','',9);
    $this->Cell(0,5,'Pekeliling Perbendaharaan Malaysia',0,0,'L');
    $this->Cell(0,5,'AM 6.6 Lampiran A',0,1,'R');

    // Form code + No. Rujukan
    $this->SetFont('helvetica','B',12);
    $this->Cell(0,6,'KEW.PS-10',0,1,'R');

    $this->SetFont('helvetica','',10);
    $this->Cell(0,5,'No. Rujukan: ..........................',0,1,'R');

    // Title
    $this->Ln(2);
    $this->SetFont('helvetica','B',13);
    $this->Cell(0,7,'BORANG VERIFIKASI STOR TAHUN ............',0,1,'C');
    $this->SetFont('helvetica','',10);
    $this->Cell(0,5,'(Diisi oleh Pegawai Pemverifikasi)',0,1,'C');
    $this->Ln(2);
  }
  public function Footer() {
    $this->SetY(-14);
    $this->SetFont('helvetica','I',8);
    $this->Cell(0,10,'Page '.$this->getAliasNumPage().' / '.$this->getAliasNbPages(),0,0,'C');
  }
}

$pdf = new MYPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('NAZIMSAN');
$pdf->SetTitle('KEW.PS-10 – Borang Verifikasi Stor');

$pdf->SetMargins(10, 44, 10);     // leave space for header
$pdf->SetHeaderMargin(6);
$pdf->SetAutoPageBreak(true, 20);
$pdf->SetFont('helvetica','',9);
$pdf->AddPage();

$style = '
<style>
  .th{background-color:#d9d9d9; font-weight:bold; text-align:center; border:0.5px solid #000;}
  .tdc{text-align:center;}
  .tdd{border-bottom:0.5px solid #000;}
  .border{border-right:0.5px solid #000;}
  table { border-collapse: collapse; }
</style>
';

// ---- Top info lines
$info = '
<table width="100%" cellpadding="2" cellspacing="0" style="margin-bottom:6px;">
  <tr>
    <td width="18%">Kementerian/Jabatan :</td>
    
  </tr>
  <tr>
    <td>Bahagian :</td>
  </tr>
  <tr>
    <td>Nama Stor :</td>
  </tr>
</table>
';

// ---- Main grouped table
// layout widths: 40% (3 cols) | 18% (2 cols) | 18% (6 cols) | 24% (1 col) = 100%
$head =
'<table cellpadding="4" cellspacing="0" width="100%" style="border:0.5px solid #000;">
  <tr>
    <td class="th" style="border-right:0.5px solid #000;" width="40%" colspan="3">MAKLUMAT STOK DI KEW.PS-3</td>
    <td class="th" style="border-right:0.5px solid #000;" width="18%" colspan="2">KUANTITI STOK</td>
    <td class="th" style="border-right:0.5px solid #000;" width="18%" colspan="6">STATUS STOK</td>
    <td class="th" width="24%" rowspan="2">Catatan</td>
  </tr>
  <tr>
    <td class="th" style="border" width="6%">No. Kod</td>
    <td class="th" width="24%">Perihal Stok</td>
    <td class="th" width="10%">Kuantiti Stok</td>

    <td class="th" width="10%">Fizikal Stok</td>
    <td class="th" width="8%">Perbezaan<br>(+/-)</td>

    <td class="th" width="3%">A</td>
    <td class="th" width="3%">B</td>
    <td class="th" width="3%">C</td>
    <td class="th" width="3%">D</td>
    <td class="th" width="3%">E</td>
    <td class="th" width="3%">F</td>
  </tr>';

$rows = '';
for ($i=0; $i<5; $i++) {
  $rows .= '
  <tr>
    <td style="border-top:0.5px solid #000; border-right:0.5px solid #000; height:18px;"></td>
    <td style="border-top:0.5px solid #000; border-right:0.5px solid #000;"></td>
    <td style="border-top:0.5px solid #000; border-right:0.5px solid #000;"></td>

    <td style="border-top:0.5px solid #000; border-right:0.5px solid #000;"></td>
    <td style="border-top:0.5px solid #000; border-right:0.5px solid #000;"></td>

    <td style="border-top:0.5px solid #000; border-right:0.5px solid #000;"></td>
    <td style="border-top:0.5px solid #000; border-right:0.5px solid #000;"></td>
    <td style="border-top:0.5px solid #000; border-right:0.5px solid #000;"></td>
    <td style="border-top:0.5px solid #000; border-right:0.5px solid #000;"></td>
    <td style="border-top:0.5px solid #000; border-right:0.5px solid #000;"></td>
    <td style="border-top:0.5px solid #000; border-right:0.5px solid #000;"></td>

    <td style="border-top:0.5px solid #000;"></td>
  </tr>';
}
$table = $head.$rows.'</table>';

// ---- Signature blocks
$sign = '
<table cellpadding="8" cellspacing="0" width="100%" style="margin-top:10px; border-collapse:collapse;">
    <!-- Header row with full border -->
    <tr>
        <td style="font-weight:bold; border:0.5px solid #000; background:#fff;">PEGAWAI VERIFIKASI 1</td>
        <td style="font-weight:bold; border:0.5px solid #000; background:#fff;">PEGAWAI VERIFIKASI 2</td>
        <td style="font-weight:bold; border:0.5px solid #000; background:#fff;">PENGESAHAN PEGAWAI ASET</td>
    </tr>
    
    <tr>
        <!-- PEGAWAI VERIFIKASI 1 -->
        <td width="33.33%" valign="top" style="border:0.5px solid #000;">
        <table width="100%" cellpadding="2" cellspacing="0">
            <tr><td ></td></tr>
            <tr><td >Tandatangan:</td></tr>
            <tr><td>Nama:</td></tr>
            <tr><td>Jawatan:</td></tr>
            <tr><td>Jabatan:</td></tr>
            <tr><td>Tarikh:</td></tr>
        </table>
        </td>

        <!-- PEGAWAI VERIFIKASI 2 -->
        <td width="33.33%" valign="top" style="border:0.5px solid #000;">
        <table width="100%" cellpadding="2" cellspacing="0">
            <tr><td ></td></tr>
            <tr><td >Tandatangan:</td></tr>
            <tr><td>Nama:</td></tr>
            <tr><td>Jawatan:</td></tr>
            <tr><td>Jabatan:</td></tr>
            <tr><td>Tarikh:</td></tr>
        </table>
        </td>

        <!-- PENGESAHAN PEGAWAI ASET -->
        <td width="33.33%" valign="top" style="border:0.5px solid #000;">
        <table width="100%" cellpadding="2" cellspacing="0">
            <tr><td ></td></tr>
            <tr><td >Tandatangan:</td></tr>
            <tr><td>Nama:</td></tr>
            <tr><td>Jawatan:</td></tr>
            <tr><td>Tarikh:</td></tr>
        </table>
        </td>
    </tr>
</table>
';

// ---- Notes box
$notes = '
<table cellpadding="6" cellspacing="0" width="100%" style="border:0.5px solid #000; margin-top:8px;">
  <tr>
    <td>
      <b>Nota:</b>  Perbezaan (+/-): ‘+’ Bermaksud kuantiti fizikal didapati berlebihan. &nbsp;&nbsp;
      ‘-’ Bermaksud kuantiti fizikal didapati kurang.
      <br><br>
      <b>Status Stok:</b> Nyatakan kuantiti stok yang mempunyai status seperti di bawah.<br>
      (A) Usang &nbsp; (B) Rosak &nbsp; (C) Tidak Aktif &nbsp; (D) Tidak Diperlukan &nbsp; (E) Luput Tempoh &nbsp; (F) Hilang
      <br><br>
      <b>Catatan:</b> Apa-apa maklumat tambahan berkenaan penemuan verifikasi stor tersebut.
    </td>
  </tr>
</table>
';

$pdf->writeHTML($style.$info.$table.$sign.$notes, true, false, true, false, '');
$pdf->Output('kew_ps_10_borang_verifikasi_stor.pdf', 'I');
