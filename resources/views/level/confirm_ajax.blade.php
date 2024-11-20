<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Konfirmasi Penghapusan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p>Apakah Anda yakin ingin menghapus data level berikut?</p>
            <ul>
                <li><strong>Kode Level:</strong> {{ $level->level_kode }}</li>
                <li><strong>Nama Level:</strong> {{ $level->level_nama }}</li>
            </ul>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-danger" id="btnDeleteLevel" data-id="{{ $level->level_id }}">Hapus</button>
        </div>
    </div>
</div>

<script>
    // Menangani klik tombol Hapus untuk konfirmasi SweetAlert2
    $(document).on('click', '#btnDeleteLevel', function() {
        const levelId = $(this).data('id');
        const url = `{{ url('level') }}/${levelId}/delete_ajax`;

        // Tampilkan konfirmasi dengan SweetAlert2
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data ini akan dihapus secara permanen.",
            icon: 'warning',
            showCancelButton: true, // Tombol Batal akan muncul
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true, // Membalik urutan tombol
            customClass: {
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-secondary'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Lakukan AJAX jika konfirmasi hapus diterima
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}', // Sertakan token CSRF
                    },
                    success: function(response) {
                        if (response.status) {
                            // Tampilkan pesan sukses dengan SweetAlert
                            Swal.fire({
                                title: 'Dihapus!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                            // Reload tabel setelah penghapusan
                            dataLevel.ajax.reload(); 
                            // Tutup modal setelah berhasil
                            $('#myModal').modal('hide');
                        } else {
                            // Tampilkan pesan error dengan SweetAlert
                            Swal.fire({
                                title: 'Gagal!',
                                text: response.message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function() {
                        // Tampilkan pesan error jika AJAX gagal
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat menghapus data.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });
    });
</script>
