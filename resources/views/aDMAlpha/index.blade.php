{{-- @extends('layouts.a_template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
    </div>
    <div class="card-body">
        @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table id="table-mhsalpha" class="table table-bordered table-striped table-hover table-sm">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Mahasiswa</th>
                    <th>Jumlah Jam Alpha</th>
                    <th>Periode</th>
                    <th>Prodi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
    data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('scripts')
<script>
    $('#table-mhsalpha').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ route("aDMAlpha.list") }}', // Memanggil rute DataTables
    columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
        { data: 'nama_mahasiswa', name: 'nama_mahasiswa' },
        { data: 'jumlah_jamalpha', name: 'jumlah_jamalpha' },
        { data: 'periode', name: 'periode' },
        { data: 'prodi', name: 'prodi' },
    ],
});
</script>
@endpush --}}



@extends('layouts.a_template')

@section('content')

<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">

<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        {{-- <div class="card-tools">
            <!-- Tombol Tambah -->
            <button onclick="modalAction('{{ route('bidangKompetensi.create_ajax') }}')" class="btn btn-success">
                <i class="fa fa-plus"></i> Tambah
            </button>
        </div> --}}
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success')}}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error')}}</div>
        @endif

        <table class="table table-bordered table-striped table-hover table-sm" id="table_bidangkompetensi">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Mahasiswa</th>
                    <th>Jumlah Jam Alpha</th>
                    <th>Periode</th>
                    <th>Prodi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Modal -->
<div id="myModal" 
    class="modal fade animate shake" 
    tabindex="-1" role="dialog" 
    data-backdrop="static" 
    data-keyboard="false" 
    aria-hidden="true">
</div>

@endsection

@push('js')
<script>
    // Fungsi untuk memuat modal
    function modalAction(url = '') {
        $('#myModal').load(url, function () {
            $('#myModal').modal('show');
        });
    }

    // Inisialisasi DataTables
    $(document).ready(function () {
        var dataUser = $('#table_mhsalpha').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('aDaftarMahasiswaAlpha/list') }}",
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
                    data: "mahasiswa_id.nama",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "jumlah_jamalpha",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "periode",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "prodi",
                    orderable: true,
                    searchable: true
                },
            ]
        });
    });
</script>
@endpush
