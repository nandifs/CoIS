<?php

namespace App\Controllers\Ketenagakerjaan;

use App\Controllers\BaseController;

use App\Database\DbHelper;
use App\Database\DbHTableKetenagakerjaan;

class Tenagakerjafortable extends BaseController
{
    protected $dbHelper;
    protected $DbHTableKetenagakerjaan;


    public function __construct()
    {
        $this->dbHelper = new DbHelper();
        $this->DbHTableKetenagakerjaan = new DbHTableKetenagakerjaan();
    }

    public function ajax_get_data_tenagakerja()
    {

        $dataId = $this->request->getVar('data_id');

        $dataId = "bpjs_ks|1"; //JANGAN LUPA HAPUS BARIS UJI COBA INI

        $expDataId = explode('|', $dataId);

        $vdata = $expDataId[0];
        $mitrakerja_id = $expDataId[1];

        $dbHForTable = new DbHTableKetenagakerjaan();

        if ($vdata == "tenagakerja") {
            $vSelect = "status,nip,nama,jabatan,unitkerja,penempatan,wilayahkerja,no_pks_p1,no_pkwt,tanggal_awal,tanggal_akhir,
                    no_identitas,tempat_lahir,tanggal_lahir,jenis_kelamin,agama,alamat,telepon,
                    bank_rek_payroll,no_rek_payroll,no_bpjs_kt,no_bpjs_ks,bank_rek_dplk,no_rek_dplk,
                    no_kartu_keluarga,nama_ibu,nama_pasangan_hidup,nama_anak_1,nama_anak_2,nama_anak_3,
                    pendidikan,program_studi,no_skk_1,no_skk_2,no_npwp,keterangan";

            $vColoum = stringToArray($vSelect);
            $dtTenagakerja = $dbHForTable->getForTabelTenagakerja($mitrakerja_id, "stv__ketenagakerjaan_data_tk", $vSelect, $vSelect);
        } else if ($vdata == "upah") {
            $vSelect = "status,nip,nama,jabatan,wilayahkerja,c|upah_pokok,c|umk,
                        c|tunj_masa_kerja,c|tunj_transport,c|tunj_makan,c|tunj_keahlian,c|tunj_hari_raya,c|tunj_lainnya,
                        c|premi_bpjs_kt,c|premi_bpjs_ks,c|premi_dplk,
                        c|pot_bpjs_kt,c|pot_bpjs_ks,c|pot_adm,c|pot_seragam,c|pot_sanksi,c|pot_pajak,c|pot_lainnya";

            $vColoum = stringToArray($vSelect);

            //bersihkan format coloum dari text vSelect (selected field)
            $vSelect = str_replace("|c", "", stringClean($vSelect));
            $dtTenagakerja = $dbHForTable->getForTabelTenagakerja($mitrakerja_id, "stv__ketenagakerjaan_data_haknormatif", $vSelect, $vSelect);

            //kolom kalkulasi
            $thp = "c|umk,c|tunj_masa_kerja,c|tunj_transport,c|tunj_makan,c|tunj_keahlian,c|tunj_lainnya";
            $potongan = "c|pot_bpjs_kt,c|pot_bpjs_ks,c|pot_adm,c|pot_seragam,c|pot_sanksi,c|pot_pajak,c|pot_lainnya";
            $premi = "c|premi_bpjs_kt,c|premi_bpjs_ks,c|premi_dplk";

            $vArrTHP = stringToArray($thp);
            $vArrPotongan = stringToArray($potongan);
            $vArrPremi = stringToArray($premi);
        } else if ($vdata == "bpjs_kt") {
            $hakNormatifBPJSKT = $this->dbHelper->getHakNormatifKomponen("BPJS_KT_DETAIL");

            $komponen = explode("|", $hakNormatifBPJSKT->komponen);
            $rumus =  json_decode($hakNormatifBPJSKT->rumus, true);

            $vSelect = "status,nip,nama,jabatan,wilayahkerja,no_bpjs_kt,umk,";
            foreach ($komponen as $nama_komponen) {
                $vSelect .= getValHNK($rumus["$nama_komponen"]) . " as " . $nama_komponen . ",";
            }

            $vSelect .= "umk as iuran,umk as t_perusahaan,umk as t_tenagakerja,keterangan";

            $vOrderCols = "status,nip,nama,jabatan,wilayahkerja,no_bpjs_kt,c|umk,c|jkk,c|jkm,c|jht_pk,c|jht_tk,c|jp_pk,c|jp_tk,c|iuran,t_perusahaan,c|t_tenagakerja,keterangan";
            $vColoum = stringToArray($vOrderCols);
            $vSelect = strtolower(stringClean($vSelect));

            $vOrderCols = str_replace("|c", "", stringClean($vOrderCols));
            $dtTenagakerja = $dbHForTable->getForTabelTenagakerja($mitrakerja_id, "stv__ketenagakerjaan_data_haknormatif", $vSelect, $vOrderCols);
            $viuran = "jkk,jkm,jht_pk,jht_tk,jp_pk,jp_tk";
            $viuranTPerusahaan = "jkk,jkm,jht_pk,jp_pk";
            $viuranTTengakerja = "jht_tk,jp_tk";
            $vArrIurang = stringToArray($viuran);
            $vArrIurangTPerusahaan = stringToArray($viuranTPerusahaan);
            $vArrIurangTTengakerja = stringToArray($viuranTTengakerja);
        } else if ($vdata == "bpjs_ks") {
            $hakNormatifBPJSKS = $this->dbHelper->getHakNormatifKomponen("BPJS_KS_DETAIL");

            $komponen = explode("|", $hakNormatifBPJSKS->komponen);
            $rumus =  json_decode($hakNormatifBPJSKS->rumus, true);
            // d($komponen);
            // dd($rumus);

            //getValHNK($rumus["$nama_komponen"]) . " as " . $nama_komponen . ",";
            $vSelect = "status,nip,nama,jabatan,wilayahkerja,no_bpjs_ks,umk,";
            foreach ($komponen as $nama_komponen) {
                $vSelect .= getValHNK($rumus["$nama_komponen"]) . " as " . $nama_komponen . ",";
            }

            $vSelect .= "umk as iuran,keterangan";

            $vOrderCols = "status,nip,nama,jabatan,wilayahkerja,no_bpjs_ks,c|umk,c|bpjs_ks_pk,c|bpjs_ks_tk,c|iuran,keterangan";
            $vColoum = stringToArray($vOrderCols);
            $vSelect = strtolower(stringClean($vSelect));

            $vOrderCols = str_replace("|c", "", stringClean($vOrderCols));

            $dtTenagakerja = $dbHForTable->getForTabelTenagakerja($mitrakerja_id, "stv__ketenagakerjaan_data_haknormatif", $vSelect, $vOrderCols);
            $viuran = "bpjs_ks_pk,bpjs_ks_tk";
            $vArrIurang = stringToArray($viuran);
        }

        $no = $_POST['start'];

        $data = array();
        //convert selected field name to array        
        foreach ($dtTenagakerja as $tenagakerja) {
            $jmlTHP = 0.0;
            $jmlPremi = 0.0;
            $jmlPotongan = 0.0;

            $iuran = 0.0;
            $iuran_t_perusahaan = 0.0;
            $iuran_t_tenagakerja = 0.0;

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $this->action($tenagakerja->id, $tenagakerja->nip, $tenagakerja->nama);

            foreach ($vColoum as $nmfield) {
                $retValue = coloumFormat($nmfield, $tenagakerja);
                $row[] = $retValue[0];
                $realValue = $retValue[1];

                if ($vdata == "upah") {
                    if (in_array($nmfield, $vArrTHP)) {
                        $jmlTHP += (float) $realValue;
                    }
                    if (in_array($nmfield, $vArrPotongan)) {
                        $jmlPotongan += (float) $realValue;
                    }
                    if (in_array($nmfield, $vArrPremi)) {
                        $jmlPremi += (float) $realValue;
                    }
                }
            }

            if ($vdata == "upah") {
                $UpahDiTerima = $jmlTHP - $jmlPotongan;
                $row[] = number_format($UpahDiTerima, 2);
                $row[] = $tenagakerja->keterangan;
            }

            if ($vdata == "bpjs_kt" || $vdata == "bpjs_ks") {
                foreach ($vArrIurang as $nmfield) {
                    $iuran += $tenagakerja->$nmfield;
                }
                if ($vdata == "bpjs_kt") {
                    foreach ($vArrIurangTPerusahaan as $nmfield) {
                        $iuran_t_perusahaan += $tenagakerja->$nmfield;
                    }
                    foreach ($vArrIurangTTengakerja as $nmfield) {
                        $iuran_t_tenagakerja += $tenagakerja->$nmfield;
                    }

                    $row[15] = number_format($iuran, 2);
                    $row[16] = number_format($iuran_t_perusahaan, 2);
                    $row[17] = number_format($iuran_t_tenagakerja, 2);
                } else if ($vdata == "bpjs_ks") {
                    $row[11] = number_format($iuran, 2);
                }
            }
            $row[] = $this->action($tenagakerja->id, $tenagakerja->nip, $tenagakerja->nama);

            $data[] = $row;
        }

        $output = array(
            "draw"                 => $_POST['draw'],
            "recordsTotal"         => $dbHForTable->count_all($mitrakerja_id),
            "recordsFiltered"      => $dbHForTable->count_filtered($mitrakerja_id),
            "data"                 => $data,
        );

        //output to json format
        echo json_encode($output);
    }

    function action($tenagakerja_id, $tenagakerja_nip, $tenagakerja_nama)
    {
        //$action = "<div class='btn-group'> <button type='button' class='btn btn-success btn-sm' title='Edit' onclick='editData(\"$tenagakerja_nip\")'><i class='fa fa-edit'></i> Edit</button> <button type='button' class='btn btn-danger btn-sm' title='Hapus' onclick='deleteData($tenagakerja_id,\"$tenagakerja_nama\");'><i class=' fa fa-trash-alt'></i> Hapus</button> </div>";
        $action = "<div class='btn-group'> <button type='button' class='btn btn-success btn-sm' title='Informasi Detail' onclick='info_detail(\"$tenagakerja_nip\")'><i class='fa fa-info'></i> <strong>Detail</strong></button></div>";
        return $action;
    }
}
