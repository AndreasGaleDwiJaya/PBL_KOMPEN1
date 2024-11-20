<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg" id="formContainer">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Form Tambah User</h4>
                </div>
                <div class="card-body">
                    <form id="formCreateUser" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan username">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan nama">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nip">NIP</label>
                                    <input type="text" name="nip" id="nip" class="form-control" placeholder="Masukkan NIP">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan email">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="level_id">Level</label>
                                    <select name="level_id" id="level_id" class="form-control">
    <option value="" disabled selected>Pilih Level</option>
    @foreach ($level as $lvl)
        <option value="{{ $lvl->level_id }}">{{ $lvl->level_nama }}</option>
    @endforeach
</select>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="avatar">Avatar</label>
                                    <input type="file" name="avatar" id="avatar" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button type="button" id="btnSubmit" class="btn btn-primary">Simpan</button>
                                <button type="button" id="btnCancel" class="btn btn-secondary">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Tombol Submit
        $('#btnSubmit').click(function() {
            let formData = new FormData($('#formCreateUser')[0]);

            $.ajax({
                url: "{{ route('user.store_ajax') }}",  // Ganti URL dengan route yang sesuai
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                        }).then(() => {
                            $('#formContainer').css('display', 'none'); // Menyembunyikan form setelah berhasil
                            $('#table_user').DataTable().ajax.reload(); // Refresh data tabel
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            html: '<ul>' + Object.values(response.errors).map(err => `<li>${err}</li>`).join('') + '</ul>',
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan pada server!',
                    });
                }
            });
        });

        // Fungsi untuk tombol Batal
        $('#btnCancel').click(function() {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Perubahan yang belum disimpan akan hilang.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Batalkan',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Reset form
                    $('#formCreateUser')[0].reset();

                    // Menyembunyikan form
                    $('#formContainer').css('display', 'none');  // Form hilang

                    // Menampilkan kembali halaman utama (misalnya, reload halaman)
                    window.location.reload(); // Reload halaman untuk menampilkan kembali halaman biasa
                }
            });
        });
    });
</script>
