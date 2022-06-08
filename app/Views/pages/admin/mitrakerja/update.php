<div class="form-group">
    <input type="hidden" id="data_id" name="data_id" readonly />
    <label for="kelas_id">Dibawah Unit Kerja</label>
    <select class="form-control" id="unitkerja_id" name='unitkerja_id'>
        <option value=0>PILIH UNIT KERJA</option>
        <?php foreach ($dtUnitker as $unker) { ?>
            <option value="<?= $unker['id']; ?>"><?= $unker['singkatan']; ?></option>
        <?php } ?>
    </select>
</div>
<div class="form-group">
    <label for="input1">Nama Lengkap Mitra Kerja/Pengguna Jasa</label>
    <input type="text" class="form-control" id="nama_mitrakerja" name="nama_mitrakerja" placeholder="Masukan nama lengkap mitra kerja." required />
</div>
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-copy"></i> Detail Unit Kerja</h3>
    </div>
    <div class="card-body">
        <div class="form-group row">
            <label for="nama_singkat" class="col-sm-3 col-form-label">Nama Singkat</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="nama_singkat" name="nama_singkat" placeholder="Masukan nama singkat mitra kerja." required>
            </div>
        </div>
        <div class="form-group row">
            <label for="kelas_id" class="col-sm-3 col-form-label">Kelas Unit</label>
            <input type="hidden" id="pre_kelas_id" name="pre_kelas">
            <div class="col-sm-9">
                <select class="form-control" id="kelas_id" name='kelas_id'>
                    <option value="1" selected>PUSAT/UTAMA</option>
                    <option value="2">CABANG</option>
                    <option value="3">RANTING</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="induk_id" class="col-sm-3 col-form-label">Unit Induk</label>
            <input type="hidden" id="pre_induk_id" name="pre_induk_id">
            <input type="hidden" id="kode_unit" name="kode_unit">
            <div class="col-sm-9">
                <select class="form-control" id='induk_id' name='induk_id'>
                    <option value="0" selected>PILIH INDUK UNIT</option>
                </select>
            </div>
        </div>
    </div>
</div>