<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Tambah Level Baru</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form id="form-create-level">
            <div class="modal-body">
                <div class="form-group">
                    <label for="level_kode">Kode Level</label>
                    <input type="text" class="form-control" id="level_kode" name="level_kode" required>
                </div>
                <div class="form-group">
                    <label for="level_nama">Nama Level</label>
                    <input type="text" class="form-control" id="level_nama" name="level_nama" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).on('submit', '#form-create-level', function(e) {
    e.preventDefault();

    let formData = $(this).serialize();

    $.ajax({
        url: "{{ route('level.store_ajax') }}",
        type: 'POST',
        data: formData,
        success: function(response) {
            if (response.status) {
                // Tutup modal
                $('#myModal').modal('hide');

                // Reload DataTable
                $('#table_level').DataTable().ajax.reload();

                // Tampilkan pesan sukses dengan SweetAlert2
                Swal.fire({
                    title: 'Berhasil!',
                    text: response.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            } else {
                // Tampilkan pesan error dengan SweetAlert2
                Swal.fire({
                    title: 'Gagal!',
                    text: response.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        },
        error: function(xhr) {
            // Tangani error pada AJAX
            Swal.fire({
                title: 'Terjadi Kesalahan!',
                text: 'Tidak dapat menyimpan data. Silakan coba lagi.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
});
</script>
