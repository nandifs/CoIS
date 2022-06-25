<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="<?= path_alte(); ?>/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="<?= path_alte(); ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?= path_alte(); ?>/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

<!-- AdminLTE App -->
<script src="<?= path_alte(); ?>/dist/js/adminlte.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="<?= path_alte(); ?>/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="<?= path_alte(); ?>/plugins/raphael/raphael.min.js"></script>
<script src="<?= path_alte(); ?>/plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="<?= path_alte(); ?>/plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="<?= path_alte(); ?>/plugins/chart.js/Chart.min.js"></script>

<!-- SweetAlert2 -->
<script src="<?= path_alte(); ?>/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="<?= path_alte(); ?>/plugins/toastr/toastr.min.js"></script>

<!-- App JS-->
<?= (isset($appJSFootBefore)) ? $appJSFootBefore : '' ?>
<script src="<?= base_url(); ?>/apps/js/utils.js"></script>
<script src="<?= base_url(); ?>/apps/js/app.js"></script>
<?= (isset($appJSFoot)) ? $appJSFoot : '' ?>
</body>

</html>