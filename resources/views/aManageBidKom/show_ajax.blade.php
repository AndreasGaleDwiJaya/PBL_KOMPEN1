<div class="modal-dialog" style="max-width: 500px;">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail Bidang Kompetensi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span> <!-- Gambar silang -->
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="nama_bidkom">Nama Bidang Kompetensi</label>
                <input type="text" id="nama_bidkom" class="form-control" value="{{ $bidKom->nama_bidkom }}" readonly>
            </div>
        </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function () {
    // Hancurkan DataTable jika sudah ada
    if ($.fn.dataTable.isDataTable('#table_bidangkompetensi')) {
        $('#table_bidangkompetensi').DataTable().clear().destroy();
    }

    var dataUser = $('#table_bidangkompetensi').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ url('aManageBidangKompetensi/list') }}",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        },
        columns: [
            {
                data: "DT_RowIndex",
                className: "text-center",
                orderable: false,
                searchable: false
            },
            {
                data: "nama_bidkom",
                orderable: true,
                searchable: true
            },
            {
                data: "aksi",
                className: "text-center",
                orderable: false,
                searchable: false
            }
        ]
    });
});

</script>
