<?php

namespace App\Controllers\Satpam;

use App\Controllers\BaseController;
use App\Database\DbHelper;
use App\Database\DbHelperSatpam;
use App\Models\M_mitrakerja;
use App\Models\SATPAM\M_laporan;
use App\Models\SATPAM\M_laporantemplate;
use HTML_TO_DOC;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;

class Laporan extends BaseController
{
    protected $dbHelper;
    protected $dbHelperSatpam;

    public function __construct()
    {
        $this->dbHelper = new DbHelper();
        $this->dbHelperSatpam = new DbHelperSatpam();
    }

    public function satpam()
    {
        $dtMitraKerja = $this->dbHelper->getMitraKerja($this->dtAksesMitra);

        $this->dtContent['page'] = "laporan_satpam";
        $this->dtContent['title'] = "LAPORAN SATUAN PENGAMANAN";

        $this->dtContent['dtMitraKerja'] = $dtMitraKerja;

        //Load CSS & JS File
        //CSS & JS SummerNote
        // $appCSS =  loadCSS("summernote/summernote-bs4.css", "plugins");
        // $appJS = loadJS("summernote/summernote-bs4.min.js", "plugins");

        //CSS & JS CkEditor
        $appCSS =  loadCSS("ckeditor_document.css", "appcss");

        $appJS = loadJS("ckeditor5/build/ckeditor.js", "adminlte_plugins");
        $appJS .= loadJS("satpam/laporan_satpam.js", "appjs");

        $this->dtContent['appCSS'] = $appCSS;
        $this->dtContent['appJSFoot'] = $appJS;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function bukumutasi($selCmbDtAkses = null)
    {
        if ($this->hasLogin) {

            $selDtAkses = $this->dtAksesMitra;

            $dbMitrakerja = new M_mitrakerja();
            if ($this->dtAksesMitra == "9999") {
                $dtMitraKerja = $this->dbHelper->getMitraKerja($selDtAkses);

                if (!empty($dtMitraKerja)) {
                    $selDtAkses = $dtMitraKerja[0]['id'];
                } else {
                    $selDtAkses = 0;
                }
            } else {
                $selDtMitrakerja = $dbMitrakerja->getMitraKerja($this->dtAksesMitra);
                $dtMitraKerja = $this->dbHelper->getMitraKerjaForCombo($selDtMitrakerja);
            }

            $this->dtContent['title'] = "Buku Mutasi";
            $this->dtContent['page'] = "laporan_bukumutasi";

            $this->dtContent['dtMitraKerja'] = $dtMitraKerja;
            $this->dtContent['selComboDtAkses'] = $selCmbDtAkses;
        }

        $appJSFoot =  loadJS("satpam/laporan_bukumutasi.js", "appjs");

        $this->dtContent['appJSFoot'] = $appJSFoot;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function bukutamu()
    {
        if ($this->hasLogin) {
            $appCSS = loadCSS('bukutamu.css', 'appcss');

            $appJSFoot =  loadJS('satpam/bukutamu.js', "appjs");

            $selPeriode = "Hari Ini";

            $selDtAkses = $this->dtAksesMitra;

            if ($this->otoritas != "TENAGAKERJA") {
                $selDtAkses = $this->dtAksesMitra;

                $dbMitrakerja = new M_mitrakerja();
                if ($selDtAkses == "9999") {
                    $dtMitraKerja = $this->dbHelper->getMitraKerja($selDtAkses);

                    if (!empty($dtMitraKerja)) {
                        $selDtAkses = $dtMitraKerja[0]['id'];
                    } else {
                        $selDtAkses = 0;
                    }
                } else {
                    $selDtMitrakerja = $dbMitrakerja->getMitraKerja($this->dtAksesMitra);
                    $dtMitraKerja = $this->dbHelper->getMitraKerjaForCombo($selDtMitrakerja);
                }

                if (!empty($dtMitraKerja)) {
                    $selDtAkses = $this->request->getVar("dtakses");
                    $selPeriode = $this->request->getVar("sel_periode");
                    if (is_null($selDtAkses)) {
                        $selDtAkses = $dtMitraKerja[0]['id'];
                    }
                    if (is_null($selPeriode)) {
                        $selPeriode = "Hari Ini";
                    }
                }
                //dd($selPeriode);
                $this->dtContent['selDtAkses'] = $selDtAkses;
                $this->dtContent['dtMitraKerja'] = $dtMitraKerja;
            }

            $dtTamu = $this->dbHelperSatpam->getTamuPerUnit($selPeriode, $selDtAkses);

            $jmlTamuHariIni = $this->dbHelperSatpam->countStatusTamu($selDtAkses, 1, "Hari Ini");
            $jmlTamuKeluar = $this->dbHelperSatpam->countStatusTamu($selDtAkses, 2, "Hari Ini");
            $jmlTamuDidalam = $this->dbHelperSatpam->countStatusTamu($selDtAkses, 1, "Bulan Ini");

            $this->dtContent['appCSS'] = $appCSS;
            $this->dtContent['appJSFoot'] = $appJSFoot;

            $this->dtContent['page'] = "laporan_bukutamu";
            $this->dtContent['title'] = "Buku Tamu";
            $this->dtContent['dtTamu'] = $dtTamu;

            $this->dtContent['jmlTamu'] = $jmlTamuHariIni;
            $this->dtContent['jmlTamuKeluar'] = $jmlTamuKeluar;
            $this->dtContent['jmlTamuDidalam'] = $jmlTamuDidalam;

            $this->dtContent['selPeriode'] = $selPeriode;
        }

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function bukukendaraan()
    {
        if ($this->hasLogin) {
            //CSS for datatable
            $appCSS = loadCSS("https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css");

            $selPeriode = "Hari Ini";

            $selDtAkses = $this->dtAksesMitra;

            $dbMitrakerja = new M_mitrakerja();
            if ($selDtAkses == "9999") {
                $dtMitraKerja = $this->dbHelper->getMitraKerja($selDtAkses);

                if (!empty($dtMitraKerja)) {
                    $selDtAkses = $dtMitraKerja[0]['id'];
                } else {
                    $selDtAkses = 0;
                }
            } else {
                $selDtMitrakerja = $dbMitrakerja->getMitraKerja($this->dtAksesMitra);
                $dtMitraKerja = $this->dbHelper->getMitraKerjaForCombo($selDtMitrakerja);
            }

            if (!empty($dtMitraKerja)) {
                $selDtAkses = $this->request->getVar("dtakses");
                $selPeriode = $this->request->getVar("sel_periode");
                if (is_null($selDtAkses)) {
                    $selDtAkses = $dtMitraKerja[0]['id'];
                }
                if (is_null($selPeriode)) {
                    $selPeriode = "Hari Ini";
                }
            }

            $selPeriode = date("Y-m-d"); //HAPUS jika SelPeriode sudah aktif

            $dtKendaraan = $this->dbHelperSatpam->getKendaraan($selPeriode, $selDtAkses);

            $rekapKendaraan["jmldidalam"] = 0;

            $this->dtContent['page'] = "laporan_bukukendaraan";
            $this->dtContent['title'] = "Keluar Masuk Kendaraan";
            $this->dtContent['appCSS'] = $appCSS;

            $this->dtContent['selDtAkses'] = $selDtAkses;
            $this->dtContent['dtMitraKerja'] = $dtMitraKerja;
            $this->dtContent['selPeriode'] = $selPeriode;

            $this->dtContent['dtKendaraan'] = $dtKendaraan;
            $this->dtContent['dtRekapKendaraan'] = $rekapKendaraan;
        }
        //dd($dtKendaraan);
        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function template()
    {
        $selDtAkses = $this->dtAksesMitra;

        $templateModel = new M_laporantemplate();
        $dtTemplate = $templateModel->getTemplate();

        $this->dtContent['page'] = "laporan_template";
        $this->dtContent['title'] = "TEMPLATE LAPORAN";

        $this->dtContent['dtTemplate'] = $dtTemplate;

        //CSS & JS CkEditor
        $appCSS =  loadCSS("ckeditor_template.css", "appcss");

        $appJS = loadJS("ckeditor5-classic/build/ckeditor.js", "adminlte_plugins");
        $appJS .= loadJS("satpam/laporan_template.js", "appjs");

        $this->dtContent['appCSS'] = $appCSS;
        $this->dtContent['appJSFoot'] = $appJS;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    /**
     * AJAX
     */

    public function ajax_load_laporan_satpam()
    {
        // FOR TEST
        // $mitrakerja_id = 1;
        // $laporan_periode = "2021-11-01";

        $status = "failed";
        $m_laporan = new M_laporan();

        $mitrakerja_id = $this->request->getVar('mitrakerja_id');
        $laporan_periode = $this->request->getVar('periode');

        $find_laporan = $m_laporan->getLaporanByPeriode($mitrakerja_id,  $laporan_periode);

        if (is_null($find_laporan)) {
            $status = "tidak ditemukan";
            $ret_data = [
                'status' => $status,
                'content' => ""
            ];
        } else {
            $status = "success";
            $ret_data = [
                'status' => $status,
                'content' => $find_laporan['content']
            ];
        }

        echo json_encode($ret_data);
    }

    public function ajax_save_laporan_satpam()
    {
        $status = "failed";
        $m_laporan = new M_laporan();

        $laporan_id = $this->request->getVar('laporan_id');
        $mitrakerja_id = $this->request->getVar('mitrakerja_id');
        $laporan_periode = $this->request->getVar('periode');
        $laporan_content = $this->request->getVar('content');

        $data = [
            'periode' => $laporan_periode,
            'content' => $laporan_content,
            'mitrakerja_id' => $mitrakerja_id,
            'created_by' => $this->dtUser['id']
        ];

        //cek for insert or update database
        if ($laporan_id != "") {
            $data['id'] = $laporan_id;
        } else {
            $find_laporan = $m_laporan->getLaporanByPeriode($mitrakerja_id,  $laporan_periode);
            if (!empty($find_laporan)) {
                $data['id'] = $find_laporan['id'];
            }
        }

        $simpan = $m_laporan->save($data);
        if ($simpan) {
            $status = "success";
        }

        $ret_data = [
            'status' => $status
        ];
        echo json_encode($ret_data);
    }

    public function load_template_laporan_satpam_by_ajax()
    {
        $templateModel = new M_laporantemplate();
        $template = $templateModel->getTemplate(1);

        if (empty($template)) {
            $status = "Template tidak ditemukan";
        } else {
            $status = "success";
        }

        $ret_data = [
            'status' => $status,
            'content' => $template['content']
        ];

        echo json_encode($ret_data);
    }

    public function ajax_save_template_laporan_satpam()
    {
        $status = "failed";
        $m_laporan_template = new M_laporantemplate();

        //$template_id = $this->request->getVar('template_id');
        $template_id = 1;
        $template_content = $this->request->getVar('content');

        $data = [
            'content' => $template_content,
        ];

        //cek for insert or update database
        if ($template_id != "") {
            $data['id'] = $template_id;
        } else {
            $find_laporan = $m_laporan_template->getLaporan($template_id);
            if (!empty($find_laporan)) {
                $data['id'] = $find_laporan['id'];
            }
        }

        $simpan = $m_laporan_template->save($data);
        if ($simpan) {
            $status = "success";
        }

        $ret_data = [
            'status' => $status
        ];
        echo json_encode($ret_data);
    }

    public function ajax_get_bukumutasi_satpam()
    {
        $mitrakerja_id = $this->request->getVar("data_id");

        $dbMitrakerja = new M_mitrakerja();
        $selDtMitrakerja = $dbMitrakerja->getMitraKerja($mitrakerja_id);

        $periode = $this->request->getVar("periode");

        $listBukuMutasi = $this->dbHelperSatpam->getBukuMutasiByMitraKerja($selDtMitrakerja, $periode)->getResult();

        //dd($listBukuMutasi);
        $data = array();
        $no = 0;

        foreach ($listBukuMutasi as $bukuMutasi) {
            $row_id = $bukuMutasi->id;

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $bukuMutasi->tanggal;
            $row[] = $bukuMutasi->shift;
            $row[] = $bukuMutasi->jam_dinas;
            $row[] = $bukuMutasi->petugas;
            $row[] = $bukuMutasi->mitrakerja;
            $row[] = $bukuMutasi->status;

            $action = "<a href='/laporanbukumutasidetail/$row_id' class='btn btn-success btn-sm' data-toggle='tooltip' data-placement='top' title='Detail'><i class='fa fa-book'></i> Detail</a>";

            $row[] = $action;

            $data[] = $row;
        }
        echo json_encode($data);
    }

    // END AJAX

    /**
     * EXPORT LAPORAN
     */
    public function export_to_word()
    {
        //echo $HTMLContentToDoc;
        $templateModel = new M_laporantemplate();
        $template = $templateModel->getTemplate(1);
        $HTMLContentToDoc = $template['content'];

        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        $section = $phpWord->addSection();

        $htd = new HTML_TO_DOC();

        $htd->createDoc($HTMLContentToDoc, "my-document");

        // // Saving the document as OOXML file...
        // \PhpOffice\PhpWord\Shared\Html::addHtml($section, $HTMLContentToDoc, false, false);
        // $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

        // $objWriter->save('downloads/helloWorld.docx');
        $data = ['status' => "succes"];
        echo json_encode($data);
    }

    public function export_to_pdf()
    {
        //echo $HTMLContentToDoc;
        $templateModel = new M_laporantemplate();
        $template = $templateModel->getTemplate(1);
        $HTMLContentToDoc = $template['content'];

        $pdfFilePath = "downloads/filepdf.pdf";

        $mPDF = new \Mpdf\Mpdf();
        $mPDF->WriteHTML($HTMLContentToDoc);
        $mPDF->Output($pdfFilePath, 'f');

        $data = ['status' => "succes"];
        echo json_encode($data);
    }

    public function export_buku_mutasi()
    {
        $mitrakerja_id = $this->request->getVar("dtakses");
        $periode = $this->request->getVar("periode");

        // $mitrakerja_id = "13";
        // $periode = "2022-03-01";

        $periodeBln = strtoupper(ambil_bulan_tahun($periode));

        $dbMitrakerja = new M_mitrakerja();
        $dtMitrakerja = $dbMitrakerja->getMitraKerja($mitrakerja_id);

        $dtBukuMutasi = $this->dbHelperSatpam->getBukuMutasiByMitraKerja($dtMitrakerja, $periode, "ASC")->getResult();
        //dd($dtBukuMutasi);
        $jmlBukuMutasi = count($dtBukuMutasi);

        /* GET DETAIL BUKU MUTASI */
        //$dt_petugas_piket = null;
        $dt_inventaris = null;
        $dt_kegiatan  = null;

        $nm_mitrakerja = $dtBukuMutasi[0]->mitrakerja;

        $dt_mutasi = $this->dbHelperSatpam->getBukuMutasi($dtBukuMutasi[0]->id);

        $blnThn = ambil_angka_bulan_tahun($periode);
        $folderMK = addZeroSpaces($dt_mutasi['mitrakerja_id'], "mk", 5);
        $pathFotoKegiatan = "./uploads/$this->appName/$folderMK/$blnThn/kegiatan/";

        /* END GET DETAIL BUKU MUTASI */

        $inputFileName = 'templates/laporan/satpam_bukumutasi.xlsx';
        $outputFileName = $nm_mitrakerja . ' - BUKU MUTASI - ' . $periodeBln . '.xls';
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
        /*  ISI SHEET BUKU MUTASI  */
        //clone sheet for all buku mutasi        
        for ($i = 1; $i < $jmlBukuMutasi; $i++) {
            $clonedWorksheet = clone $spreadsheet->getSheetByName('BM_01');
            $nm_sheet = "BM_" . addZeroSpaces(($i + 1), "", 2);

            $clonedWorksheet->setTitle($nm_sheet);
            $spreadsheet->addSheet($clonedWorksheet);
        }

        /* add data to sheet for every bukumutasi */
        $nourut = 1;
        //dd($dt_petugas_piket);
        foreach ($dtBukuMutasi as $bukumutasi) {
            $dt_mutasi = $this->dbHelperSatpam->getBukuMutasi($bukumutasi->id);
            //$dt_petugas_piket = $this->dbHelperSatpam->getPetugasBukuMutasi($dt_mutasi['id']);
            $dt_inventaris = $this->dbHelperSatpam->getInventarisBukuMutasi($dt_mutasi['id']);
            $dt_kegiatan  = $this->dbHelperSatpam->getKegiatanBukuMutasi($dt_mutasi['id']);

            $s_nourut = addZeroSpaces($nourut, "", 2);
            //set active sheet
            $worksheet = $spreadsheet->setActiveSheetIndexByName('BM_' . $s_nourut);

            //konversi tanggal ke format ex. "Senin, 14 Maret 2022"
            $tanggal = waktu($bukumutasi->tanggal);

            $worksheet->getCell('A2')->setValue("UNIT KERJA : " . $bukumutasi->mitrakerja);

            $worksheet->getCell('C4')->setValue($nourut);
            $worksheet->getCell('C5')->setValue($tanggal);
            $worksheet->getCell('C6')->setValue($bukumutasi->shift);
            $worksheet->getCell('C7')->setValue($bukumutasi->jam_dinas);

            //isi petugas
            $exPetugas = explode(",", $bukumutasi->petugas);
            $nrow = 8;
            $no = 1;
            foreach ($exPetugas as $petugas) {
                if ($no < 5) {
                    $worksheet->getCell('C' . $nrow)->setValue($no . ". " . trim($petugas));
                } else {
                    if ($nrow > 11) {
                        $nrow = 8;
                    }
                    $worksheet->getCell('F' . $nrow)->setValue($no . ". " . trim($petugas));
                }
                $nrow++;
                $no++;
            }

            //isi inventaris
            $nrow = 15;
            if (!empty($dt_inventaris)) {
                $jmlInventaris = count($dt_inventaris);
                $no_inv = 1;
                foreach ($dt_inventaris as $dtinventaris) {
                    $worksheet->getCell('A' . $nrow)->setValue($no_inv);
                    $worksheet->getCell('B' . $nrow)->setValue(strtoupper($dtinventaris['barang']));
                    $worksheet->getCell('F' . $nrow)->setValue($dtinventaris['jumlah']);
                    $worksheet->getCell('G' . $nrow)->setValue($dtinventaris['kondisi']);
                    $worksheet->getCell('H' . $nrow)->setValue($dtinventaris['keterangan']);

                    $nrow++;
                    $no_inv++;

                    if ($no_inv <= $jmlInventaris) {
                        $worksheet->insertNewRowBefore($nrow, 1);
                        $worksheet->mergeCells('B' . $nrow . ':E' . $nrow);
                        $worksheet->mergeCells('H' . $nrow . ':I' . $nrow);
                    }
                }
                $nrow = $nrow - 1;
            }
            //dd($bukumutasi->petugas);

            $nrow = $nrow + 4;
            $no = 1;

            $sheet = $spreadsheet->getActiveSheet();
            $jmlkegiatan = count($dt_kegiatan);
            foreach ($dt_kegiatan as $rowData) {
                $worksheet->getCell('A' . $nrow)->setValue($no);
                $worksheet->getCell('B' . $nrow)->setValue($rowData['tanggal']);
                $worksheet->getCell('D' . $nrow)->setValue($rowData['jenis']);
                $worksheet->getCell('E' . $nrow)->setValue($rowData['lokasi']);

                //$worksheet->getCell('F' . $nrow)->setValue($rowData['foto']);
                $foto_kegiatan = $pathFotoKegiatan . $rowData['foto'];

                if (isset($foto_kegiatan) && !empty($foto_kegiatan)) {
                    if (file_exists($foto_kegiatan)) {
                        $imageType = "png";

                        if (strpos($foto_kegiatan, ".png") === false) {
                            $imageType = "jpg";
                        }

                        $drawing = new MemoryDrawing();

                        $sheet->getRowDimension($nrow)->setRowHeight(70);
                        //$sheet->mergeCells('A' . $nrow . ':H' . $nrow);

                        $gdImage = ($imageType == 'png') ? imagecreatefrompng($foto_kegiatan) : imagecreatefrompng($foto_kegiatan);
                        $drawing->setName('Company Logo');
                        $drawing->setDescription('Company Logo image');
                        $drawing->setResizeProportional(false);
                        $drawing->setImageResource($gdImage);
                        $drawing->setRenderingFunction(\PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing::RENDERING_JPEG);
                        $drawing->setMimeType(\PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing::MIMETYPE_DEFAULT);
                        $drawing->setWidth(80);
                        $drawing->setHeight(80);
                        $drawing->setOffsetX(5);
                        $drawing->setOffsetY(5);
                        $drawing->setCoordinates('F' . $nrow);
                        $drawing->setWorksheet($spreadsheet->getActiveSheet());
                    } else {
                        $worksheet->getCell('F' . $nrow)->setValue("NO FOTO");
                    }
                } else {
                    $worksheet->getCell('F' . $nrow)->setValue("NO FOTO");
                }

                $worksheet->getCell('G' . $nrow)->setValue($rowData['kondisi']);
                $worksheet->getCell('H' . $nrow)->setValue($rowData['keterangan']);
                $worksheet->getCell('I' . $nrow)->setValue($rowData['petugas']);
                $no++;
                $nrow++;
                if ($no <= $jmlkegiatan) {
                    $worksheet->insertNewRowBefore($nrow, 1);
                    $worksheet->mergeCells('B' . $nrow . ':C' . $nrow);
                }
            }

            $nourut++;
        }

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $outputFileName . '"');
        $writer->save('php://output');
        exit();
    }
}
