<table class="table table-bordered table-hover" id="{{ $id }}">
    @if (isset($thead))
        {{ $thead }}
    @endif
    <tbody></tbody>
</table>
@push('scripts')
    <script src="{{ asset('webroot/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('webroot/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('webroot/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('webroot/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('webroot/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('webroot/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
@endpush
