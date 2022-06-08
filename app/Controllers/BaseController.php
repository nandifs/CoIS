<?php

namespace App\Controllers;

use App\Database\DbHelperUser;
use App\Models\M_corporate;
use App\Models\M_menu;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['url', 'form', 'file', 'app', 'app_date', 'satpam'];

    protected $session;

    protected $hasLogin = false;
    protected $corpID = 2; //SESUAIKAN DENGAN ID PERUSAHAAN PENGGUNA APLIKASI
    protected $dtCorporate;
    protected $corpName = "";

    protected $appID = 1;
    protected $appName = "CoIS";
    protected $appFullName = "Corporate Integrated System";

    protected $user_id = 0;
    protected $user_uid = "";
    protected $oto_id = 0;
    protected $otoritas = "-";
    protected $dtAksesUnit = 0;
    protected $dtAksesMitra = 0;

    protected $pathUploadImgApp;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        $this->session = \Config\Services::session();
        $this->request = \Config\Services::request();

        $dbCorporate = new M_corporate();
        $corporate = $dbCorporate->getCorporate($this->corpID);

        if (!is_null($corporate)) {
            $this->dtCorporate = $corporate;
        } else {
            $this->dtCorporate = [
                'id' => 1,
                'nama' => "R3LSE",
                'nama_panjang' => "R3LSE Corp.",
                'uraian' => "R3LSE Corporation"
            ];
        }

        $this->corpName = $this->dtCorporate['nama'];

        $baseFolderImg = base_url("apps/img/" . strtolower($this->dtCorporate['nama']));

        if ($this->session->has('userdata')) {
            $this->hasLogin = true;
            $userId = $this->session->userdata['uid']; //user id/user akun
            $userJns = $this->session->userdata['ujs']; //jenis otoritas

            //get data user for session
            $dbhu = new DbHelperUser();
            if ($userJns == "user") {
                $dtUser = $dbhu->getUserForSession($userId);
            } else if ($userJns == "pegawai") {
                $dtUser = $dbhu->getPegawaiForSession($userId);
            } else {
                $dtUser = $dbhu->getTenagakerjaForSession($userId);
            }

            $userApp = [
                'id' => $dtUser->id,
                'uid' => $dtUser->uid, //user id or nama akun user
                'aid' => $dtUser->apps_id, // apps_id
                'oid' => $dtUser->otoritas_id, // otoritas_id
                'sid' => $dtUser->status_id, //status_id
                'uname' => $dtUser->uname,
                'ufoto' => $dtUser->foto,
                'apps' => $dtUser->nama_aplikasi,
                'logo' => $dtUser->logo,
                'brand' => $dtUser->brand,
                'otoritas' => strtoupper($dtUser->otorisasi),
                'unitkerja_id' => $dtUser->unitkerja_id,
                'unitkerja' => $dtUser->unitkerja,
                'data_unit_id' => $dtUser->data_unit_id,
                'data_akses_id' => $dtUser->data_akses_id,
                'data_akses_mitra' => $dtUser->data_akses_mitra
            ];

            //variabel for controller
            $this->user_id = $userApp['id'];
            $this->user_uid = $userApp['uid'];
            $this->oto_id = $userApp['oid'];
            $this->otoritas = $userApp['otoritas'];

            $this->appID = $userApp['aid'];
            $this->appName = $userApp['apps'];
            //dd($this->otoritas);
            //create data content for user

            /** Cek Foto Profile User */
            $fotoName = is_null($userApp['ufoto']) ? "no_foto.png" : $userApp['ufoto'];

            $pathFoto = "uploads/user/foto/$fotoName";
            $file = new \CodeIgniter\Files\File($pathFoto);

            if (!$file->isFile()) {
                $pathFoto = "uploads/user/no_foto.png";
            }
            $userApp['ufoto'] = $pathFoto;
            /** End Cek Foto Profile User */

            /* folder all upload image/foto for mitrakerja*/
            $blnThn = ambil_angka_bulan_tahun();

            $this->dtAksesMitra = $userApp['data_akses_id'];

            if ($this->otoritas == "PEGAWAI" || $this->otoritas == "TENAGAKERJA") {
                if ($userJns == "pegawai") {
                    $this->pathUploadImgApp = "./uploads/$this->appName/$blnThn";
                } else {
                    $folderMK = addZeroSpaces($userApp['data_akses_id'], "mk", 5);
                    $this->pathUploadImgApp = "./uploads/$this->appName/$folderMK/$blnThn";
                }
                //Cek if tenagakerja already absen
                $dbPresensi = new \App\Models\M_presensi();
                $dtPresensiAktif = $dbPresensi->getPresensiAktif($this->user_id);

                $appJS = loadJS("geolocation.js", "appjs");
                $appJS .= loadJS("mainpegawai.js", "appjs");

                $this->dtContent = [
                    'appName' => $this->appName,
                    'title' => $this->appName,
                    'page' => 'dashboard',
                    'dcCorporate' => $this->dtCorporate,
                    'dcCorpName' => $this->corpName,
                    'dcUser' => $userApp,
                    'dtPresensiAktif' => $dtPresensiAktif,
                    'dcBodyClass' => 'hold-transition layout-top-nav',
                    'baseFolderImg' => $baseFolderImg,
                    'appJSFoot' => $appJS
                ];
            } else {

                if ($this->otoritas != "TAMU") {
                    $this->dtAksesUnit = $userApp['data_unit_id'];
                }

                $menuModel = new M_menu;

                $appId = $this->appID;
                $aksesMenu = "#" . $userApp['oid'] . ",";
                $userMenu = $menuModel->getMenus($appId, $aksesMenu);

                $userApp['umenu'] = $userMenu;

                $this->dtContent = [
                    'appName' => $this->appName,
                    'title' => "Backoffice",
                    'page' => 'dashboard',
                    'dcCorporate' => $this->dtCorporate,
                    'dcCorpName' => $this->corpName,
                    'dcUser' => (array) $userApp,
                    'dcBodyClass' => 'hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed sidebar-collapse',
                    'baseFolderImg' => $baseFolderImg
                ];
            }
        } else {
            $this->hasLogin = false;

            $this->dtContent = [
                'appName' => $this->appName,
                'page' => 'login',
                'title' => 'Login To ' . $this->appFullName,
                'dcBodyClass' => 'hold-transition login-page bg-gradient',
                'baseFolderImg' => $baseFolderImg
            ];
        }
    }
}
