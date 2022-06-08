<?php

namespace App\Controllers\Amkp;

use App\Controllers\BaseController;
use App\Database\DbHelper;
use App\Database\DbHelperAmkp;
use App\Models\M_unitkerja;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;

class Kegiatan extends BaseController
{

    protected $dbHelper;
    protected $dbHelperAmkp;

    protected $dbUnitkerja;

    public function __construct()
    {
        $this->dbHelper = new DbHelper();
        $this->dbHelperAmkp = new DbHelperAmkp();

        $this->dbUnitkerja = new M_unitkerja();
    }

    public function index()
    {
        if ($this->hasLogin) {
            if ($this->otoritas == "ADMINISTRATOR" || $this->otoritas == "OPERATOR") {

                $selDtAkses = $this->dtAksesUnit;
                $selComboDtAkses = $this->request->getVar("dtakses");

                $dtUnitkerja = $this->dbHelper->getUnitKerja($selDtAkses);

                if (is_null($selComboDtAkses)) {
                    $selComboDtAkses = $dtUnitkerja[0]['id'];
                }

                $selPeriode = $this->request->getVar('periode');
                $aksi = $this->request->getVar('cmdaksi');

                $selPeriode = (is_null($selPeriode)) ? date("Y-m-1") : $selPeriode;
                $aksi = (is_null($aksi)) ? 'rekapitulasi' : $aksi;

                if ($aksi == "export_kegiatan_pegawai_to_xls") {
                    $this->export_kegiatan_pegawai($selComboDtAkses, $selPeriode);
                    return;
                }

                $pathFotoKegiatan = $this->pathUploadImgApp . "/kegiatan/";

                $this->dtContent['page'] = "pegawai_kegiatan";
                $this->dtContent['title'] = "Kegiatan";

                $this->dtContent['dtUnitkerja'] = $dtUnitkerja;

                $this->dtContent['selDtAkses'] = $selComboDtAkses;
                $this->dtContent['selPeriode'] = $selPeriode;

                $appCSS = loadCSS("kegiatan.css", "appcss");
                $appJSFoot = loadJS("amkp/bukukegiatan.js", "appjs");

                $this->dtContent['appCSS'] = $appCSS;
                $this->dtContent['appJSFoot'] = $appJSFoot;

                $this->dtContent['pathFotoKegiatan'] = $pathFotoKegiatan;
            }
        }

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function kegiatanperpegawai()
    {
        $keyData = $this->request->getVar("key_data");

        if ($this->hasLogin) {
            if ($this->otoritas != "PEGAWAI") {
                $expKeyData = explode("|", $keyData);

                $pegawai_id = $expKeyData[0];
                $tanggal = $expKeyData[1];
                $unitkerja_id = $expKeyData[2];
                $periode = $expKeyData[3];

                $dtKegiatan = $this->dbHelperAmkp->getKegiatanPetugasPerTanggal($pegawai_id, $tanggal);

                //dd($dtKegiatan);
                //dd($periode);

                $blnThn = ambil_angka_bulan_tahun($periode);
                $pathFotoKegiatan = "./uploads/AMKP/$blnThn/kegiatan/";

                $this->dtContent['page'] = "pegawai_kegiatanperpegawai";
                $this->dtContent['title'] = "Kegiatan";

                $this->dtContent['dtKegiatan'] = $dtKegiatan;

                $appCSS = loadCSS("kegiatan.css", "appcss");
                $appJSFoot = loadJS("amkp/bukukegiatan_pegawai.js", "appjs");

                $this->dtContent['appCSS'] = $appCSS;
                $this->dtContent['appJSFoot'] = $appJSFoot;

                $this->dtContent['unitkerja_id'] = $unitkerja_id;
                $this->dtContent['periode'] = $periode;

                $this->dtContent['pathFotoKegiatan'] = $pathFotoKegiatan;
            }
        }

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function export_kegiatan_pegawai($unitkerja_id, $periode)
    {
        $periodeBln = strtoupper(ambil_bulan_tahun($periode));

        $dbUnitkerja = new M_unitkerja();
        $dtUnitkerja = $dbUnitkerja->getUnitKerja($unitkerja_id);

        /* GET REKAP KEGIATAN OPHARDUNG */
        $nm_unitkerja = $dtUnitkerja['unitkerja'];
        /* END GET REKAP KEGIATAN */

        // path photo kegiatan
        $blnThn = ambil_angka_bulan_tahun();
        $pathFotoKegiatan = "./uploads/AMKP/$blnThn/kegiatan/";

        //load template
        $inputFileName = 'templates/laporan/pegawai_kegiatan.xlsx';
        $outputFileName = $nm_unitkerja . ' - LAPORAN KEGIATAN - ' . $periodeBln . '.xls';
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);

        /* Isi Tabel REKAP */
        $dtRekapKegiatan = $this->dbHelperAmkp->getRekapKegiatanUnitkerja($dtUnitkerja, $periode)->getResultArray();
        $jmlRekapKegiatan = count($dtRekapKegiatan);

        $worksheet = $spreadsheet->setActiveSheetIndexByName('REKAP');

        $worksheet->getCell('A2')->setValue("PENEMPATAN : " . $nm_unitkerja);
        $worksheet->getCell('A3')->setValue("BULAN : " . $periodeBln);
        //dd($dtRekapKegiatan);
        $nourut = 1;
        $nrow = 6;
        foreach ($dtRekapKegiatan as $rekap) {

            $worksheet->getCell('A' . $nrow)->setValue($nourut);
            $worksheet->getCell('B' . $nrow)->setValue(strtoupper($rekap['petugas']));
            $worksheet->getCell('C' . $nrow)->setValue($rekap['tgl_kegiatan']);
            $worksheet->getCell('D' . $nrow)->setValue($rekap['jml_kegiatan']);

            $nrow++;
            $nourut++;
            if ($nourut <= $jmlRekapKegiatan) {
                $worksheet->insertNewRowBefore($nrow, 1);
            }
        }

        /* Isi Sheet Kegiatan */
        $dtTglKegiatan = $this->dbHelperAmkp->getRekapTglKegiatanUnitkerja($dtUnitkerja, $periode)->getResultArray();

        $worksheet = $spreadsheet->setActiveSheetIndexByName('TGL_');
        $tgl_kegiatan = $dtTglKegiatan[0]["tgl_kegiatan"];
        $onlyTgl = substr($tgl_kegiatan, 8, 2);
        $f_nm_sheet = "TGL_" . $onlyTgl;

        //rename first sheet kegiatan
        $worksheet->setTitle($f_nm_sheet);

        //clone sheet kegiatan        
        foreach ($dtTglKegiatan as $rekap) {
            $clonedWorksheet = clone $spreadsheet->getSheetByName($f_nm_sheet);
            $tgl_kegiatan = $rekap["tgl_kegiatan"];
            $onlyTgl = substr($tgl_kegiatan, 8, 2);
            $nm_sheet = "TGL_" . $onlyTgl;
            if ($nm_sheet != $f_nm_sheet) {
                $clonedWorksheet->setTitle($nm_sheet);
                $spreadsheet->addSheet($clonedWorksheet);
            }
        }

        //isi sheet kegiatan
        foreach ($dtTglKegiatan as $rekap) {
            //$pegawai_id = $rekap["petugas_id"];
            $tgl_kegiatan = $rekap["tgl_kegiatan"];

            $onlyTgl = substr($tgl_kegiatan, 8, 2);
            $nm_sheet = "TGL_" . $onlyTgl;

            $worksheet = $spreadsheet->setActiveSheetIndexByName($nm_sheet);

            $worksheet->getCell('A2')->setValue("PENEMPATAN : " . $nm_unitkerja);
            $worksheet->getCell('A3')->setValue("BULAN : " . $periodeBln);

            $dt_kegiatan = $this->dbHelperAmkp->getKegiatanPetugasPerTanggalPerUnitkerja($unitkerja_id, $tgl_kegiatan);
            $jml_kegiatan = count($dt_kegiatan);

            //temp sheet for load foto kegiatan
            $sheet = $spreadsheet->getActiveSheet();

            $nourut = 1;
            $nrow = 6;

            foreach ($dt_kegiatan as $kegiatan) {
                $worksheet->getCell('A' . $nrow)->setValue($nourut);
                $worksheet->getCell('B' . $nrow)->setValue($kegiatan['petugas']);
                $worksheet->getCell('C' . $nrow)->setValue($kegiatan['jenis']);
                $worksheet->getCell('D' . $nrow)->setValue($kegiatan['tanggal']);
                $worksheet->getCell('E' . $nrow)->setValue($kegiatan['lokasi']);
                $worksheet->getCell('F' . $nrow)->setValue($kegiatan['kondisi']);
                //get foto kegiatan
                $foto_kegiatan = $pathFotoKegiatan . $kegiatan['foto'];

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
                        $drawing->setCoordinates('G' . $nrow);
                        $drawing->setWorksheet($spreadsheet->getActiveSheet());
                    } else {
                        $worksheet->getCell('G' . $nrow)->setValue("TIDAK DITEMUKAN");
                    }
                } else {
                    $worksheet->getCell('G' . $nrow)->setValue("NO FOTO");
                }

                $worksheet->getCell('H' . $nrow)->setValue($kegiatan['keterangan']);

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
        // $data = ['status' => "succes", 'unitkerja_id' => $unitkerja_id, 'periode' => $periode];
        // echo json_encode($data);
        //$writer->save($outputFileName);
    }

    /* =============================================================================================== */

    /**
     * AJAX
     */
    public function ajax_data_tabel_rekap_kegiatan()
    {
        $unitkerja_id = $this->request->getVar("data_id");
        $periode = $this->request->getVar("periode");

        $dbUnitkerja = new M_unitkerja();
        $dtUnitkerja = $dbUnitkerja->getUnitKerja($unitkerja_id);

        $dtRekapKegiatan = $this->dbHelperAmkp->getRekapKegiatanUnitkerja($dtUnitkerja, $periode)->getResult();

        $data = array();
        $no = 0;

        foreach ($dtRekapKegiatan as $rekapKegiatan) {
            $row_id = $rekapKegiatan->petugas_id . "|" . $rekapKegiatan->tgl_kegiatan;

            $action = "<button type='button' class='btn btn-info btn-xs' onclick='opharKegiatanPetugasPerTgl(\"" . $row_id . "\")'><i class='fa fa-eye'></i> Tampilkan</button>";

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $rekapKegiatan->unitkerja;
            $row[] = $rekapKegiatan->petugas;
            $row[] = $rekapKegiatan->tgl_kegiatan;
            $row[] = $rekapKegiatan->jml_kegiatan;
            $row[] = $action;

            $data[] = $row;
        }
        echo json_encode($data);
    }
}
