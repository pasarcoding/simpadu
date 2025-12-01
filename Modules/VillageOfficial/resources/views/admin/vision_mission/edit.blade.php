@extends('admin.layouts.app')

@section('title', 'Edit Visi & Misi')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.village-official.vision-mission.index') }}">Visi & Misi</a>
    </li>
    <li class="breadcrumb-item" aria-current="page">Edit Visi & Misi</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{ route('admin.village-official.vision-mission.update') }}" method="POST" class="card">
                @csrf
                @method('PUT')
                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Gagal!</strong> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Perhatian!</strong> Mohon periksa kesalahan berikut:
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="vision" class="form-label">Visi <span
                                        class="text-danger">*</span></label>
                                <textarea name="vision" id="vision" class="form-control" placeholder="Masukkan Visi Desa" required>{{ old('vision', $data->vision) }}</textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="mission" class="form-label">Misi <span
                                        class="text-danger">*</span></label>
                                <textarea name="mission" id="mission" class="form-control" placeholder="Masukkan Misi Desa" required>{{ old('mission', $data->mission) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary">Simpan <i class="ti ti-cloud-upload"></i></button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('footer')
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('vision', {
            height: 400,
            filebrowserImageBrowseUrl: '/ckfilemanager?type=Images',
            filebrowserImageUploadUrl: '/ckfilemanager/upload?type=Images&_token=',
            filebrowserBrowseUrl: '/ckfilemanager?type=Files',
            filebrowserUploadUrl: '/ckfilemanager/upload?type=Files&_token='
        });
        CKEDITOR.replace('mission', {
            height: 400,
            filebrowserImageBrowseUrl: '/ckfilemanager?type=Images',
            filebrowserImageUploadUrl: '/ckfilemanager/upload?type=Images&_token=',
            filebrowserBrowseUrl: '/ckfilemanager?type=Files',
            filebrowserUploadUrl: '/ckfilemanager/upload?type=Files&_token='
        });
    </script>
@endsection
