<?php
require_once __DIR__ . '/tcpdf/tcpdf.php';

class MYPDF extends TCPDF {
  public function Header() {
    // Meta (left/right)
    $this->SetFont('helvetica','',9);
    $this->Cell(0,5,'Pekeliling Perbendaharaan Malaysia',0,0,'L');
    $this->Cell(0,5,'AM 6.9 Lampiran H',0,1,'R');

    // Form code
    $this->SetFont('helvetica','B',12);
    $this->Cell(0,6,'KEW.PS-26',0,1,'R');

    // No. Sebut harga
    $this->SetFont('helvetica','',10);
    $this->Cell(0,5,'No. Sebut harga :  ______________________',0,1,'R');
    $this->Ln(2);
  }
  public function Footer() {
    $this->SetY(-14);
    $this->SetFont('helvetica','I',8);
    $this->Cell(0,10,'Page '.$this->getAliasNumPage().' / '.$this->getAliasNbPages(),0,0,'C');
  }
}

$pdf = new MYPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('NAZIMSAN');
$pdf->SetTitle('KEW.PS-26 – Kenyataan Tawaran Sebut Harga Pelupusan Stok');

$pdf->SetMargins(16, 35, 16);
$pdf->SetHeaderMargin(6);
$pdf->SetAutoPageBreak(true, 20);
$pdf->SetFont('helvetica','',10);
$pdf->AddPage();

