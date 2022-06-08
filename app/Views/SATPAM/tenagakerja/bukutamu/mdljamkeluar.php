<div class="modal fade" id="MdlSetKeluar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update Berkas <?php echo $title; ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <?= form_open('satpam_bukutamu_out'); ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <input class="form-control" type="hidden" name="up_id_tamu" id="up_id_tamu" readonly>
                <div class="form-group">
                    <label>Nama Tamu:</label>
                    <input class="form-control" type="text" id="up_nama_tamu" readonly>
                </div>
                <div class="form-group">
                    <label>Alamat :</label>
                    <textarea class="form-control" rows="3" id="up_alamat" readonly></textarea>
                </div>
                <div class="form-group">
                    <label>No Telpon :</label>
                    <input class="form-control" type="text" id="up_telepon" readonly>
                </div>
                <div class="form-group">
                    <label>Jam Masuk:</label>
                    <input type="text" class="form-control" id="up_jam_masuk" readonly>
                </div>
                <div class="form-group">
                    <label>Jam Keluar:</label>
                    <input type="text" class="form-control" name="up_jam_keluar" id="up_jam_keluar">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary pull-left">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>