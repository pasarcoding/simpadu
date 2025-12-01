@extends('admin.layouts.app')

@section('title', 'Sambutan')

@section('header')
    <style>
        .sign-image {
            display: flex;
            justify-content: end;
        }

        @media screen and (min-width: 1024px) {
            .sign-image {
                justify-content: start;
            }
        }
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item" aria-current="page">Sambutan</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-end gap-1">
                    @can(\App\Constants\PermissionName::village_official_greeting_delete())
                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
                            data-delete-url="{{ route('admin.village-official.greeting.delete') }}">Reset
                            <i class="ti ti-trash"></i></button>
                    @endcan
                    @can(\App\Constants\PermissionName::village_official_greeting_edit())
                        <a href="{{ route('admin.village-official.greeting.edit') }}" class="btn btn-sm btn-primary">Update Data
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
                            <div class="col-12 col-lg-5 mb-4">
                                <img src="{{ $data->image }}" alt="" class="img-fluid rounded-3 object-fit-cover"
                                    style="aspect-ratio: 9/7" />
                                {{-- <img src="https://wpndeso.rrdigital.id/wp-content/uploads/2023/08/Jokowi.webp"
                                    alt="" class="img-fluid rounded-3 object-fit-cover" style="aspect-ratio: 9/7" /> --}}
                            </div>
                            <div class="col-12 col-lg-7">
                                <div class="fw-semibold text-warning">
                                    Sambutan Pemimpin Desa.
                                </div>
                                <div class="fs-4 fw-bold mb-4">{{ $data->name }}</div>
                                <div class="mb-4">{{ $data->content }}</div>
                                {{-- <div class="fs-4 fw-bold mb-4">Ir. H. Jokowi Dodo</div> --}}
                                {{-- <div class="mb-4">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit
                                    tellus, luctus nec ullamcorper mattis, pulvinar dapibus Lorem
                                    ipsum dolor sit amet, consectetur adipiscing elit. Ut elit
                                    tellus, luctus nec ullamcorper mattis, pulvLorem ipsum dolor sit
                                    amet, consectetur adipiscing elit. Ut elit tellus, luctus nec
                                    ullamcorper mattis, pulvinar dapibus Lorem ipsum dolor sit amet,
                                    consectetur adipiscing elit. Ut elit tellus, luctus nec
                                    ullamcorper mattis, pulvinar dapibus leo Lorem ipsum dolor sit
                                    amet, consectetur adipiscing elit. Ut elit tellus, luctus nec
                                    ullamcorper mattis, pulvinar dapibus Lorem ipsum dolor sit amet,
                                    consectetur adipiscing elit. Ut elit tellus, luctus nec
                                    ullamcorper matti...
                                </div> --}}
                                <div class="sign-image">
                                    <img src="{{ $data->sign_image }}" alt="" style="width: 125px" />
                                    {{-- <img src="https://wpndeso.rrdigital.id/wp-content/uploads/2023/08/Tanda_tangan_bapak-e1692159927356-1536x849.png"
                                        alt="" style="width: 125px" /> --}}
                                </div>
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
                    Apakah Anda yakin ingin mereset data pengumuman ini? Aksi ini tidak dapat dibatalkan.
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
