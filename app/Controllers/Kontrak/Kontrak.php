<?php

namespace App\Controllers\Kontrak;

use App\Controllers\BaseController;
use App\Database\DbHelperKontrak;
use App\Models\KONTRAK\M_kontrak;
use App\Models\KONTRAK\M_kontrak_temporary;

class Kontrak extends BaseController
{
    protected $dbHelperKontrak;

    public function __construct()
    {
        $this->dbHelperKontrak = new DbHelperKontrak;
    }
    //--------------------------------------------------------------------

    public function index()
    {
        //Cek otoritas user
        if ($this->oto_id != "99" && $this->oto_id != "1" && $this->oto_id != "2") {
            return redirect()->to("/");
        }

        $dtKontrak = $this->dbHelperKontrak->getKontrak();
        //dd($dtKontrak);

        $appJS =  loadJS('bs-custom-file-input/bs-custom-file-input.min.js', 'adminlte_plugins');
        $appJS .=  loadJS('kontrak/kontrak.js', 'appjs');

        $this->dtContent['title'] = "Data Kontrak";
        $this->dtContent['page'] = "kontrak_pks";

        $this->dtContent['dtKontrak'] = $dtKontrak;
        $this->dtContent['appJSFoot'] = $appJS;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function detail($kontrak_id = null)
    {
        //Cek otoritas user
        if ($this->oto_id != "99" && $this->oto_id != "1" && $this->oto_id != "2") {
            return redirect()->to("/");
        }

        if (!is_null($kontrak_id)) {
            $jmlSubKontrak = 0;

            $dtKontrak = $this->dbHelperKontrak->getKontrak($kontrak_id);
            $this->dtContent['dtKontrak'] = (array)$dtKontrak;
            $this->dtContent['jmlSubKontrak'] = $jmlSubKontrak;
            //dd($dtKontrak);
        }

        $appJS =  loadJS('bs-custom-file-input/bs-custom-file-input.min.js', 'adminlte_plugins');
        $appJS .=  loadJS('kontrak/kontrak.js', 'appjs');

        $this->dtContent['title'] = "Data Kontrak";
        $this->dtContent['page'] = "kontrak_pks_detail";

        $this->dtContent['appJSFoot'] = $appJS;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function edit($kontrak_id = null)
    {
        //Cek otoritas user
        if ($this->oto_id != "99" && $this->oto_id != "1" && $this->oto_id != "2") {
            return redirect()->to("/");
        }

        if (!is_null($kontrak_id)) {
            $jmlSubKontrak = 0;

            $dtKontrak = $this->dbHelperKontrak->getKontrak($kontrak_id);
            $this->dtContent['dtKontrak'] = (array)$dtKontrak;
            $this->dtContent['jmlSubKontrak'] = $jmlSubKontrak;
            //dd($dtKontrak);
        }

        $appJS =  loadJS('bs-custom-file-input/bs-custom-file-input.min.js', 'adminlte_plugins');
        $appJS .=  loadJS('kontrak/kontrak.js', 'appjs');

        $this->dtContent['title'] = "Edit Data Kontrak";
        $this->dtContent['page'] = "kontrak_pks_edit";

        $this->dtContent['appJSFoot'] = $appJS;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function import()
    {
        //Cek otoritas user
        if ($this->oto_id != "99" && $this->oto_id != "1" && $this->oto_id != "2") {
            return redirect()->to("/");
        }

        $dtKontrak = $this->dbHelperKontrak->getKontrakTemporary();

        $appJS =  loadJS('bs-custom-file-input/bs-custom-file-input.min.js', 'adminlte_plugins');
        $appJS .=  loadJS('kontrak/kontrak.js', 'appjs');

        $this->dtContent['title'] = "Data Kontrak";
        $this->dtContent['page'] = "kontrak_pks_import_xls";

        $this->dtContent['dtKontrak'] = $dtKontrak;
        $this->dtContent['appJSFoot'] = $appJS;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function rab_normatif()
    {
        //Cek otoritas user
        if ($this->oto_id != "99" && $this->oto_id != "1" && $this->oto_id != "2") {
            return redirect()->to("/");
        }

        $dtKontrak = $this->dbHelperKontrak->getKontrak();
        //dd($dtKontrak);

        $appJS =  loadJS('bs-custom-file-input/bs-custom-file-input.min.js', 'adminlte_plugins');
        $appJS .=  loadJS('kontrak/kontrak.js', 'appjs');

        $this->dtContent['title'] = "Data RAB (NORMATIF)";
        $this->dtContent['page'] = "kontrak_rab_normatif";

        $this->dtContent['dtKontrak'] = $dtKontrak;
        $this->dtContent['appJSFoot'] = $appJS;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function rab_material()
    {
        //Cek otoritas user
        if ($this->oto_id != "99" && $this->oto_id != "1" && $this->oto_id != "2") {
            return redirect()->to("/");
        }

        $dtKontrak = $this->dbHelperKontrak->getKontrak();
        //dd($dtKontrak);

        $appJS =  loadJS('bs-custom-file-input/bs-custom-file-input.min.js', 'adminlte_plugins');
        $appJS .=  loadJS('kontrak/kontrak.js', 'appjs');

        $this->dtContent['title'] = "Data RAB (MATERIAL)";
        $this->dtContent['page'] = "kontrak_rab_material";

        $this->dtContent['dtKontrak'] = $dtKontrak;
        $this->dtContent['appJSFoot'] = $appJS;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function validasi_import_xlsx()
    {
        $user_id = $this->user_id;
        $tgl_update = date('Y-m-d H:i:s');
        $tgl_import = $tgl_update;
        $validasi = "Import Data";

        $kontrak_id = 0;

        $jml_import = 0;

        $stat_import = "";
        $ket_import = "";

        $row_number = 0;

        $jmlKontrakSdhAda = 0;
        $jmlKontrakBaru = 0;

        //validasi file yang akan di import
        $validation = \Config\Services::validation();
        $file = $this->request->getFile('imp_file');
        $data = array('imp_file' => $file);

        $redirectPath = '/kontrak_pks_import';

        if ($validation->run($data, 'import_excel') == FALSE) {
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->to($redirectPath);
        } else {

            // ambil extension dari file excel
            $extension = $file->getClientExtension();

            // format excel 2007 ke bawah
            if ('xls' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                // format excel 2010 ke atas
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }

            $spreadsheet = $reader->load($file);

            $data = $spreadsheet->getActiveSheet()->toArray();

            //Save to temporary table
            $kontrakModel = new M_kontrak_temporary();

            $batchData = array();
            foreach ($data as $idx => $row) {
                //Cek kolom terakhir file import
                //Jika panjang kolom tidak sesuai berarti salah file import
                if ($row_number == 1) {
                    $cek_cols = count($row);
                    if ($cek_cols != 20) {
                        $stat_import = "GAGAL IMPORT KONTRAK: Kolom file import tidak sesuai. Proses import Kontrak dibatalkan.";
                        break;
                    }
                }

                // lewati baris ke 0 dan ke 1 pada file excel
                // dalam kasus ini, array ke 0 adalah paratitle
                if ($idx === 0 || $idx === 1) {
                    continue;
                }

                //Set row number
                $row_number++;

                // get data kontrak from excel
                $sts_kontrak = $this->dbHelperKontrak->getStatusKontrakIdByNama(trim($row[1]));
                $jenis_kontrak = trim($row[2]);
                $no_io = trim($row[3]);
                $no_kontrak = trim($row[4]);
                $unitkerja = $this->dbHelperKontrak->getUnitkerjaIdByNama(trim($row[5]));
                $customer = $this->dbHelperKontrak->getCustomerIdByNama(trim($row[6]));
                $uraian_pekerjaan = trim($row[7]);
                $jns_pekerjaan = $this->dbHelperKontrak->getJenisPekerjaanIdByNama(trim($row[8]));
                $sub_jns_pekerjaan = $this->dbHelperKontrak->getSubJenisPekerjaanByNama(trim($row[9]));
                $tgl_mulai = $row[10];
                $tgl_akhir = $row[11];

                $nil_kontrak_perbln_ppn = trim($row[12]);
                $nil_kontrak_perbln_ppn = str_replace(',', '', $nil_kontrak_perbln_ppn);
                $nil_kontrak_perbln_ppn = str_replace('.', ',', $nil_kontrak_perbln_ppn);

                $nil_kontrak_total_ppn = trim($row[13]);
                $nil_kontrak_total_ppn = str_replace(',', '', $nil_kontrak_total_ppn);
                $nil_kontrak_total_ppn = str_replace('.', ',', $nil_kontrak_total_ppn);

                $jml_tad =  trim($row[14]);
                $keterangan =  trim($row[15]);

                $cekKontrakByNoSPK = $this->dbHelperKontrak->getKontrakIdByNoP1($no_kontrak);

                //Validasi data import
                if ($sts_kontrak == "") {
                    break;
                }

                if (!is_null($cekKontrakByNoSPK)) {
                    $kontrak_id = $cekKontrakByNoSPK->id;
                    $jmlKontrakSdhAda++;
                    $validasi = "Update Data";
                } else {
                    $jmlKontrakBaru++;
                }

                if (is_null($unitkerja)) {
                    $stat_import = "GAGAL IMPORT : <br> Row Number: " . $row_number . " <br> Err desk: Nama Unit Kerja '" . $unitkerja . "' tidak ditemukan. <br>Proses import Kontrak dibatalkan.";
                    break;
                }

                if (is_null($customer)) {
                    $stat_import = "GAGAL IMPORT : <br> Row Number: " . $row_number . " <br> Err desk: Nama Customer '" . $customer . "' tidak ditemukan. <br>Proses import Kontrak dibatalkan.";
                    break;
                }

                if (is_null($jns_pekerjaan)) {
                    $stat_import = "GAGAL IMPORT : <br> Row Number: " . $row_number . " <br> Err desk: Jenis pekerjaan '" . $jns_pekerjaan . "' tidak ditemukan. <br>Proses import Kontrak dibatalkan.";
                    break;
                }

                if (is_null($sub_jns_pekerjaan)) {
                    $stat_import = "GAGAL IMPORT : <br> Row Number: " . $row_number . " <br> Err desk: Sub Jenis pekerjaan '" . $sub_jns_pekerjaan . "' tidak ditemukan. <br>Proses import Kontrak dibatalkan.";
                    break;
                }

                $imp_data = [
                    "jenis_kontrak" => $jenis_kontrak,
                    "tgl_import" => $tgl_import,
                    "validasi" => $validasi,
                    "status_import" => "On Validation",
                    "kontrak_id" => $kontrak_id,
                    "perusahaan_id" => $unitkerja->id,
                    "customer_id" => $customer->id,
                    "no_io" => $no_io,
                    "no_pks_p1" => $no_kontrak,
                    "uraian_pekerjaan" => $uraian_pekerjaan,
                    "kategori_pekerjaan_id" => $jns_pekerjaan->kategori_id,
                    "jenis_pekerjaan_id" => $jns_pekerjaan->id,
                    "sub_jenis_pekerjaan_id" => $sub_jns_pekerjaan->id,
                    "tanggal_mulai" => date('Y-m-d', strtotime($tgl_mulai)),
                    "tanggal_akhir" => date('Y-m-d', strtotime($tgl_akhir)),
                    "nilai_bulan_ppn" => $nil_kontrak_perbln_ppn,
                    "nilai_total_ppn" => $nil_kontrak_total_ppn,
                    "jumlah_tad" => $jml_tad,
                    "keterangan" => $keterangan,
                    "status_id" => $sts_kontrak->id,
                    "update_oleh" => $user_id
                ];

                // Save data to batch
                $batchData[] = $imp_data;
            }

            if ($stat_import == "") {
                if (count($batchData) != 0) {
                    $simpan = $kontrakModel->insertBatchDataFromXls($batchData);
                    $jml_import = $simpan;
                    $ket_import =  '<hr>' .
                        'Jumlah data    : ' . $jml_import . '<br>' .
                        'Data Baru      : ' . $jmlKontrakBaru . '<br>' .
                        'Pembaruan Data : ' . $jmlKontrakSdhAda . '<br><br>' .
                        'Silahkan lihat tabel hasil validasi, sebelum melanjutkan proses Import Data. Dan klik tombol Konfirmasi untuk melanjutkan.';
                }
            }

            if ($stat_import != "") {
                session()->setFlashdata('danger2', $stat_import);
            } else {
                if ($jml_import == 0) {
                    session()->setFlashdata('warning', 'Data Kontrak tidak berhasil di import.<br>Silahkan cek kembali file excel yang telah di import.');
                } else {
                    if ($simpan) {
                        session()->setFlashdata('success-validation-import', $ket_import);
                    }
                }
            }

            return redirect()->to($redirectPath);
        }
    }

    public function proses_import_xlsx()
    {
        $user_id = $this->user_id;

        $batchImportData = array();
        $batchUpdateData = array();

        $jml_import = 0;
        $jml_update = 0;

        $redirectPath = '/kontrak_pks_import';

        $dtKontrak = $this->dbHelperKontrak->getKontrakTemporary();

        $kontrakModel = new M_kontrak();

        foreach ($dtKontrak as $rowdata) {
            $validasi = $rowdata['validasi'];
            if (strtoupper($validasi) == 'IMPORT DATA') {
                $imp_data = [
                    "perusahaan_id" => $rowdata['perusahaan_id'],
                    "customer_id" => $rowdata['customer_id'],
                    "no_io" => $rowdata['no_io'],
                    "no_pks_p1" => $rowdata['no_pks_p1'],
                    "uraian_pekerjaan" => $rowdata['uraian_pekerjaan'],
                    "kategori_pekerjaan_id" => $rowdata['kategori_pekerjaan_id'],
                    "jenis_pekerjaan_id" => $rowdata['jenis_pekerjaan_id'],
                    "sub_jenis_pekerjaan_id" => $rowdata['sub_jenis_pekerjaan_id'],
                    "tanggal_mulai" => $rowdata['tanggal_mulai'],
                    "tanggal_akhir" => $rowdata['tanggal_akhir'],
                    "nilai_bulan_ppn" => $rowdata['nilai_bulan_ppn'],
                    "nilai_total_ppn" => $rowdata['nilai_total_ppn'],
                    "jumlah_tad" => $rowdata['jumlah_tad'],
                    "keterangan" => $rowdata['keterangan'],
                    "status_id" => $rowdata['status_id'],
                    "update_oleh" => $user_id
                ];

                // Save to batchdata
                $batchImportData[] = $imp_data;
            } else if (strtoupper($validasi) == 'UPDATE DATA') {
                $upd_data = [
                    "id" => $rowdata['kontrak_id'],
                    "perusahaan_id" => $rowdata['perusahaan_id'],
                    "customer_id" => $rowdata['customer_id'],
                    "no_io" => $rowdata['no_io'],
                    "no_pks_p1" => $rowdata['no_pks_p1'],
                    "uraian_pekerjaan" => $rowdata['uraian_pekerjaan'],
                    "kategori_pekerjaan_id" => $rowdata['kategori_pekerjaan_id'],
                    "jenis_pekerjaan_id" => $rowdata['jenis_pekerjaan_id'],
                    "sub_jenis_pekerjaan_id" => $rowdata['sub_jenis_pekerjaan_id'],
                    "tanggal_mulai" => $rowdata['tanggal_mulai'],
                    "tanggal_akhir" => $rowdata['tanggal_akhir'],
                    "nilai_bulan_ppn" => $rowdata['nilai_bulan_ppn'],
                    "nilai_total_ppn" => $rowdata['nilai_total_ppn'],
                    "jumlah_tad" => $rowdata['jumlah_tad'],
                    "keterangan" => $rowdata['keterangan'],
                    "status_id" => $rowdata['status_id'],
                    "update_oleh" => $user_id
                ];

                // Save to batchdata
                $batchUpdateData[] = $upd_data;
            }
        }

        if (count($batchImportData) != 0) {
            $simpan = $kontrakModel->insertBatchDataFromXls($batchImportData);
            $jml_import = $simpan;
        }
        //dd($batchUpdateData);
        if (count($batchUpdateData) != 0) {
            $simpan_update = $kontrakModel->updateBatchDataFromXls($batchUpdateData);
            $jml_update = $simpan_update;
        }

        if (($jml_import + $jml_update) != 0) {
            $ket_import =  '<hr>' .
                'Jumlah data    : ' . $jml_import . '<br>' .
                'Data Baru      : ' . $jml_import . ' Berhasil di import.<br>' .
                'Pembaruan Data : ' . $jml_update . ' Berhasil di perbarui.<br><br>';
            session()->setFlashdata('success-validation-import', $ket_import);
        }

        return redirect()->to($redirectPath);
    }
}
