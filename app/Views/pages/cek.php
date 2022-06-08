<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SATPAM | Tambah Buku Tamu</title>
    <link rel="icon" href="http://localhost:8080/apps/img/mmui/favicon.ico" type="image/gif">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="http://localhost:8080/AdminLTE-3.1.0/plugins/fontawesome-free/css/all.min.css">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="http://localhost:8080/AdminLTE-3.1.0/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="http://localhost:8080/AdminLTE-3.1.0/plugins/toastr/toastr.min.css">

    <!-- Select2 -->
    <link rel="stylesheet" href="http://localhost:8080/AdminLTE-3.1.0/plugins/select2/css/select2.min.css">

    <!-- DataTables -->
    <link rel="stylesheet" href="http://localhost:8080/AdminLTE-3.1.0/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="http://localhost:8080/AdminLTE-3.1.0/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="http://localhost:8080/AdminLTE-3.1.0/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="http://localhost:8080/AdminLTE-3.1.0/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="http://localhost:8080/AdminLTE-3.1.0/dist/css/adminlte.min.css">

    <!-- Apps CSS -->
    <link rel="stylesheet" href="http://localhost:8080/apps/css/style.css">
    <link rel="stylesheet" href="http://localhost:8080/apps/plugins/webcam-easy/css/webcam-app.css" />
    <link rel="stylesheet" href="http://localhost:8080/apps/plugins/signature-pad/jquery.signaturepad.css" />
    <link rel="stylesheet" href="http://localhost:8080/apps/css/bukutamu.css" />

    <!-- SweetAlert2 -->
    <script src="http://localhost:8080/AdminLTE-3.1.0/plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="http://localhost:8080/AdminLTE-3.1.0/plugins/toastr/toastr.min.js"></script>

    <!-- Sweet Alert JS-->
    <script src="http://localhost:8080/apps/js/sweetalert.js"></script>
