<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-primary mt-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="user_add" class="btn btn-primary"><i class="fa fa-plus"></i> Data Pengguna Aplikasi</a>
                                <?= view('templates/notification'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-users mr-1"></i> DAFTAR <?= strtoupper($title); ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="def-table-1" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Aplikasi</th>
                                    <th>Nama Akun</th>
                                    <th>Nama Pengguna</th>
                                    <th>Otoritas</th>
                                    <th>Unit Kerja</th>
                                    <th>Data Akses Mitrakerja</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($dtUser as $row) {
                                    $idRow = $row['id'];

                                    $dt_akses = "NO AKSES";
                                    if ($row['data_akses_id'] == '9999') {
                                        $dt_akses = "FULL ACCESS";
                                    } else {
                                        $dt_akses = $row['data_akses'];
                                    }
                                ?>
                                    <tr>
                                        <td><?php echo $no; ?>.</td>
                                        <td><?php echo $row['aplikasi']; ?></td>
                                        <td><?php echo $row['uid']; ?></td>
                                        <td><?php echo $row['uname']; ?></td>
                                        <td><?php echo $row['otorisasi']; ?></td>
                                        <td><?php echo $row['unitkerja']; ?></td>
                                        <td><?php echo $dt_akses; ?></td>

                                        <td><?php echo $row['status']; ?></td>
                                        <td>
                                            <a href="<?php echo base_url('user_edit/' . $idRow); ?>" data-toggle="tooltip" data-placement="top" title="Edit">
                                                <button type="button" class="btn btn-success btn-xs"><i class="fa fa-edit"></i></button>
                                            </a>
                                            <a href="<?php echo base_url('user_delete/' . $idRow); ?>" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="return confirm('Hapus data <?= $title; ?> : <?php echo $row['uname']; ?> ?')">
                                                <button type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash-alt"></i></button>
                                            </a>
                                        </td>
                                    </tr>
                                <?php
                                    $no++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.section -->