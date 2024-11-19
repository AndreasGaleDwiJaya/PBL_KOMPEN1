<div class="modal-dialog" style="max-width: 500px;">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit Bidang Kompetensi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span> <!-- Gambar silang -->
            </button>
        </div>
        <form id="formEdit" method="POST" action="{{ route('bidangKompetensi.update_ajax', $bidKom->bidkom_id) }}">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label for="nama_bidkom">Nama Bidang Kompetensi</label>
                    <input 
                        type="text" 
                        name="nama_bidkom" 
                        id="nama_bidkom" 
                        class="form-control" 
                        value="{{ $bidKom->nama_bidkom }}" 
                        placeholder="Masukkan nama bidang kompetensi" 
                        required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>



<script>
    // Proses Submit Form Edit
    $(document).on('submit', '#formEdit', function (e) {
        e.preventDefault();

        let form = $(this);
        let url = form.attr('action');
        let formData = form.serialize();

        // AJAX Request
        $.ajax({
            url: url,
            method: 'PUT',
            data: formData,
            success: function (response) {
                $('#myModal').modal('hide'); // Tutup Modal
                $('#table_bidangkompetensi').DataTable().ajax.reload(); // Reload DataTables
                Swal.fire('Berhasil!', response.success, 'success'); // Tampilkan pesan sukses
            },
            error: function (xhr) {
                // Tampilkan pesan error
                let message = xhr.responseJSON.error || 'Terjadi kesalahan.';
                Swal.fire('Gagal!', message, 'error');
            }
        });
    });
</script>
