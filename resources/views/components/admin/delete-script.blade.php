<link rel="stylesheet" href="{{ asset('webroot/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
<script src="{{ asset('webroot/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        $(document).on("submit", ".delete-model", function(e) {
            e.preventDefault();
            const table_id = $(this).closest('table').attr('id');
            if (confirm('Really want to delete this model?')) {
                const action = $(this).attr('action');
                const data = $(this).serialize();
                $.ajax({
                    url: action,
                    method: 'DELETE',
                    data: data,
                    success: function(data) {
                        if (data.action) {
                            Toast.fire({
                                icon: 'success',
                                title: data.message
                            });
                            $(`#${table_id}`).DataTable().ajax.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        var err = eval("(" + xhr.responseText + ")");
                        if (status === "error") {
                            Toast.fire({
                                icon: 'error',
                                title: err.message
                            });
                        }
                    },
                });
            }
        });
    });
</script>
