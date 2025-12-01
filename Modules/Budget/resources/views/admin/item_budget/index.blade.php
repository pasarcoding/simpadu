@extends('admin.layouts.app')

@section('title', 'Detail Anggaran')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.budget.index') }}">Transparasi Anggaran</a>
    </li>
    <li class="breadcrumb-item" aria-current="page">Detail Anggaran</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                @can(\App\Constants\PermissionName::budget_detail_create())
                    <div class="card-header d-flex justify-content-end">
                        <a href="{{ route('admin.budget.detail.create', $data->id) }}" class="btn btn-sm btn-primary">Tambah Data
                            <i class="ti ti-plus"></i></a>
                    </div>
                @endcan
                <div class="card-body">
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
                                <th>Tipe Anggaran</th>
                                <th>Nominal</th>
                                <th>Tanggal Transaksi</th>
                                <th>Catatan</th>
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
                    Apakah Anda yakin ingin menghapus data detail anggaran ini? Aksi ini tidak dapat dibatalkan.
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
@endsection

@section('footer')
    <script>
        $(document).ready(function() {
            $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                scrollX: true,
                ajax: "{{ route('admin.budget.detail.index', ':id') }}".replaceAll(':id',
                    '{{ $data->id }}'),
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'nominal',
                        name: 'nominal'
                    },
                    {
                        data: 'payment_at',
                        name: 'payment_at'
                    },
                    {
                        data: 'note',
                        name: 'note'
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
