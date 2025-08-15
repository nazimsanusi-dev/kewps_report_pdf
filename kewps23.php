<?php
require_once __DIR__ . '/tcpdf/tcpdf.php';

class MYPDF extends TCPDF {
  public function Header() {
    // Meta (left / right)
    $this->SetFont('helvetica','',9);
    $this->Cell(0,5,'Pekeliling Perbendaharaan Malaysia',0,0,'L');
    $this->Cell(0,5,'AM 6.9 Lampiran E',0,1,'R');

    // Form code
    $this->SetFont('helvetica','B',12);
    $this->Cell(0,6,'KEW.PS-23',0,1,'R');
    $this->Ln(1);
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
$pdf->SetTitle('KEW.PS-23 – Kenyataan Tawaran Tender Pelupusan Stok');

$pdf->SetMargins(16, 42, 16);
$pdf->SetHeaderMargin(6);
$pdf->SetAutoPageBreak(true, 20);
$pdf->SetFont('helvetica','',12);

/* ---------- Common styles ---------- */
$style = '
<style>
  table { border-collapse: collapse; }
  .b  { border:0.5px solid #000; }
  .th { background-color:#d9d9d9; font-weight:bold; text-align:center; }
  .tc { text-align:center; }
  .tl { text-align:left; }
  .indent { text-indent:22px; text-align:justify; }
  .dot { letter-spacing:2px; }
  .small { font-size:9pt; }
</style>
';

/* =================== PAGE 1 =================== */
$pdf->AddPage();

// Title + No. Tender
$page1 = '
<div style="text-align:right;">No. Tender: <span class="dot">…………………</span></div>
<br>
<div style="text-align:center; font-weight:bold; font-size:13pt;">KENYATAAN TAWARAN TENDER PELUPUSAN STOK</div>
<br>

<table width="100%" cellpadding="2" cellspacing="0">
  <tr>
    <td width="16" valign="top">1.</td>
    <td class="li" style="text-align:justify;">Tender adalah dipelawa kepada pihak yang layak/ berminat untuk membeli Stok seperti berikut:-
    </td>
  </tr>
  <tr><td></td></tr>
</table>
<br>

<!-- Items table -->
<table width="100%" cellpadding="5" cellspacing="0">
  <tr>
    <td class="th b" width="10%">Bil.</td>
    <td class="th b" width="50%">Perihal Stok</td>
    <td class="th b" width="20%">Kuantiti</td>
    <td class="th b" width="20%">Harga Simpanan</td>
  </tr>
  <tr>
    <td class="b tc">1.</td>
    <td class="b"></td>
    <td class="b"></td>
    <td class="b"></td>
  </tr>
  <tr>
    <td class="b tc">2.</td>
    <td class="b"></td>
    <td class="b"></td>
    <td class="b"></td>
  </tr>
  <tr>
    <td class="b tc">3.</td>
    <td class="b"></td>
    <td class="b"></td>
    <td class="b"></td>
  </tr>
</table>

<div class="small" style="margin-top:6px;">* Nota : Bagi yang berkaitan sahaja.</div>
<br>

<table width="180%" cellpadding="2" cellspacing="0">
  <tr><td></td></tr>
  <tr>
    <td width="16" valign="top">2.</td>
    <td class="li">
      Stok boleh dilihat pada <span class="dot">___________</span> hingga <span class="dot">___________</span>
      di antara jam <span class="dot">_________</span> hingga <span class="dot">_________</span> di <span class="dot">_______________________________________________________</span><br><span class="dot">_______________________________________________________</span>.
    </td>
  </tr>
  <tr><td></td></tr>
  <tr><td>3.</td><td class="li">Tender akan ditutup pada <span class="dot">________________</span>, jam 12.00 tengah hari.</td></tr>
  <tr><td></td></tr>
  <tr>
    <td>4.</td>
    <td class="li">Tawaran boleh dibuat dengan menggunakan Borang Tender Pelupusan Stok (KEW.PS-24) yang boleh
      diperoleh di alamat seperti di para 5. Tempoh sah laku tawaran adalah 90 hari bagi tender
      tempatan atau 120 hari bagi tender antarabangsa bermula dari tarikh tender ditutup.
    </td>
  </tr>
  <tr><td></td></tr>
  <tr>
    <td>5.</td>
    <td class="li">Semua tawaran dengan maklumat yang lengkap hendaklah menggunakan sampul berlakri dan
      di tanda dengan No. Tender <span class="dot">___________</span> dan dihantar melalui pos
      atau dimasukkan ke dalam Peti Tender di alamat:
      <br><br>
      <div style="margin-left:24px;">
        <span class="dot">__________________________________________</span><br>
        <span class="dot">__________________________________________</span><br>
        <span class="dot">__________________________________________</span>
      </div>
    </td>
  </tr>
</table>
';

$pdf->writeHTML($style.$page1, true, false, true, false, '');

/* =================== PAGE 2 =================== */
$pdf->AddPage();

$page2 = '
<div style="font-weight:bold;">6. SYARAT-SYARAT DAN PERATURAN TENDER</div>
<br>

<table width="190%" cellpadding="2" cellspacing="0">
  <tr>
    <td width="24" valign="top">6.1</td>
    <td class="li" style="text-align:justify;">Stok akan dijual tertakluk kepada harga simpanan.</td>
  </tr>
  <tr><td></td></tr>
  <tr>
    <td valign="top">6.2</td>
    <td class="li" style="text-align:justify;">Petender adalah dikehendaki menyertakan deposit tender sebanyak 10% daripada harga tawaran bagi
      setiap Stok atau tertakluk kepada maksimum RM10,000. Deposit Tender hendaklah dalam bentuk Wang Pos/
      Draf Bank/ Jaminan Bank atas nama <span class="dot">_________________________</span> (Kementerian atau Jabatan).
    </td>
  </tr>
  <tr><td></td></tr>
  <tr><td valign="top">6.3</td><td class="li">Tawaran tanpa/kurang deposit tender tidak akan dipertimbangkan.</td></tr>
  <tr><td></td></tr>
  <tr>
    <td valign="top">6.4</td>
    <td class="li">Semua Stok adalah dijual sebagaimana keadaannya semasa dilihat (<i>as-is-where-is-basis</i>).</td>
  </tr>
  <tr><td></td></tr>
  <tr><td valign="top">6.5</td><td class="li">Jabatan ini tidak bertanggungjawab ke atas Stok yang telah dijual.</td></tr>
  <tr><td></td></tr>
  <tr>
    <td valign="top">6.6</td>
    <td class="li">Semua perbelanjaan berkaitan pembelian Stok seperti kos menanggul (<i>dismantle</i>), mengangkut,
      cukai duti import dan sebagainya hendaklah ditanggung oleh pembeli sendiri.
    </td>
  </tr>
  <tr><td></td></tr>
  <tr>
    <td valign="top">6.7</td>
    <td class="li">Petender yang berjaya hendaklah membuat pembayaran penuh dalam tempoh 14 hari dari tarikh
      pemberitahuan keputusan. Jika bayaran penuh tidak dijelaskan dalam tempoh 14 hari, deposit
      tender tidak akan dikembalikan.
    </td>
  </tr>
  <tr><td></td></tr>
  <tr>
    <td valign="top">6.8</td>
    <td class="li">Petender yang berjaya hendaklah mengambil Stok dalam tempoh 7 hari selepas bayaran penuh dijelaskan.
      Jika gagal, bayaran yang telah dibuat tidak akan dikembalikan dan Jabatan berhak untuk melupuskan
      Stok tersebut.
    </td>
  </tr>
</table>

<br>
<div class="small"><i>Nota : Syarat-syarat tender boleh dipinda mengikut keperluan Kementerian/Jabatan.</i></div>
';

$pdf->writeHTML($style.$page2, true, false, true, false, '');

$pdf->Output('kew_ps_23_kenyataan_tender_pelupusan_stok.pdf', 'I');
