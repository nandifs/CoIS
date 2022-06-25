<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="<?= path_alte(); ?>/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="<?= path_alte(); ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?= path_alte(); ?>/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- date-range-picker -->
<script src="<?= path_alte(); ?>/plugins/daterangepicker/daterangepicker.js"></script>

<!-- DataTables  & Plugins -->
<script src="<?= path_alte(); ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= path_alte(); ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= path_alte(); ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= path_alte(); ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?= path_alte(); ?>/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= path_alte(); ?>/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?= path_alte(); ?>/plugins/jszip/jszip.min.js"></script>
<script src="<?= path_alte(); ?>/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?= path_alte(); ?>/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?= path_alte(); ?>/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?= path_alte(); ?>/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?= path_alte(); ?>/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<!-- Select2 -->
<script src="<?= path_alte(); ?>/plugins/select2/js/select2.full.min.js"></script>

<!-- AdminLTE App -->
<script src="<?= path_alte(); ?>/dist/js/adminlte.min.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="<?= path_alte(); ?>/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="<?= path_alte(); ?>/plugins/raphael/raphael.min.js"></script>
<script src="<?= path_alte(); ?>/plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="<?= path_alte(); ?>/plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="<?= path_alte(); ?>/plugins/chart.js/Chart.min.js"></script>

<!-- Overlay -->
<script src="<?= path_alte(); ?>/plugins/gasparesganga-jquery-loading-overlay/dist/loadingoverlay.min.js"></script>

<!-- App JS-->
<?= (isset($appJSFootBefore)) ? $appJSFootBefore : '' ?>
<script src="<?= base_url(); ?>/apps/js/utils.js?v=1.0"></script>
<script src="<?= base_url(); ?>/apps/js/app.js?v=1.0"></script>
<?= (isset($appJSFoot)) ? $appJSFoot : '' ?>
</body>

</html>