</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <a href="/" class="navbar-brand">
                <img src="http://localhost:8080/apps/img/satpam/ic_logo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light"><b>SATPAM</b></span>
            </a>

            <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="/" class="nav-link">Home</a>
                    </li>
                </ul>

                <!-- SEARCH FORM -->
                <form class="form-inline ml-3">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown user-menu">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                            <img src="http://localhost:8080/uploads/user/foto/no_foto.png" class="user-image img-circle elevation-2" alt="User Image">
                            <span class="d-none d-md-inline">HERMANSYAH</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <!-- User image -->
                            <li class="user-header bg-primary">
                                <img src="http://localhost:8080/uploads/user/foto/no_foto.png" class="img-circle elevation-2" alt="User Image">

                                <p>
                                    HERMANSYAH - TENAGAKERJA <small>PT. MMUI CAB. JABAR</small>
                                </p>
                            </li>

                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                                <a href="http://localhost:8080/login/user_logout" class="btn btn-default btn-flat float-right">Keluar</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- /.navbar -->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">TAMBAH BUKU TAMU</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/">Home</a></li>
                                <li class="breadcrumb-item"><a href="/satpam_buku_tamu">Buku Tamu</a></li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Form Tambah Data</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="http://localhost:8080/satpam_bukutamu_save" class="form-horizontal" id="form-bukutamu" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                            <input type="hidden" name="app_csrf" value="1606d9003fab3888210f82a150b962b7" />
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Hari, Tanggal :</label>
                                            <input class="form-control" type="text" name="tglindo" value="Sabtu, 15 Januari 2022" readonly>
                                            <input class="form-control" type="hidden" name="tanggal" value="2022-01-15">
                                        </div>
                                        <div class="form-group">
                                            <label>Nama Tamu:</label>
                                            <input class="form-control" type="text" name="nama_tamu">
                                        </div>
                                        <div class="form-group">
                                            <label>Alamat :</label>
                                            <textarea class="form-control" rows="3" name="alamat"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>No Telpon :</label>
                                            <input class="form-control" type="text" name="telp" id="telp">
                                        </div>
                                        <div class="form-group">
                                            <label>Pekerjaan/Instansi :</label>
                                            <input type="text" name="instansi" class="form-control" id="instansi">
                                        </div>
                                        <div class="form-group">
                                            <label>Bertemu dengan :</label>
                                            <input type="text" name="bertemu" class="form-control" id="bertemu">
                                        </div>
                                        <div class="form-group">
                                            <label>Keperluan :</label>
                                            <textarea class="form-control" rows="3" name="keperluan"></textarea>
                                        </div>
                                        <div class="form-group row">
                                            <label for="jam_masuk" class="col-sm-3 col-form-label">Jam Datang:</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="jam_masuk" value="18:44:50" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="jam_keluar" class="col-sm-3 col-form-label">Jam Keluar:</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="jam_keluar" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Foto KTP/Identitas:</label>
                                            <div style="text-align:center;">
                                                <div class="img-foto" id="foto1"></div>
                                                <input type=button class="btn btn-xs btn-primary" id="getfoto1" value="Ambil Foto" style="display: inline-block; position:absolute; margin-top:-40px; margin-left:-20px;">
                                            </div>
                                            <input type="hidden" class="form-control" name="urifoto1" id="urifoto1">
                                        </div>
                                        <div class="form-group">
                                            <label>Foto Tamu:</label>
                                            <div class="img-foto" id="foto2"></div>
                                            <div style="text-align:center;">
                                                <input type=button class="btn btn-xs btn-primary" id="getfoto2" value="Ambil Foto" style="display: inline-block; position:absolute; margin-top:-40px; margin-left:-20px;">
                                            </div>
                                            <input type="hidden" class="form-control" name="urifoto2" id="urifoto2">
                                        </div>
                                        <div class="form-group">
                                            <div id="signArea" class="sign-area">
                                                <ul class="sigNav">
                                                    <li><b>Tanda Tangan</b></li>
                                                    <li class="clearButton"><a href="#clear">Ulangi</a></li>
                                                </ul>
                                                <div class="sig sigWrapper" style="height:auto;">
                                                    <div class="typed"></div>
                                                    <canvas class="sigPad" id="sign-pad"></canvas>
                                                </div>
                                                <textarea class="form-control" name="urittd" id="ttd_tamu" style="display:none;"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="button" class="btn btn-default" onclick="window.history.back()">Batal</button>
                                <button type="submit" class="btn btn-success float-right mr-1" id="btnSubmit">Simpan</button>
                            </div>
                            <!-- /.card-footer -->
                        </form>
                        <div class="md-modal md-effect-12">
                            <div id="app-panel" class="app-panel md-content row p-0 m-0">
                                <div id="webcam-container" class="webcam-container col-12 d-none p-0 m-0">
                                    <video id="webcam" autoplay playsinline width="640" height="480"></video>
                                    <canvas id="canvas" class="d-none"></canvas>
                                    <div class="flash"></div>
                                </div>
                                <div id="cameraControls" class="cameraControls">
                                    <a href="#" id="take-photo" title="Take Photo"><i class="material-icons">camera_alt</i></a>
                                    <button id="cameraFlip" class="btn d-none"></button>
                                </div>
                            </div>
                        </div>
                        <div class="md-overlay"></div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.section -->
        </div>

        <!-- Main Footer -->
        <footer class="main-footer text-sm">
            <b>Apps. Ver.</b> 1.0.0 With
            <b>AdminLTE Ver.</b> 3.1.0

            <div class="float-right d-none d-sm-inline-block">
                <strong>Copyright &copy; 2019-2022 <a href="#">MMUI</a>.</strong>
                All rights reserved.
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="http://localhost:8080/AdminLTE-3.1.0/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="http://localhost:8080/AdminLTE-3.1.0/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="http://localhost:8080/AdminLTE-3.1.0/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

    <!-- DataTables  & Plugins -->
    <script src="http://localhost:8080/AdminLTE-3.1.0/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="http://localhost:8080/AdminLTE-3.1.0/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="http://localhost:8080/AdminLTE-3.1.0/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="http://localhost:8080/AdminLTE-3.1.0/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="http://localhost:8080/AdminLTE-3.1.0/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="http://localhost:8080/AdminLTE-3.1.0/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="http://localhost:8080/AdminLTE-3.1.0/plugins/jszip/jszip.min.js"></script>
    <script src="http://localhost:8080/AdminLTE-3.1.0/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="http://localhost:8080/AdminLTE-3.1.0/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="http://localhost:8080/AdminLTE-3.1.0/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="http://localhost:8080/AdminLTE-3.1.0/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="http://localhost:8080/AdminLTE-3.1.0/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

    <!-- Select2 -->
    <script src="http://localhost:8080/AdminLTE-3.1.0/plugins/select2/js/select2.full.min.js"></script>

    <!-- AdminLTE App -->
    <script src="http://localhost:8080/AdminLTE-3.1.0/dist/js/adminlte.min.js"></script>

    <!-- PAGE PLUGINS -->
    <!-- jQuery Mapael -->
    <script src="http://localhost:8080/AdminLTE-3.1.0/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
    <script src="http://localhost:8080/AdminLTE-3.1.0/plugins/raphael/raphael.min.js"></script>
    <script src="http://localhost:8080/AdminLTE-3.1.0/plugins/jquery-mapael/jquery.mapael.min.js"></script>
    <script src="http://localhost:8080/AdminLTE-3.1.0/plugins/jquery-mapael/maps/usa_states.min.js"></script>
    <!-- ChartJS -->
    <script src="http://localhost:8080/AdminLTE-3.1.0/plugins/chart.js/Chart.min.js"></script>

    <!-- Overlay -->
    <script src="http://localhost:8080/AdminLTE-3.1.0/plugins/gasparesganga-jquery-loading-overlay/dist/loadingoverlay.min.js"></script>

    <!-- App JS-->
    <script src="http://localhost:8080/apps/js/utils.js"></script>
    <script src="http://localhost:8080/apps/js/app.js"></script>
    <script src="http://localhost:8080/apps/plugins/webcam-easy/js/webcam-easy.min.js"></script>
    <script src="http://localhost:8080/apps/plugins/signature-pad/bezier.js"></script>
    <script src="http://localhost:8080/apps/plugins/signature-pad/numeric-1.2.6.min.js"></script>
    <script src="http://localhost:8080/apps/plugins/signature-pad/jquery.signaturepad.js"></script>
    <script src="http://localhost:8080/apps/js/webcam-easy.app.js"></script>
    <script src="http://localhost:8080/apps/js/satpam/bukutamuupdate.js"></script>
</body>

</html>