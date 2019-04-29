<script src="{!! url('../public/page/plugins/jQuery/jQuery-2.1.4.min.js') !!}" type="text/javascript"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="{!! url('../public/page/bootstrap/js/bootstrap.min.js') !!}" type="text/javascript"></script>
    <!-- DATA TABES SCRIPT -->
    <script src="{!! url('../public/page/plugins/datatables/jquery.dataTables.min.js') !!}" type="text/javascript"></script>
    <script src="{!! url('../public/page/plugins/datatables/dataTables.bootstrap.min.js') !!}" type="text/javascript"></script>
    <!-- SlimScroll -->
    <script src="{!! url('../public/page/plugins/slimScroll/jquery.slimscroll.min.js') !!}" type="text/javascript"></script>
    <!-- FastClick -->
    <script src="{!! url('../public/page/plugins/fastclick/fastclick.min.js') !!}" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="{!! url('../public/page/dist/js/app.min.js') !!}" type="text/javascript"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{!! url('../public/page/dist/js/demo.js') !!}" type="text/javascript"></script>
    <!-- page script -->
    <script type="text/javascript">
      $(function () {
        $("#example1").DataTable();
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });
      });
      jQuery(document).ready(function($) {
        // vẽ graph
  
      });
      
    </script>