/* ---------------- Styles ---------------- */
$style = '
<style>
  table { border-collapse: collapse; }
  .b  { border:0.5px solid #000; }
  .th { background-color:#d9d9d9; font-weight:bold; text-align:center; }
  .tc { text-align:center; }
  .tl { text-align:left; }
  .dot{ letter-spacing:0px; }
  .small{ font-size:9pt; }
  .indent { text-indent:22px; text-align:justify; }
</style>
';

/* ---------------- Title ---------------- */
$title = '
<div style="text-align:center; font-weight:bold; font-size:13pt;">KENYATAAN TAWARAN SEBUT HARGA</div>
<div style="text-align:center; font-weight:bold;">PELUPUSAN STOK</div>
<br>
<table width="100%" cellpadding="2" cellspacing="0">
  <tr><td width="28%">Kementerian atau Jabatan:</td><td class="dot">______________________</td></tr>
  <tr><td></td><td class="dot">______________________</td></tr>
  <tr><td></td><td class="dot">______________________</td></tr>
</table>
<br>
';

$spacing = '<tr><td></td></tr>';

/* ---------------- Paragraph 1 + table ---------------- */
$p1 = '
<table width="195%" cellpadding="2" cellspacing="0">
  <tr>
    <td width="16" valign="top">1.</td>
    <td class="li" style="text-align:justify;">
      Tawaran adalah dipelawa dari syarikat atau orang perseorangan yang berminat untuk membeli Stok seperti berikut:-
    </td>
  </tr>
</table>
<br>
<br>

<table width="100%" cellpadding="5" cellspacing="0">
  <tr>
    <td class="th b" width="10%">Bil.</td>
    <td class="th b" width="50%">Perihal Stok</td>
    <td class="th b" width="20%">Kuantiti</td>
    <td class="th b" width="20%">Harga Simpanan</td>
  </tr>
  <tr><td class="b tc">1.</td><td class="b"></td><td class="b"></td><td class="b"></td></tr>
  <tr><td class="b tc">2.</td><td class="b"></td><td class="b"></td><td class="b"></td></tr>
  <tr><td class="b tc">3.</td><td class="b"></td><td class="b"></td><td class="b"></td></tr>
</table>
<div class="small" style="margin-top:6px;">* Nota : Bagi yang berkaitan sahaja.</div>
<br>
';

/* ---------------- Paragraphs 2–5 ---------------- */
$p2_5 = '
<table width="195%" cellpadding="2" cellspacing="0">
  <tr>
    <td width="16" valign="top">2.</td>
    <td class="indent">
      Stok boleh dilihat pada <span class="dot">________________</span> dan/hingga
      <span class="dot">________________</span> di antara jam <span class="dot">____________</span>
      hingga <span class="dot">____________</span> di <span class="dot">_______________________________</span>.
    </td>
  </tr>
  <tr><td></td></tr>
  <tr>
    <td valign="top">3.</td>
    <td class="indent">
      Tawaran sebut harga boleh dibuat dengan menggunakan Borang Sebut Harga Pelupusan Stok (KEW.PS-27) yang boleh
      diperolehi di alamat seperti di para 4. Tawaran hendaklah sah bagi tempoh 90 hari.
    </td>
  </tr>
  <tr><td></td></tr>
  <tr>
    <td valign="top">4.</td>
    <td class="indent">
      Semua tawaran dengan maklumat yang lengkap hendaklah menggunakan sampul surat berlakri dan di tanda
      No. Sebut harga <span class="dot">________</span> / <span class="dot">________</span> dan dihantar melalui pos
      atau dimasukkan ke dalam Peti Sebut harga di alamat: <br>
      <div style="margin-left:24px;">
        <span class="dot">___________________________________________</span><br>
        <span class="dot">___________________________________________</span><br>
        <span class="dot">___________________________________________</span>
      </div>
    </td>
  </tr>
  <tr><td></td></tr>
  <tr>
    <td valign="top">5.</td>
    <td class="indent">
      Tarikh tutup sebut harga pada <span class="dot">________________</span> jam 12.00 tengah hari. Sebut harga yang
      diterima lewat tidak akan dipertimbangkan.
    </td>
  </tr>
</table>
<br><br>
';

/* ---------------- Signature block ---------------- */
$sign = '
<tr><td></td></tr><tr><td></td></tr>
<table width="80%" cellpadding="3" cellspacing="0">
  <tr><td class="dot">_________________________</td></tr>
  <tr><td class="small"><i>(Tandatangan Ketua Jabatan)</i></td></tr>
</table>
<br>
<br>
<table width="80%" cellpadding="3" cellspacing="0">
  <tr><td width="18%">Alamat:</td><td class="dot">_________________________</td></tr>
  <tr><td></td><td class="dot">_________________________</td></tr>
  <tr><td></td><td class="dot">_________________________</td></tr>
  <tr><td>Tarikh:</td><td class="dot">_________________________</td></tr>
  <tr><td>Cap:</td><td class="dot">_________________________</td></tr>
</table>
';

// ----------------- PAGE 2: Syarat & Peraturan Sebut Harga -----------------

$page2 = '
<style>
  .title { font-weight:bold; font-size:12pt; }
  .indent { text-align: justify; line-height: 1.6; }          /* each paragraph uses this */
  .no     { width:16px; }                                      /* numbering column */
  .dot { display:inline-block; border-bottom:0.5px solid #000; min-width:120px; }
  .note { font-size:9pt; }
  table { border-collapse: collapse; }
</style>


<div class="title">SYARAT DAN PERATURAN SEBUT HARGA</div>
<br>

<!-- Numbered paragraphs: make sure each <td> with text has class="indent" -->
<table width="195%" cellpadding="2" cellspacing="0" border="0">
  <tr>
    <td class="no" valign="top">1.</td>
    <td class="indent">Stok akan dijual tertakluk kepada harga simpanan.
    </td>
  </tr>
  <tr><td height="6"></td><td></td></tr>

  <tr>
    <td class="no" valign="top">2.</td>
    <td class="indent">Penyebut harga adalah dikehendaki menyertakan deposit sebut harga sebanyak 5% daripada harga tawaran bagi setiap Stok atau RM5,000 mengikut mana yang terendah. Deposit sebut harga hendaklah dalam bentuk Wang Pos atau Draf Bank sahaja atas nama <span class="dot">&nbsp;</span> (Kementerian atau Jabatan).
    </td>
  </tr>
  <tr><td height="6"></td><td></td></tr>

  <tr>
    <td class="no" valign="top">3.</td>
    <td class="indent">Tawaran tanpa/kurang deposit sebut harga tidak akan dipertimbangkan.</td>
  </tr>
  <tr><td height="6"></td><td></td></tr>

  <tr>
    <td class="no" valign="top">4.</td>
    <td class="indent">Semua Stok adalah dijual sebagaimana keadaannya semasa dilihat (<i>as-is-where-is basis</i>).
    </td>
  </tr>
  <tr><td height="6"></td><td></td></tr>

  <tr>
    <td class="no" valign="top">5.</td>
    <td class="indent">Jabatan ini tidak bertanggungjawab ke atas Stok yang telah dijual.</td>
  </tr>
  <tr><td height="6"></td><td></td></tr>

  <tr>
    <td class="no" valign="top">6.</td>
    <td class="indent">Semua perbelanjaan berkaitan pembelian Stok seperti kos menanggah (<i>dismantle</i>), mengangkut, cukai duti import dan sebagainya hendaklah ditanggung oleh pembeli sendiri.
    </td>
  </tr>
  <tr><td height="6"></td><td></td></tr>

  <tr>
    <td class="no" valign="top">7.</td>
    <td class="indent">Pembeli yang berjaya hendaklah membuat pembayaran penuh dalam tempoh satu (1) minggu dari tarikh diberitahu keputusan. Jika bayaran tidak dijelaskan dalam tempoh tersebut, deposit sebut harga tidak akan dikembalikan.
    </td>
  </tr>
  <tr><td height="6"></td><td></td></tr>

  <tr>
    <td class="no" valign="top">8.</td>
    <td class="indent">Pembeli yang berjaya hendaklah mengambil Stok dalam tempoh 7 hari selepas bayaran penuh dijelaskan. Jika gagal, bayaran yang telah dibuat tidak akan dikembalikan dan Jabatan berhak untuk melupuskan Stok tersebut.
    </td>
  </tr>
</table>

<br><br>

<div class="note">Nota : Syarat-syarat sebutharga boleh dipinda mengikut keperluan Kementerian/Jabatan.</div>
';


$pdf->writeHTML($style.$title.$spacing.$p1.$p2_5.$sign, true, false, true, false, '');
$pdf->AddPage(); // start a brand-new full-width page
$pdf->writeHTML($page2, true, false, true, false, '');
$pdf->Output('kew_ps_26_kenyataan_sebut_harga.pdf', 'I');
