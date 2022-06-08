<?php
echo view('templates/head');

if ($page == "login") {
    echo view('pages/' . $page);
} else {
    if ($dcOtorisasi == "TENAGAKERJA") {
        echo view('templates/navbar_pegawai', $dcUser);
    } else {
        echo view('templates/navbar', $dcUser);
        echo view('templates/sidebar');
    }

    switch ($page) {
        case 'dashboard':
            $page = 'R3LBO/admin/dashboard/admin';
            break;

        default:
            # code...
            break;
    }

    echo view($page,  $dcUser);
    echo view('templates/footer');
}

echo view('templates/foot');
