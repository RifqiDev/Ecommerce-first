<!-- ./wrapper -->

  <!-- jQuery -->
  <script src="{{ url('lte/plugins/jquery/jquery.min.js') }}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{ url('lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- DataTables -->
  <script src="{{ url('lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ url('lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ url('lte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
  <script src="{{ url('lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ url('lte/dist/js/adminlte.min.js') }}"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{ url('lte/dist/js/demo.js') }}"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

  <!-- page script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
      "scrollX": true
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
