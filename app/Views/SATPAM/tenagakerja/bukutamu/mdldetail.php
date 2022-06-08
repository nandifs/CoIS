<div class="modal fade" id="MdlDetailTamu">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="card card-success card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-foto img-rounded img-fluid img-responsive" id="img_foto_tamu" src="<?php echo base_url(); ?>/uploads/noimage.jpg" alt="Foto Tamu">
                        </div>
                        <h3 class="profile-username text-center" id="lbl_nama_tamu"></h3>

                        <p class="text-muted text-center" id="lbl_instansi"></p>

                        <table class="table table-striped">
                            <tr>
                                <td style="width: 150px">Alamat</td>
                                <td style="width: 20px">:</td>
                                <td><a id="lbl_alamat">Alamat</a></td>
                            </tr>
                            <tr>
                                <td>Telepon</td>
                                <td>:</td>
                                <td><a id="lbl_telepon">Telepon</a></td>
                            </tr>
                            <tr>
                                <td>Bertemu dengan</td>
                                <td>:</td>
                                <td><a id="lbl_bertemu">Bertemu</a></td>
                            </tr>
                            <tr>
                                <td>Keperluan</td>
                                <td>:</td>
                                <td><a id="lbl_keperluan">Keperluan</a></td>
                            </tr>
                            <tr>
                                <td>Jam Datang</td>
                                <td>:</td>
                                <td><a id="lbl_jam_masuk">Jam Datang</a></td>
                            </tr>
                            <tr>
                                <td>Jam Pulang</td>
                                <td>:</td>
                                <td><a id="lbl_jam_keluar">Jam Pulang</a></td>
                            </tr>
                            <tr>
                                <td>Foto Identitas/KTP</td>
                                <td>:</td>
                                <td><a><img class="img-foto img-responsive" id="img_foto_id" src="<?= base_url('/uploads') . '/noimage.jpg'; ?>" alt="Foto Identitas"></a></td>
                            </tr>
                            <tr>
                                <td>Tanda tangan</td>
                                <td>:</td>
                                <td><a><img class="img-foto img-responsive" id="img_ttd" src="<?= base_url('/uploads') . '/noimage.jpg'; ?>" alt="TTD"></a></td>
                            </tr>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>