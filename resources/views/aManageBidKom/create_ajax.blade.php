<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Tambah Bidang Kompetensi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form id="formBidKom" action="{{ route('bidangKompetensi.store_ajax') }}" method="POST">
            <div class="modal-body">
                @csrf
                <div class="form-group">
                    <label for="nama_bidkom">Nama Bidang Kompetensi</label>
                    <input type="text" class="form-control" id="nama_bidkom" name="nama_bidkom" placeholder="Masukkan Nama Bidang Kompetensi" required>
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
    $(document).ready(function () {
        $('#formBidKom').on('submit', function (e) {
            e.preventDefault(); // Prevent form submission
            let formData = $(this).serialize();

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                success: function (response) {
                    if (response.success) {
                        // Menampilkan SweetAlert sukses
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Bidang Kompetensi berhasil ditambahkan.',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function() {
                            // Menutup modal
                            $('#myModal').modal('hide');
                            // Reload DataTable
                            $('#table_bidangkompetensi').DataTable().ajax.reload();
                        });
                    } else {
                        // Menampilkan SweetAlert jika gagal
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: response.message,
                        });
                    }
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi kesalahan!',
                        text: 'Silakan coba lagi.',
                    });
                }
            });
        });
    });
</script>
