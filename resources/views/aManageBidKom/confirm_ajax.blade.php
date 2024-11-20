<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Konfirmasi Penghapusan</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p>Apakah Anda yakin ingin menghapus Bidang Kompetensi <strong>{{ $bidKom->nama_bidkom }}</strong>?</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <form action="{{ route('bidangKompetensi.destroy', $bidKom->bidkom_id) }}" method="POST" id="formDelete">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Hapus</button>
            </form>
        </div>
    </div>
</div>

<script>
    // Function untuk konfirmasi hapus data
    function confirmDelete(id) {
        $.ajax({
            url: '{{ route("bidangKompetensi.confirm_ajax", ":id") }}'.replace(':id', id),
            method: 'GET',
            success: function (data) {
                if (data.success) {
                    // Mengisi modal dengan data yang diterima
                    $('#myModal').find('.modal-body').html('<p>Apakah Anda yakin ingin menghapus Bidang Kompetensi <strong>' + data.nama_bidkom + '</strong>?</p>');
                    $('#formDelete').attr('action', '{{ route("bidangKompetensi.destroy", ":id") }}'.replace(':id', data.id));
                    $('#myModal').modal('show');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Data tidak ditemukan',
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan saat memuat data',
                });
            }
        });
    }

    // Function untuk menangani penghapusan data dengan SweetAlert
    $('#formDelete').submit(function (e) {
        e.preventDefault();

        // Tampilkan konfirmasi penghapusan dengan SweetAlert
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data ini akan dihapus secara permanen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function (response) {
                        if (response.success) {
                            // Menutup modal konfirmasi
                            $('#myModal').modal('hide');

                            // Menampilkan SweetAlert sukses
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Data berhasil dihapus.',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                // Opsional: Refresh halaman atau lakukan tindakan lain setelah penghapusan
                                location.reload();  // Refresh halaman
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan saat menghapus data.',
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan.',
                        });
                    }
                });
            }
        });
    });
</script>
