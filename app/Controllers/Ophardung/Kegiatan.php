<?php

namespace App\Controllers\Ophardung;

use App\Controllers\BaseController;
use App\Database\DbHelper;
use App\Database\DbHelperOphardung;
use App\Models\M_mitrakerja;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;

class Kegiatan extends BaseController
{

    protected $dbHelper;
    protected $dbHelperOphardung;

    protected $dbMitrakerja;

    public function __construct()
    {
        $this->dbHelper = new DbHelper();
        $this->dbHelperOphardung = new DbHelperOphardung();

        $this->dbMitrakerja = new M_mitrakerja();
    }

    public function index()
    {
        if ($this->hasLogin) {
            if ($this->otoritas != "TENAGAKERJA") {

                $selDtAkses = $this->dtAksesMitra;
                $selComboDtAkses = $this->request->getVar("dtakses");

                $dtMitraKerja = $this->dbHelper->getMitraKerja($selDtAkses);

                if (is_null($selComboDtAkses)) {
                    $selComboDtAkses = $dtMitraKerja[0]['id'];
                }

                $selPeriode = $this->request->getVar('periode');
                $aksi = $this->request->getVar('cmdaksi');

                $selPeriode = (is_null($selPeriode)) ? date("Y-m-1") : $selPeriode;
                $aksi = (is_null($aksi)) ? 'rekapitulasi' : $aksi;

                if ($aksi == "export_kegiatan_ophar_to_xls") {
                    $this->export_kegiatan_ophardung($selComboDtAkses, $selPeriode);
                    return;
                }

                $pathFotoKegiatan = $this->pathUploadImgApp . "/kegiatan/";

                $this->dtContent['page'] = "ophardung_kegiatan";
                $this->dtContent['title'] = "Kegiatan";

                $this->dtContent['dtMitraKerja'] = $dtMitraKerja;

                $this->dtContent['selDtAkses'] = $selComboDtAkses;
                $this->dtContent['selPeriode'] = $selPeriode;

                $appCSS = loadCSS("kegiatan.css", "appcss");
                $appJSFoot = loadJS("ophardung/bukukegiatan.js", "appjs");

                $this->dtContent['appCSS'] = $appCSS;
                $this->dtContent['appJSFoot'] = $appJSFoot;

                $this->dtContent['pathFotoKegiatan'] = $pathFotoKegiatan;
            }
        }

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function kegiatanperpetugas()
    {
        $keyData = $this->request->getVar("key_data");

        if ($this->hasLogin) {
            if ($this->otoritas != "TENAGAKERJA") {
                $expKeyData = explode("|", $keyData);

                $petugas_id = $expKeyData[0];
                $tanggal = $expKeyData[1];
                $mitrakerja_id = $expKeyData[2];
                $periode = $expKeyData[3];

                $dtKegiatan = $this->dbHelperOphardung->getKegiatanPetugasPerTanggal($petugas_id, $tanggal);

                //dd($dtKegiatan);
                //dd($periode);

                $blnThn = ambil_angka_bulan_tahun($periode);
                $folderMK = addZeroSpaces($mitrakerja_id, "mk", 5);
                $pathFotoKegiatan = "./uploads/$this->appName/$folderMK/$blnThn/kegiatan/";

                $this->dtContent['page'] = "ophardung_kegiatanperpetugas";
                $this->dtContent['title'] = "Kegiatan";

                $this->dtContent['dtKegiatan'] = $dtKegiatan;

                $appCSS = loadCSS("kegiatan.css", "appcss");
                $appJSFoot = loadJS("ophardung/bukukegiatan_tenagakerja.js", "appjs");

                $this->dtContent['appCSS'] = $appCSS;
                $this->dtContent['appJSFoot'] = $appJSFoot;

                $this->dtContent['mitrakerja_id'] = $mitrakerja_id;
                $this->dtContent['periode'] = $periode;

                $this->dtContent['pathFotoKegiatan'] = $pathFotoKegiatan;
            }
        }

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function export_kegiatan_ophardung($mitrakerja_id, $periode)
    {
        $periodeBln = strtoupper(ambil_bulan_tahun($periode));

        $dbMitrakerja = new M_mitrakerja();
        $dtMitrakerja = $dbMitrakerja->getMitraKerja($mitrakerja_id);

        /* GET REKAP KEGIATAN OPHARDUNG */
        $nm_mitrakerja = $dtMitrakerja['mitrakerja'];
        /* END GET REKAP KEGIATAN */

        // path photo kegiatan
        $blnThn = ambil_angka_bulan_tahun();
        $folderMK = addZeroSpaces($mitrakerja_id, "mk", 5);
        $pathFotoKegiatan = "./uploads/$this->appName/$folderMK/$blnThn/kegiatan/";

        //load template

        $inputFileName = 'templates/laporan/ophardung_kegiatan_unit_induk.xlsx';

        $outputFileName = $nm_mitrakerja . ' - LAPORAN OPHARDUNG - ' . $periodeBln . '.xls';
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);

        /* Isi Tabel REKAP */
        $dtRekapKegiatan = $this->dbHelperOphardung->getRekapKegiatanMitrakerja($dtMitrakerja, $periode)->getResultArray();
        $jmlRekapKegiatan = count($dtRekapKegiatan);

        $worksheet = $spreadsheet->setActiveSheetIndexByName('REKAP');

        $worksheet->getCell('A2')->setValue("MITRA KERJA : " . $nm_mitrakerja);
        $worksheet->getCell('A3')->setValue("BULAN : " . $periodeBln);

        $nourut = 1;
        $nrow = 6;
        foreach ($dtRekapKegiatan as $rekap) {
            if ($dtMitrakerja["induk_id"] == 1 || $dtMitrakerja["induk_id"] == 2) {
                $worksheet->getCell('A' . $nrow)->setValue($nourut);
                $worksheet->getCell('B' . $nrow)->setValue(strtoupper($rekap['mitrakerja']));
                $worksheet->getCell('C' . $nrow)->setValue(strtoupper($rekap['petugas']));
                $worksheet->getCell('D' . $nrow)->setValue($rekap['tgl_kegiatan']);
                $worksheet->getCell('E' . $nrow)->setValue($rekap['jml_kegiatan']);
            } else {
                $worksheet->getCell('A' . $nrow)->setValue($nourut);
                $worksheet->getCell('B' . $nrow)->setValue(strtoupper($rekap['petugas']));
                $worksheet->getCell('C' . $nrow)->setValue($rekap['tgl_kegiatan']);
                $worksheet->getCell('D' . $nrow)->setValue($rekap['jml_kegiatan']);
            }

            $nrow++;
            $nourut++;
            if ($nourut <= $jmlRekapKegiatan) {
                $worksheet->insertNewRowBefore($nrow, 1);
            }
        }

        /* Isi Tabel Inventori */
        $worksheet = $spreadsheet->setActiveSheetIndexByName('INVENTORI');

        $worksheet->getCell('A2')->setValue("MITRA KERJA : " . $nm_mitrakerja);
        $worksheet->getCell('A3')->setValue("BULAN : " . $periodeBln);

        $dt_inventori = $this->dbHelperOphardung->getInventoriByMitrakerja($dtMitrakerja);
        // dd($dt_inventori);
        $jml_inventori = count($dt_inventori);
        $nourut = 1;
        $noinv = 1;
        $nrow = 6;
        $pre_inv_mitrakerja = "";
        foreach ($dt_inventori as $inventori) {

            if ($pre_inv_mitrakerja != $inventori['mitrakerja']) {
                $worksheet->getCell('A' . $nrow)->setValue($nourut);
                $worksheet->getCell('B' . $nrow)->setValue($inventori['mitrakerja']);
                $nourut++;
            }
            $worksheet->getCell('C' . $nrow)->setValue(strtoupper($inventori['produk']));
            $worksheet->getCell('D' . $nrow)->setValue($inventori['jumlah']);
            $worksheet->getCell('E' . $nrow)->setValue($inventori['kondisi']);
            $worksheet->getCell('F' . $nrow)->setValue($inventori['keterangan']);

            $pre_inv_mitrakerja = $inventori['mitrakerja'];

            $nrow++;
            $noinv++;
            if ($noinv <= $jml_inventori) {
                $worksheet->insertNewRowBefore($nrow, 1);
            }
        }

        /* Isi Sheet Kegiatan */
        $dtTglKegiatan = $this->dbHelperOphardung->getRekapTglKegiatanMitrakerja($dtMitrakerja, $periode)->getResultArray();

        $worksheet = $spreadsheet->setActiveSheetIndexByName('TGL_');

        $tgl_kegiatan = $dtTglKegiatan[0]["tgl_kegiatan"];
        $onlyTgl = substr($tgl_kegiatan, 8, 2);
        $f_nm_sheet = "TGL_" . $onlyTgl;

        //rename first sheet kegiatan
        $worksheet->setTitle($f_nm_sheet);
        //clone sheet kegiatan
        foreach ($dtTglKegiatan as $tglKegiatan) {
            $clonedWorksheet = clone $spreadsheet->getSheetByName($f_nm_sheet);
            $tgl_kegiatan = $tglKegiatan["tgl_kegiatan"];
            $onlyTgl = substr($tgl_kegiatan, 8, 2);
            $nm_sheet = "TGL_" . $onlyTgl;
            if ($nm_sheet != $f_nm_sheet) {
                $clonedWorksheet->setTitle($nm_sheet);
                $spreadsheet->addSheet($clonedWorksheet);
            }
        }

        //isi sheet kegiatan        
        foreach ($dtTglKegiatan as $rekap) {
            $tgl_kegiatan = $rekap["tgl_kegiatan"];

            $onlyTgl = substr($tgl_kegiatan, 8, 2);
            $nm_sheet = "TGL_" . $onlyTgl;

            $worksheet = $spreadsheet->setActiveSheetIndexByName($nm_sheet);

            $worksheet->getCell('A2')->setValue("MITRA KERJA : " . $nm_mitrakerja);
            $worksheet->getCell('A3')->setValue("BULAN : " . $periodeBln);

            $dt_kegiatan = $this->dbHelperOphardung->getKegiatanPetugasPerTanggalPerMitrakerja($dtMitrakerja, $tgl_kegiatan);
            $jml_kegiatan = count($dt_kegiatan);

            //temp sheet for load foto kegiatan
            $sheet = $spreadsheet->getActiveSheet();

            $nourut = 1;
            $nrow = 6;
            foreach ($dt_kegiatan as $kegiatan) {
                $worksheet->getCell('A' . $nrow)->setValue($nourut);
                $worksheet->getCell('B' . $nrow)->setValue($kegiatan['mitrakerja']);
                $worksheet->getCell('C' . $nrow)->setValue($kegiatan['petugas']);
                $worksheet->getCell('D' . $nrow)->setValue($kegiatan['jenis']);
                $worksheet->getCell('E' . $nrow)->setValue($kegiatan['tanggal']);
                $worksheet->getCell('F' . $nrow)->setValue($kegiatan['lokasi']);
                $worksheet->getCell('G' . $nrow)->setValue($kegiatan['kondisi']);

                //get foto kegiatan
                $foto_kegiatan = $pathFotoKegiatan . $kegiatan['foto'];
                //dd($foto_kegiatan);
                if (isset($foto_kegiatan) && !empty($foto_kegiatan)) {
                    if (file_exists($foto_kegiatan)) {
                        $imageType = "png";

                        if (strpos($foto_kegiatan, ".png") === false) {
                            $imageType = "jpg";
                        }

                        $drawing = new MemoryDrawing();

                        $sheet->getRowDimension($nrow)->setRowHeight(70);
                        //Cek if image corrupt!!!
                        try {
                            $gdImage = ($imageType == 'png') ? imagecreatefrompng($foto_kegiatan) : imagecreatefrompng($foto_kegiatan);
                            $drawing->setName('Foto Kegiatan');
                            $drawing->setDescription('Gambar foto kegiatan');
                            $drawing->setResizeProportional(false);
                            $drawing->setImageResource($gdImage);
                            $drawing->setRenderingFunction(\PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing::RENDERING_JPEG);
                            $drawing->setMimeType(\PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing::MIMETYPE_DEFAULT);
                            $drawing->setWidth(80);
                            $drawing->setHeight(80);
                            $drawing->setOffsetX(5);
                            $drawing->setOffsetY(5);
                            $drawing->setCoordinates('H' . $nrow);
                            $drawing->setWorksheet($spreadsheet->getActiveSheet());
                        } catch (\Exception $e) {
                            $worksheet->getCell('H' . $nrow)->setValue("IMAGE CORRUPT");
                        }
                    } else {
                        $worksheet->getCell('H' . $nrow)->setValue("TIDAK DITEMUKAN");
                    }
                } else {
                    $worksheet->getCell('H' . $nrow)->setValue("NO FOTO");
                }

                $worksheet->getCell('I' . $nrow)->setValue($kegiatan['keterangan']);

                $nrow++;
                $nourut++;
                if ($nourut <= $jml_kegiatan) {
                    $worksheet->insertNewRowBefore($nrow, 1);
                }
            }
        }

        //rename first sheet kegiatan
        $worksheet = $spreadsheet->setActiveSheetIndexByName($f_nm_sheet);
        $worksheet->setTitle("KEGIATAN " . $f_nm_sheet);

        //set active sheet to first sheet
        $worksheet = $spreadsheet->setActiveSheetIndexByName('REKAP');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //header('Content-Disposition: attachment; filename="' . urlencode($outputFileName) . '"');
        header('Content-Disposition: attachment; filename="' . $outputFileName . '"');
        $writer->save('php://output');
        exit();
        // $data = ['status' => "succes", 'mitrakerja_id' => $mitrakerja_id, 'periode' => $periode];
        // echo json_encode($data);
        //$writer->save($outputFileName);
    }

    /* =============================================================================================== */

    /**
     * AJAX
     */
    public function ajax_data_tabel_rekap_kegiatan()
    {
        $mitrakerja_id = $this->request->getVar("data_id");
        $periode = $this->request->getVar("periode");

        $dbMitrakerja = new M_mitrakerja();
        $dtMitrakerja = $dbMitrakerja->getMitraKerja($mitrakerja_id);

        $dtRekapKegiatan = $this->dbHelperOphardung->getRekapKegiatanMitrakerja($dtMitrakerja, $periode)->getResult();

        $data = array();
        $no = 0;

        foreach ($dtRekapKegiatan as $rekapKegiatan) {
            $row_id = $rekapKegiatan->petugas_id . "|" . $rekapKegiatan->tgl_kegiatan;

            $action = "<button type='button' class='btn btn-info btn-xs' onclick='opharKegiatanPetugasPerTgl(\"" . $row_id . "\")'><i class='fa fa-eye'></i> Tampilkan</button>";

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $rekapKegiatan->mitrakerja;
            $row[] = $rekapKegiatan->petugas;
            $row[] = $rekapKegiatan->tgl_kegiatan;
            $row[] = $rekapKegiatan->jml_kegiatan;
            $row[] = $action;

            $data[] = $row;
        }
        echo json_encode($data);
    }
}
