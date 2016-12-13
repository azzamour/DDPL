<!-- ============================================================== -->
<!-- End Right content here -->
<!-- ============================================================== -->
</div>
<!-- END wrapper -->
<script>
    var resizefunc = [];
</script>
<!-- jQuery  -->
<script src="<?php echo base_url(''); ?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url(''); ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(''); ?>assets/js/detect.js"></script>
<script src="<?php echo base_url(''); ?>assets/js/fastclick.js"></script>
<script src="<?php echo base_url(''); ?>assets/js/jquery.slimscroll.js"></script>
<script src="<?php echo base_url(''); ?>assets/js/jquery.blockUI.js"></script>
<script src="<?php echo base_url(''); ?>assets/js/waves.js"></script>
<script src="<?php echo base_url(''); ?>assets/js/wow.min.js"></script>
<script src="<?php echo base_url(''); ?>assets/js/jquery.nicescroll.js"></script>
<script src="<?php echo base_url(''); ?>assets/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo base_url(''); ?>assets/plugins/peity/jquery.peity.min.js"></script>
<!-- jQuery  -->
<script src="<?php echo base_url(''); ?>assets/plugins/waypoints/lib/jquery.waypoints.js"></script>
<script src="<?php echo base_url(''); ?>assets/plugins/counterup/jquery.counterup.min.js"></script>
<script src="<?php echo base_url(''); ?>assets/plugins/morris/morris.min.js"></script>
<script src="<?php echo base_url(''); ?>assets/plugins/raphael/raphael-min.js"></script>
<script src="<?php echo base_url(''); ?>assets/plugins/jquery-knob/jquery.knob.js"></script>
<script src="<?php echo base_url(''); ?>assets/pages/jquery.dashboard.js"></script>
<script src="<?php echo base_url(''); ?>assets/js/jquery.core.js"></script>
<script src="<?php echo base_url(''); ?>assets/js/jquery.app.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('.counter').counterUp({
            delay: 100,
            time: 1200
        });

        $(".knob").knob();

    });
</script>
<script type="text/javascript">
    $('.disabled').click(function (e) {
        e.preventDefault();
    })
</script>
<!--Form Wizard-->
<script src="<?php echo base_url(''); ?>assets/plugins/jquery.steps/js/jquery.steps.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(''); ?>assets/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<!--wizard initialization-->
<script src="<?php echo base_url(''); ?>assets/pages/jquery.wizard-init.js" type="text/javascript"></script>

<script src="<?php echo base_url(''); ?>assets/plugins/custombox/js/custombox.min.js"></script>
<script src="<?php echo base_url(''); ?>assets/plugins/custombox/js/legacy.min.js"></script>

<script src="<?php echo base_url(''); ?>assets/plugins/moment/moment.js"></script>
<script src="<?php echo base_url(''); ?>assets/plugins/timepicker/bootstrap-timepicker.js"></script>
<script src="<?php echo base_url(''); ?>assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="<?php echo base_url(''); ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url(''); ?>assets/plugins/clockpicker/js/bootstrap-clockpicker.min.js"></script>
<script src="<?php echo base_url(''); ?>assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url(''); ?>assets/pages/jquery.form-pickers.init.js"></script>

<script src="<?php echo base_url(''); ?>assets/plugins/tablesaw/js/tablesaw.js"></script>
<script src="<?php echo base_url(''); ?>assets/plugins/tablesaw/js/tablesaw-init.js"></script>

<script src="<?php echo base_url(''); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(''); ?>assets/plugins/datatables/dataTables.bootstrap.js"></script>

<script src="<?php echo base_url(''); ?>assets/plugins/datatables/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(''); ?>assets/plugins/datatables/buttons.bootstrap.min.js"></script>
<script src="<?php echo base_url(''); ?>assets/plugins/datatables/jszip.min.js"></script>
<script src="<?php echo base_url(''); ?>assets/plugins/datatables/pdfmake.min.js"></script>
<script src="<?php echo base_url(''); ?>assets/plugins/datatables/vfs_fonts.js"></script>
<script src="<?php echo base_url(''); ?>assets/plugins/datatables/buttons.html5.min.js"></script>
<script src="<?php echo base_url(''); ?>assets/plugins/datatables/buttons.print.min.js"></script>
<script src="<?php echo base_url(''); ?>assets/plugins/datatables/dataTables.fixedHeader.min.js"></script>
<script src="<?php echo base_url(''); ?>assets/plugins/datatables/dataTables.keyTable.min.js"></script>
<script src="<?php echo base_url(''); ?>assets/plugins/datatables/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url(''); ?>assets/plugins/datatables/responsive.bootstrap.min.js"></script>
<script src="<?php echo base_url(''); ?>assets/plugins/datatables/dataTables.scroller.min.js"></script>
<script src="<?php echo base_url(''); ?>assets/plugins/datatables/dataTables.colVis.js"></script>
<script src="<?php echo base_url(''); ?>assets/plugins/datatables/dataTables.fixedColumns.min.js"></script>

<script src="<?php echo base_url(''); ?>assets/plugins/magnific-popup/js/jquery.magnific-popup.min.js"></script>
<script src="<?php echo base_url(''); ?>assets/plugins/jquery-datatables-editable/jquery.dataTables.js"></script>
<script src="<?php echo base_url(''); ?>assets/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url(''); ?>assets/plugins/tiny-editable/mindmup-editabletable.js"></script>
<script src="<?php echo base_url(''); ?>assets/plugins/tiny-editable/numeric-input-example.js"></script>


<script src="<?php echo base_url(''); ?>assets/pages/datatables.editable.init.js"></script>

<script>
    $('#mainTable').editableTableWidget().numericInputExample().find('td:first').focus();

</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#datatable').dataTable();
        $('#datatable-keytable').DataTable({keys: true});
        $('#datatable-responsive').DataTable();
        $('#datatable-colvid').DataTable({
            "dom": 'C<"clear">lfrtip',
            "colVis": {
                "buttonText": "Change columns"
            }
        });
        $('#datatable-scroller').DataTable({
            ajax: "assets/plugins/datatables/json/scroller-demo.json",
            deferRender: true,
            scrollY: 380,
            scrollCollapse: true,
            scroller: true
        });
        var table = $('#datatable-fixed-header').DataTable({fixedHeader: true});
        var table = $('#datatable-fixed-col').DataTable({
            scrollY: "300px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            fixedColumns: {
                leftColumns: 1,
                rightColumns: 1
            }
        });
    });
    TableManageButtons.init();
</script>

<script>
    $('#mainTable').editableTableWidget().numericInputExample().find('td:first').focus();
</script>

</body>
</html>
