@extends('admin.layouts.app')

@section('title', 'Visi & Misi')

@section('breadcrumb')
    <li class="breadcrumb-item" aria-current="page">Visi & Misi</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-end gap-1">
                    @can(\App\Constants\PermissionName::village_official_vision_mission_delete())
                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
                            data-delete-url="{{ route('admin.village-official.vision-mission.delete') }}">Reset
                            <i class="ti ti-trash"></i></button>
                    @endcan
                    @can(\App\Constants\PermissionName::village_official_vision_mission_edit())
                        <a href="{{ route('admin.village-official.vision-mission.edit') }}"
                            class="btn btn-sm btn-primary">Update Data
                            <i class="ti ti-edit"></i></a>
                    @endcan
                </div>
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

                    @if ($data->exists())
                        <div class="row">
                            <div class="col-12 mb-4">
                                <h4 class="text-center text-primary">Visi</h4>
                                {!! $data->vision !!}
                            </div>
                            <div class="col-12">
                                <h4 class="text-center text-primary">Misi</h4>
                                {!! $data->mission !!}
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-12 text-center">
                                <i>Data Tidak Tersedia, Silahkan Update Data.</i>
                            </div>
                        </div>
                    @endif
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
                    <h1 class="modal-title fs-5" id="deleteModalLabel">Konfirmasi Reset Data</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin mereset data visi & misi ini? Aksi ini tidak dapat dibatalkan.
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
        $('#deleteModal').on('show.bs.modal', function(event) {
            var buttonTrigger = $(event.relatedTarget);
            var deleteUrl = buttonTrigger.data('delete-url');

            $(this).find('form').attr('action', deleteUrl);
        });
    </script>
@endsection
