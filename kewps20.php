<?php
require_once __DIR__ . '/tcpdf/tcpdf.php';

class MYPDF extends TCPDF {
  public function Header() {
    // Meta (left/right)
    $this->SetFont('helvetica','',9);
    $this->Cell(0,5,'Pekeliling Perbendaharaan Malaysia',0,0,'L');
    $this->Cell(0,5,'AM 6.9 Lampiran B',0,1,'R');

    // Form code
    $this->SetFont('helvetica','B',12);
    $this->Cell(0,6,'KEW.PS-20',0,1,'R');

    // Title
    $this->Ln(2);
    $this->SetFont('helvetica','B',13);
    $this->Cell(0,7,'BORANG PELUPUSAN STOK',0,1,'C');
    $this->Ln(2);
  }
  public function Footer() {
    $this->SetY(-16);
    $this->SetFont('helvetica','',9);
    $this->Cell(0,6,'Nota: Jika lebih daripada 2 orang ahli Lembaga Pemeriksa ruangan boleh ditambah.',0,1,'L');
    $this->SetFont('helvetica','I',8);
    $this->Cell(0,8,'Page '.$this->getAliasNumPage().' / '.$this->getAliasNbPages(),0,0,'C');
  }
}

$pdf = new MYPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('NAZIMSAN');
$pdf->SetTitle('KEW.PS-20 – Borang Pelupusan Stok');

$pdf->SetMargins(10, 44, 10);
$pdf->SetHeaderMargin(6);
$pdf->SetAutoPageBreak(true, 22);
$pdf->SetFont('helvetica','',9);
$pdf->AddPage();

/* ---------- Styles (TCPDF-friendly) ---------- */
$style = '
<style>
  table { border-collapse: collapse; }
  .b  { border:0.5px solid #000; }
  .th { background-color:#d9d9d9; font-weight:bold; text-align:center; }
  .tc { text-align:center; }
  .tl { text-align:left; }
  .small { font-size:9pt; }
</style>
';

/* ---------- Top labels ---------- */
$top = '
<table width="100%" cellpadding="2" cellspacing="0">
  <tr>
    <td width="18%">Kementerian/ Jabatan</td><td width="2%">:</td><td></td>
  </tr>
  <tr>
    <td>Kategori Stor</td><td>:</td><td></td>
  </tr>
</table>
';

/* ---------- Main table ----------*/

$head = '
<table width="100%" cellpadding="4" cellspacing="0">
  <tr>
    <td class="th b tc" width="6%"  rowspan="2">No.<br>Kod</td>
    <td class="th b tc" width="17%" rowspan="2">Perihal Stok</td>
    <td class="th b tc" width="8%"  rowspan="2">Tarikh<br>Terima</td>
    <td class="th b tc" width="8%"  rowspan="2">Tempoh<br>Simpanan</td>
    <td class="th b tc" width="8%"  rowspan="2">Unit<br>Pengukuran</td>
    <td class="th b tc" width="7%"  rowspan="2">Kuantiti</td>

    <td class="th b tc" width="12%" colspan="2">Nilai Perolehan Asal<br>(RM)</td>

    <td class="th b tc" width="10%" rowspan="2">Nyatakan Keadaan Stok<br>Dengan Jelas</td>
    <td class="th b tc" width="8%"  rowspan="2">Syor Kaedah<br>Pelupusan</td>
    <td class="th b tc" width="8%"  rowspan="2">Justifikasi</td>
    <td class="th b tc" width="8%"  rowspan="2">Keputusan<br>Kuasa Melulus</td>
  </tr>
  <tr>
    <td class="th b tc" width="6%">Seunit</td>
    <td class="th b tc" width="6%">Jumlah</td>
  </tr>
';

$rows = '';
for ($i=0; $i<5; $i++) {
  $rows .= '
  <tr>
    <td class="b" style="height:18px;"></td>
    <td class="b"></td>
    <td class="b tc"></td>
    <td class="b tc"></td>
    <td class="b tc"></td>
    <td class="b tc"></td>
    <td class="b tc"></td>
    <td class="b tc"></td>
    <td class="b"></td>
    <td class="b"></td>
    <td class="b"></td>
    <td class="b"></td>
  </tr>';
}

$rows .= '
  <tr>
    <td class="b th tl" colspan="5" style="text-align:left;">JUMLAH</td>
    <td class="b"></td>
    <td class="b"></td>
    <td class="b"></td>
    <td class="b th" colspan="4"></td>

  </tr>
</table>
';

/* ---------- Signature panels ---------- */
$sign = '
<table width="100%" cellpadding="8" cellspacing="0" style="margin-top:12px;">
  <tr>
    <!-- Pegawai Pemeriksa 1 -->
    <td class="b" width="32%" valign="top">
      <b>Pegawai Pemeriksa 1:</b><br><br>
      ............................................................<br>
      <span class="small">(Tandatangan)</span><br><br>
      <table width="100%" cellpadding="2" cellspacing="0">
        <tr><td >Nama:</td><td></td></tr>
        <tr><td>Jawatan:</td><td></td></tr>
        <tr><td>Jabatan:</td><td></td></tr>
        <tr><td>Tarikh Lantikan:</td><td></td></tr>
        <tr><td>Tarikh Pemeriksaan:</td><td></td></tr>
      </table>
    </td>

    <!-- Pegawai Pemeriksa 2 -->
    <td class="b" width="34%" valign="top">
      <b>Pegawai Pemeriksa 2:</b><br><br>
      ............................................................<br>
      <span class="small">(Tandatangan)</span><br><br>
      <table width="100%" cellpadding="2" cellspacing="0">
        <tr><td >Nama:</td><td></td></tr>
        <tr><td>Jawatan:</td><td></td></tr>
        <tr><td>Jabatan:</td><td></td></tr>
        <tr><td>Tarikh Lantikan:</td><td></td></tr>
        <tr><td>Tarikh Pemeriksaan:</td><td></td></tr>
      </table>
    </td>

    <!-- Kuasa Melulus -->
    <td class="b" width="34%" valign="top">
      <b>Kuasa Melulus:</b><br><br>
      ............................................................<br>
      <span class="small">(Tandatangan)</span><br><br>
      <table width="100%" cellpadding="2" cellspacing="0">
        <tr><td >Nama:</td><td></td></tr>
        <tr><td>Jawatan:</td><td></td></tr>
        <tr><td>Tarikh:</td><td></td></tr>
        <tr><td>Nama Kementerian/ :</td><td></td></tr>
        <tr><td>Jabatan</td><td></td></tr>
      </table>
    </td>
  </tr>
</table>
';

/* ---------- Render ---------- */
$pdf->writeHTML($style.$top.$head.$rows.$sign, true, false, true, false, '');
$pdf->Output('kew_ps_20_borang_pelupusan_stok.pdf', 'I');
