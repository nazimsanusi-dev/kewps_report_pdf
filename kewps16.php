<?php

// require_once __DIR__.'/tcpdf/tcpdf.php';

// class MYPDF extends TCPDF {
//     public function Header() {
//         $this->setFont()
//         $this->Cell()
//     }
//     public function Footer(){
//         $this->setFont()
//         $this->Cell()
//     }
// }

require_once __DIR__ . '/tcpdf/tcpdf.php';

class MYPDF extends TCPDF {
  public function Header() {
    // Top meta
    $this->SetFont('helvetica','',9);
    $this->Cell(0,5,'Pekeliling Perbendaharaan Malaysia',0,0,'L');
    $this->Cell(0,5,'AM 6.6 Lampiran F',0,1,'R');

    // Form code
    $this->SetFont('helvetica','B',12);
    $this->Cell(0,6,'KEW.PS-16',0,1,'R');

    // Title
    $this->Ln(2);
    $this->SetFont('helvetica','B',13);
    $this->Cell(0,7,'PERAKUAN AMBIL ALIH STOR',0,1,'C');
    $this->Ln(2);
  }
  public function Footer() {
    $this->SetY(-16);
    $this->SetFont('helvetica','',9);
    $this->Cell(0,6,'Nota: Ruang Tandatangan boleh di lampiran terakhir.',0,1,'L');
    $this->SetFont('helvetica','I',8);
    $this->Cell(0,8,'Page '.$this->getAliasNumPage().' / '.$this->getAliasNbPages(),0,0,'C');
  }
}

$pdf = new MYPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('NAZIMSAN');
$pdf->SetTitle('KEW.PS-16 – Perakuan Ambil Alih Stor');

$pdf->SetMargins(10, 35, 10);
$pdf->SetHeaderMargin(4);
$pdf->SetAutoPageBreak(true, 20);
$pdf->SetFont('helvetica','',9);
$pdf->AddPage();

/* ============ Styles ============ */
$style = '
<style>
  table { border-collapse: collapse; }
  .b  { border:0.5px solid #000; }
  .th { background-color:#d9d9d9; font-weight:bold; text-align:center; }
  .tc { text-align:center; }
  .tl { text-align:left; }
  .label td { padding:1px 2px; }
</style>
';

/* ============ Top labels ============ */
$top = '
<table width="100%" cellpadding="2" cellspacing="0" class="label">
  <tr>
    <td width="18%">Kementerian/ Jabatan:</td><td width="2%">:</td><td></td>
  </tr>
  <tr>
    <td>Bahagian:</td><td>:</td><td></td>
  </tr>
  <tr>
    <td>Nama Stor:</td><td>:</td><td></td>
  </tr>
</table>
';

/* ============ Main table ============ */
$head = '
<table width="100%" cellpadding="4" cellspacing="0">
  
  <tr>
  <td class="th b tc" width="50%" colspan="5">DIISI OLEH PEGAWAI YANG MENYERAHKAN TUGAS</td>
  <td class="th b tc" width="50%" colspan="4">DIISI OLEH PEGAWAI YANG MENGAMBIL ALIH</td>
  </tr>
  <tr>
    <td class="th b tc" width="8%"  rowspan="2">No. Kad<br>Kawalan Stok</td>
    <td class="th b tc" width="21%" rowspan="2">Perihal Stok</td>

    <td class="th b tc" width="21%" colspan="2"><span style="font-weight:normal;"><b>Kuantiti Stok</b></span></td>
    <td class="th b tc" width="21%" colspan="2"><span style="font-weight:normal;"><b>Kuantiti Stok</b></span></td>

    <td class="th b tc" width="29%" rowspan="2">CATATAN</td>
  </tr>

  
  <tr>
    <td class="th b tc" width="7%">Baki di<br>Kad Kawalan Stok</td>
    <td class="th b tc" width="7%">Fizikal<br>Stok</td>
    <td class="th b tc" width="7%">Perbezaan<br>(+/-)</td>

    <td class="th b tc" width="7%">Baki di<br>Kad Kawalan Stok</td>
    <td class="th b tc" width="7%">Fizikal<br>Stok</td>
    <td class="th b tc" width="7%">Perbezaan<br>(+/-)</td>
  </tr>

  <tr>
    <td class="b tc" width="8%"></td>
    <td class="b tc" width="21%"></td>
    <td class="b tc" width="7%"></td>

    <td class="b tc" width="7%"></td>
    <td class="b tc" width="7%"></td>
    <td class="b tc" width="7%"></td>
    <td class="b tc" width="7%"></td>
    <td class="b tc" width="7%"></td>
    <td class="b tc" width="29%"></td>
  </tr>
';

/* Data rows (blank lines) */
$rows = '';
for ($i=0; $i<3; $i++) {
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
  </tr>';
}

/* JUMLAH row */
$rows .= '
  <tr>
    <td class="b th tl" colspan="2" style="text-align:left;">JUMLAH</td>
    <td class="b"></td>
    <td class="b"></td>
    <td class="b"></td>
    <td class="b"></td>
    <td class="b"></td>
    <td class="b"></td>
    <td class="b" style="background-color:#00000;"></td>
  </tr>
</table>
';

/* ============ Signature blocks (left & right) ============ */
$sigTop = '
<table width="100%" cellpadding="6" cellspacing="0" style="margin-top:10px;">
  <tr>
    <td class="b" width="50%" valign="top">
      <b>Tandatangan:</b><br>
      <b>Nama Pegawai:</b><br>
      <b>Nama Jawatan:</b><br>
      <b>Tarikh:</b>
    </td>
    <td class="b" width="50%" valign="top">
      <b>Tandatangan:</b><br>
      <b>Nama Pegawai:</b><br>
      <b>Nama Jawatan:</b><br>
      <b>Tarikh:</b>
    </td>
  </tr>
</table>
';

/* ============ Bottom confirmation + notes ============ */
$confirm = '
<table width="100%" cellpadding="8" cellspacing="0" style="margin-top:8px;">
  <tr>
    <td class="b" width="50%" valign="top">
      <b>DISAHKAN OLEH:</b><br><br>
      ...............................................................<br>
      <span class="tl">(Tandatangan Ketua Jabatan)</span><br><br>
      <table width="100%" cellpadding="2" cellspacing="0">
        <tr><td width="18%">Nama:</td><td></td></tr>
        <tr><td>Jawatan:</td><td></td></tr>
        <tr><td>Tarikh:</td><td></td></tr>
      </table>
    </td>
    <td class="b" width="50%" valign="top">
      <b>ULASAN: (TINDAKAN/ TANPA TINDAKAN)</b><br>
      *TINDAKAN – PELARASAN/ HAPUS KIRA
    </td>
  </tr>
</table>
';

/* ============ Render ============ */
$pdf->writeHTML($style.$top.$head.$rows.$sigTop.$confirm, true, false, true, false, '');
$pdf->Output('kew_ps_16_perakuan_ambil_alih_stor.pdf', 'I');