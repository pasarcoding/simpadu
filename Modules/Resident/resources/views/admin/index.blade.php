@extends('admin.layouts.app')

@section('title', 'Data Penduduk')

@section('breadcrumb')
    <li class="breadcrumb-item" aria-current="page">Data Penduduk</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-end w-100">
                    <div class="d-flex gap-2 overflow-x-auto flex-nowrap" style="max-width: 100%;">
                        @can(\App\Constants\PermissionName::resident_delete())
                            <a href="{{ route('admin.resident.reset') }}" class="btn btn-sm btn-danger text-nowrap"
                                data-bs-toggle="modal" data-bs-target="#resetModal">Reset Data
                                <i class="ti ti-trash"></i></a>
                        @endcan
                        @can(\App\Constants\PermissionName::resident_form_view())
                            <a href="{{ route('admin.resident.form.index') }}" class="btn btn-sm btn-danger text-nowrap">Tambah
                                Form
                                <i class="ti ti-forms"></i></a>
                        @endcan
                        @can(\App\Constants\PermissionName::resident_import_view())
                            <a href="{{ route('admin.resident.import') }}" class="btn btn-sm btn-success text-nowrap">Import
                                Data
                                <i class="ti ti-file-upload"></i></a>
                        @endcan
                        @can(\App\Constants\PermissionName::resident_export_view())
                            <a href="{{ route('admin.resident.export', ['village' => $villageQuery, 'age' => $ageQuery]) }}"
                                class="btn btn-sm btn-warning text-nowrap">Export
                                Data <i class="ti ti-file-download"></i></a>
                        @endcan
                        @can(\App\Constants\PermissionName::resident_create())
                            <a href="{{ route('admin.resident.create') }}" class="btn btn-sm btn-primary text-nowrap">Tambah
                                Data
                                <i class="ti ti-plus"></i></a>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <form method="GET"
                        class="d-flex flex-column flex-md-row align-items-stretch align-items-md-center gap-0 gap-md-3 w-100">
                        <div class="form-group flex-grow-1">
                            <select name="village" id="" class="form-control select2"
                                style="width: 100%!important;">
                                <option value="">-- Pilih Dusun --</option>
                                @foreach ($villages as $item)
                                    <option value="{{ $item }}" {{ $item == $villageQuery ? 'selected' : '' }}>
                                        {{ ucwords($item) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group flex-grow-1">
                            <input type="number" name="age" class="form-control" placeholder="Masukkan Umur"
                                value="{{ $ageQuery }}">
                        </div>
                        <div class="form-group flex-shrink-0 d-flex gap-2">
                            <button type="submit"
                                class="btn btn-primary d-flex justify-content-center align-items-center gap-2 flex-grow-1">Tampilkan
                                <i class="ti ti-search"></i></button>
                            <a href="{{ route('admin.resident.index') }}"
                                class="btn btn-danger d-flex justify-content-center align-items-center gap-2 flex-shrink-0">Reset
                                <i class="ti ti-x"></i></a>
                        </div>
                    </form>

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Gagal!</strong> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Berhasil!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <table class="table table-striped table-bordered text-nowrap datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                {{-- <th>Foto Penduduk</th> --}}
                                <th>No.KK</th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>Tempat, Tanggal Lahir</th>
                                <th>Rt/Rw</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteModalLabel">Konfirmasi Hapus Data</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus data penduduk ini? Aksi ini tidak dapat dibatalkan.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus Data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Reset Modal -->
    <div class="modal fade" id="resetModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="resetModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="resetModalLabel">Konfirmasi Reset Data</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin me-reset data penduduk ini? Aksi ini tidak dapat dibatalkan.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form method="POST" action="{{ route('admin.resident.reset') }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Reset Data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        $(document).ready(function() {
            $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                scrollX: true,
                ajax: "{{ route('admin.resident.index') }}?village={{ $villageQuery }}&age={{ $ageQuery }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    // {
                    //     data: 'image',
                    //     name: 'image',
                    //     orderable: false,
                    //     searchable: false
                    // },
                    {
                        data: 'family_card_number',
                        name: 'family_card_number'
                    },
                    {
                        data: 'national_id',
                        name: 'national_id'
                    },
                    {
                        data: 'full_name',
                        name: 'full_name'
                    },
                    {
                        data: 'gender',
                        name: 'gender'
                    },
                    {
                        data: 'birth',
                        name: 'birth',
                    },
                    {
                        data: 'rt_rw',
                        name: 'rt_rw',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
            });
        });

        $('#deleteModal').on('show.bs.modal', function(event) {
            var buttonTrigger = $(event.relatedTarget);
            var deleteUrl = buttonTrigger.data('delete-url');

            $(this).find('form').attr('action', deleteUrl);
        });
    </script>
@endsection
