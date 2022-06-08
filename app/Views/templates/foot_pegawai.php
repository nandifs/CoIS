<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="<?= path_alte(); ?>/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="<?= path_alte(); ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?= path_alte(); ?>/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

<!-- Plugins -->

<!-- Select2 -->
<script src="<?= path_alte(); ?>/plugins/select2/js/select2.full.min.js"></script>

<!-- AdminLTE App -->
<script src="<?= path_alte(); ?>/dist/js/adminlte.min.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="<?= path_alte(); ?>/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>

<!-- Overlay -->
<script src="<?= path_alte(); ?>/plugins/gasparesganga-jquery-loading-overlay/dist/loadingoverlay.min.js"></script>

<!-- App JS-->
<script src="<?= base_url(); ?>/apps/js/utils.js?v=1.0"></script>
<script src="<?= base_url(); ?>/apps/js/app.js?v=1.0"></script>
<?= (isset($appJSFoot)) ? $appJSFoot : '' ?>
</body>

</html>