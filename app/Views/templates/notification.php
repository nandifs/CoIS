<?php if (session()->getFlashdata('danger')) : ?>
    <div class="alert alert-danger alert-dismissible mt-2">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?= session()->getFlashdata('danger'); ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('errors')) : ?>
    <div class="alert alert-danger alert-dismissible mt-2">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php
        $errors = session()->getFlashdata('errors');
        if (!empty($errors)) { ?>
            <ul>
                <?php foreach ($errors as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        <?php } ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('danger1')) : ?>
    <div class="alert alert-danger alert-dismissible mt-2">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-ban"></i> Hapus!</h4>
        <?= session()->getFlashdata('danger1'); ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('danger2')) : ?>
    <div class="alert alert-danger alert-dismissible mt-2">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-ban"></i> Perhatian!</h4>
        <?= session()->getFlashdata('danger2'); ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('info')) : ?>
    <div class="alert alert-info alert-dismissible mt-2">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-info"></i> Info!</h4>
        <?= session()->getFlashdata('info'); ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('warning')) : ?>
    <div class="alert alert-warning alert-dismissible mt-2">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-warning"></i> Perhatian!</h4>
        <?= session()->getFlashdata('warning'); ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible mt-2">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Berhasil!</h4>
        <?= session()->getFlashdata('success'); ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('success-validation-import')) : ?>
    <div class="alert alert-warning alert-dismissible mt-2">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-info"></i> VALIDASI DATA SELESAI!</h4>
        <?= session()->getFlashdata('success-validation-import'); ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('success-import')) : ?>
    <div class="alert alert-success alert-dismissible mt-2">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> IMPORT DATA SELESAI!</h4>
        <?= session()->getFlashdata('success-import'); ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('sweet')) {
    echo '<script type="text/javascript"> sweetAlert("' . session()->getFlashdata('sweet') . '");</script>';
} ?>

<?php if (session()->getFlashdata('sweeterror')) {
    echo '<script type="text/javascript"> sweetDangerAlert("' . session()->getFlashdata('sweeterror') . '");</script>';
} ?>

<?php if (session()->getFlashdata('msg_info')) {
    echo '<script type="text/javascript"> sweetAlertInfo("' . session()->getFlashdata('msg_info') . '");</script>';
} ?>