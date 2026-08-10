    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Scripts Propios -->
    <script src="assets/js/script.js"></script>
    <script src="assets/js/tickets.js"></script>

    <script>
        $(document).ready(function() {
            if ($('.datatable').length > 0) {
                $('.datatable').DataTable({
                    "language": {
                        "url": "https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
                    },
                    "order": [[0, "desc"]],
                    "paging": false,
                    "info": false,
                    "lengthChange": false,
                    "searching": false
                });
            }
        });
    </script>
</body>
</html>
