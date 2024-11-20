<div class="modal-dialog" style="max-width: 500px;">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit Level</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span> <!-- Gambar silang -->
            </button>
        </div>
        <form id="formEdit" method="POST" action="{{ route('level.update_ajax', $level->level_id) }}">
            @csrf
            @method('PUT') <!-- Pastikan metode adalah PUT -->
            <div class="modal-body">
                <div class="form-group">
                    <label for="level_kode">Level Kode</label>
                    <input 
                        type="text" 
                        name="level_kode" 
                        id="level_kode" 
                        class="form-control" 
                        value="{{ $level->level_kode }}" 
                        placeholder="Masukkan kode level" 
                        required>
                </div>
                <div class="form-group">
                    <label for="level_nama">Level Nama</label>
                    <input 
                        type="text" 
                        name="level_nama" 
                        id="level_nama" 
                        class="form-control" 
                        value="{{ $level->level_nama }}" 
                        placeholder="Masukkan nama level" 
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
                // Jika sukses, tutup modal dan tampilkan pesan sukses
                $('#myModal').modal('hide'); // Tutup modal
                $('#table_level').DataTable().ajax.reload(); // Reload DataTable setelah update
                Swal.fire('Berhasil!', response.message, 'success'); // SweetAlert untuk pesan sukses
            },
            error: function (xhr) {
                // Menangani error dan menampilkan pesan menggunakan SweetAlert
                let message = xhr.responseJSON.message || 'Terjadi kesalahan.';
                Swal.fire('Gagal!', message, 'error'); // SweetAlert untuk pesan error
            }
        });
    });
</script>
