@extends('admin.layouts.app')

@section('title', 'Template Surat')

@section('breadcrumb')
    <li class="breadcrumb-item" aria-current="page">Template Surat</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="alert alert-warning fade show" role="alert">
                <div class="d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                    href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    <span><strong>Perhatian!</strong> Perhatikan cara penggunaan berikut (klik):</span>
                    <i class="ti ti-chevron-down" style="font-size: 1rem;"></i>
                </div>
                <ul class="collapse" id="collapseExample">
                    <li>
                        Variabel di dalam file Word harus menggunakan <code>${format::name(Label)}</code>.
                    </li>
                    <li>
                        <span>Daftar Format yang Diizinkan:</span>
                        <ul>
                            <li><code>text</code>: Untuk input teks pendek (misalnya Nama, Jabatan).</li>
                            <li><code>image</code>: Untuk upload gambar/foto (misalnya Tanda Tangan, Foto KTP).</li>
                        </ul>
                    </li>
                    <li>
                        <span>Daftar Varibale Penduduk yang Diizinkan (otomatis terisi saat nik valid):</span>
                        <ul>
                            <li><code>{{ '${' . getLetterNumberVaribleTemplate() . '}' }}</code> (Hanya untuk munculkan
                                nomor
                                registrasi di surat)</li>
                            @foreach (getResidentVaribleTemplateList() as $k => $v)
                                <li><code>${text::{{ $v }}(Label)}</code></li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                @can(\App\Constants\PermissionName::e_letter_template_create())
                    <div class="card-header d-flex justify-content-end">
                        <a href="{{ route('admin.e-letter.template.create') }}" class="btn btn-sm btn-primary">Tambah Data <i
                                class="ti ti-plus"></i></a>
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
                                <th>Nama</th>
                                <th>Nomor Surat Terakhir</th>
                                <th>Data Formulir</th>
                                <th>Status</th>
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
                    Apakah Anda yakin ingin menghapus data template surat ini? Aksi ini tidak dapat dibatalkan.
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
                ajax: "{{ route('admin.e-letter.template.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'last_sequence_number',
                        name: 'last_sequence_number'
                    },
                    {
                        data: 'list_variables',
                        name: 'list_variables',
                        className: 'text-wrap',
                    },
                    {
                        data: 'status',
                        name: 'status'
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
