   <?php $db->close();?>


    </div><!-- /#wrapper -->
    
    <!-- Highcharts -->
    <script src="option/Highcharts/js/highcharts.js"></script>
    <script src="option/Highcharts/js/modules/exporting.js"></script>

    <script src="option/js/bootstrap.js"></script>
    <script src="option/DataTables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="option/DataTables/dataTables.bootstrap4.min.js" type="text/javascript"></script>
    <!--select2-->
    <script src="option/select2/select2.full.min.js" type="text/javascript"></script>
    <script>
      $(document).ready(function () {
        $("#dbtable1").DataTable();
        $('#dbtable2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });
        $('#dbtable3').DataTable({
          "paging": false,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
        $(".select2").select2();
      });
    </script>
  </body>
</html>
