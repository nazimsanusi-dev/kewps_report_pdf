<?php
require_once __DIR__ . '/tcpdf/tcpdf.php';

class MYPDF extends TCPDF {
  public function Header() {
    // Top meta
    $this->SetFont('helvetica','',9);
    $this->Cell(0,5,'Pekeliling Perbendaharaan Malaysia',0,0,'L');
    $this->Cell(0,5,'AM 6.9 Lampiran D',0,1,'R');

    // Form code
    $this->SetFont('helvetica','B',12);
    $this->Cell(0,6,'KEW.PS-22',0,1,'R');

    // Title
    $this->Ln(2);
    $this->SetFont('helvetica','B',12.5);
    $this->Cell(0,7,'SIJIL PELUPUSAN STOK',0,1,'C');
    $this->SetFont('helvetica','',10);
    $this->Cell(0,5,'(Diisi oleh Jabatan yang melaksanakan pelupusan)',0,1,'C');
    $this->Ln(2);
  }
  public function Footer() {
    // Bottom center code
    $this->SetY(-12);
    $this->SetFont('helvetica','',9);
    $this->Cell(0,8,'M.S. 35/49',0,0,'C');
  }
}

$pdf = new MYPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('NAZIMSAN');
$pdf->SetTitle('KEW.PS-22 – Sijil Pelupusan Stok');

$pdf->SetMargins(18, 48, 18);
$pdf->SetHeaderMargin(6);
$pdf->SetAutoPageBreak(true, 18);
$pdf->SetFont('helvetica','',10);
$pdf->AddPage();

/* ---------- Styles ---------- */
$style = '
<style>
  table { border-collapse: collapse; }
  .small { font-size:9pt; }
  .dot { letter-spacing:2px; }      /* dotted leaders */
  .indent { text-indent:24px; text-align:justify; }
  .li-num { width:20px; vertical-align:top; }
  .li-text { text-align:justify; }
</style>
';

/* ---------- Opening paragraph ---------- */
$open = '
<p class="indent">
Merujuk surat kelulusan No. Rujukan <span class="dot">...............................</span> bertarikh
<span class="dot">...............................</span>, saya mengesahkan tindakan pelupusan telah dilaksanakan
mengikut kaedah berikut:-
</p>
';

/* ---------- Numbered methods (1–7) ---------- */
$items = '
<table width="200%" border="0" cellpadding="2" cellspacing="0">
  <tr><td></td></tr>
  <!-- 1 -->
  <tr>
    <td class="li-num">1.</td>
    <td class="li-text"><b>Jualan (Tender/ Sebut Harga/ Lelong)</b><br>Bilangan item <span class="dot">..........</span>. No. Resit <span class="dot">...........................................</span>
      (salinan resit disertakan)
    </td>
  </tr>

  <tr><td></td></tr>

  <!-- 2 -->
  <tr>
    <td class="li-num">2.</td>
    <td class="li-text"><b>Buangan Terjadual (E-Waste/ Sisa Pepejal)</b><br>Bilangan item <span class="dot">..........</span>. Ruj. Surat/No. Resit <span class="dot">.......................</span>
      (Surat akuan/salinan resit disertakan)
    </td>
  </tr>

  <tr><td></td></tr>

  <!-- 3 -->
  <tr>
    <td class="li-num">3.</td>
    <td class="li-text"><b>Jualan Sisa (Tender/ Sebut Harga/ Jualan Terus)</b><br>Bilangan item <span class="dot">..........</span>. No. Resit <span class="dot">...........................................</span>
      (salinan resit disertakan)
    </td>
  </tr>

  <tr><td></td></tr>

  <!-- 4 -->
  <tr>
    <td class="li-num">4.</td>
    <td class="li-text"><b>Tukar Ganti/ Tukar Beli/ Tukar Barang/Perkhidmatan</b><br>Bilangan item <span class="dot">...............</span> (Dokumen berkaitan disertakan) Stok/ Komponen berikut telah direkodkan.<br>Bilangan item <span class="dot">.......................</span>. No. Rekod <span class="dot">.......................</span>(Salinan rekod dilampirkan)
    </td>
  </tr>

  <tr><td></td></tr>

  <!-- 5 -->
  <tr>
    <td class="li-num">5.</td>
    <td class="li-text"><b>Hadiah/ Serahan</b>.<br>Bilangan item <span class="dot">..........</span> dihadiahkan/ diserahkan kepada <span class="dot">........................</span>
      (Surat Akuan Terima disertakan)
    </td>
  </tr>

  <tr><td></td></tr>

  <!-- 6 -->
  <tr>
    <td class="li-num">6.</td>
    <td class="li-text"><b>Musnah (Tanam/ Bakar/ Buang/ Tenggelam/ Letup/ Ledak/ Lebur)*</b>.<br>Bilangan item <span class="dot">.......................</span> (Sijil Penyaksian Pemusnahan disertakan)
    </td>
  </tr>

  <tr><td></td></tr>

  <!-- 7 -->
  <tr>
    <td class="li-num">7.</td>
    <td class="li-text"><b>Kaedah-Kaedah Lain.</b><br>Bilangan item <span class="dot">.......................</span>
    </td>
  </tr>
</table>
';

/* ---------- Signature block ---------- */
$sign = '
<br>
<table width="100%" cellpadding="3" cellspacing="0">
  <tr><td></td></tr>
  <tr><td></td></tr>
  <tr><td></td></tr>
  <tr><td>......................................................</td></tr>
  <tr>
    <td class="small" width="40%"><i>*Tandatangan Ketua Jabatan</i></td>
    <td width="60%"></td>
  </tr>
</table>

<table width="100%" cellpadding="3" cellspacing="0">
  <tr><td width="30%">Nama</td><td width="3%">:</td><td class="dot">.................................</td></tr>
  <tr><td>Jawatan</td><td>:</td><td class="dot">.................................</td></tr>
  <tr><td>Tarikh</td><td>:</td><td class="dot">.................................</td></tr>
  <tr><td>Nama Kementerian / Jabatan</td><td>:</td><td class="dot">.................................</td></tr>
</table>

<br>
<table width="100%" cellpadding="2" cellspacing="0">
  <tr><td></td></tr>
  <tr>
    <td class="small"><i>Nota : Tanda tangan Ketua Jabatan boleh ditandatangani oleh Ketua Jabatan/Bahagian/Seksyen/Unit</i></td>
  </tr>
</table>
';

$pdf->writeHTML($style.$open.$items.$sign, true, false, true, false, '');
$pdf->Output('kew_ps_22_sijil_pelupusan_stok.pdf', 'I');
